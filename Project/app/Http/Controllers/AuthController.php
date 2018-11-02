<?php

namespace App\Http\Controllers;

use Mail;
use Sentinel;
use Reminder;
use Activation;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotRequest;
use App\Http\Requests\Auth\ChangePassRequest;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class AuthController extends Controller
{
    public function postLogin(LoginRequest $request) 
    {
    	try {
    		$dataLogin = [
						'login'    => $request->get('username-or-email'),
						'password' => $request->get('password')
					];

            $remember_me = (bool) $request->get('remember-me') ? true : false;

            if (Sentinel::authenticate($dataLogin, $remember_me)) {
                return redirect()->route('index')->with('success', 'Đăng nhập thành công!');
            } else {
                $error = 'Tên đăng nhập, email hoặc mật khẩu không đúng!';
 			}
        } catch (NotActivatedException $e) {
            $error = 'Tài khoản của bạn chưa được kích hoạt!';
        } catch (ThrottlingException $e) {
            $error = 'Tài khoản của bạn bị block trong vòng ' . $e->getDelay() . ' sec!';
        }

        return redirect()->back()->withInput()->with('error', $error);
    }

    public function getLogin()
    {
    	return view('hus.member.login')->with('title', 'Đăng nhập');
    }

    public function getLogout()
    {
        Sentinel::logout();
        return redirect()->route('index')->with('success', 'Đăng xuất thành công!');
    }

    public function getChangePass()
    {
        return view('hus.member.changepass')->with('title', 'Sửa mật khẩu');
    }

    public function postChangePass(ChangePassRequest $request)
    {
        $credentials = [
            'username' => Sentinel::getUser()->username,
            'email'    => Sentinel::getUser()->email,
            'password' => $request->get('old-password')
        ];

        $user = Sentinel::getUser();
        $result = Sentinel::validateCredentials($user, $credentials);

        if ($result) {
            $attribute = [
                'password' => $request->get('new-password')
            ];
            Sentinel::update($user, $attribute);

            return redirect()->route('changepass_get')
                             ->with('success', 'Thay đổi mật khẩu thành công!');
        }

        return redirect()->route('changepass_get')
                         ->with('error', 'Mật khẩu cũ không chính xác!');
    }

    public function getForgot()
    {
        return view('hus.member.forgot')->with('title', 'Forgot your password');
    }

    public function postForgot(ForgotRequest $request) {
        $result = Sentinel::findUserByCredentials([
            'login' => $request->get('username-or-email')
        ]);

        if ($result) {
            if (Activation::completed($result)) {
                Reminder::removeExpired();
                $exists = Reminder::exists($result);
                if ($exists != false) {
                    $code = $exists->code;
                } else {
                    $reminder = Reminder::create($result);
                    $code = $reminder->code;
                }

                $dataEmail = [
                    'code'       => $code,
                    'email'      => $result->email,
                    'username'   => $result->username,
                    'full_name'  => $result->last_name . ' ' . $result->first_name
                ];

                Mail::send('mails.active_code', $dataEmail, function($mess) use ($dataEmail) {
                    $mess->from(env('MAIL_USERNAME'), 'No-reply Email');
                    $mess->to($dataEmail['email'], $dataEmail['full_name']);
                    $mess->subject('Change password');
                });

                return redirect()->route('forgot_get')->with('success', 'Please check your email!');
            }

            return redirect()->route('forgot_get')->with('error', 'Account not yet validated. Please check your email!');
        }

        return redirect()->route('forgot_get')->with('error', 'Username or Email was not found!');
    }

    public function getActiveReset($username, $code) {
        Reminder::removeExpired();
        $user = Sentinel::findUserByCredentials(['username' => $username]);
        if ($user) {
            $exists = Reminder::exists($user, $code);
            if ($exists) {
                $newPass = str_random(12);
                Reminder::complete($user, $code, $newPass);

                $dataEmail = [
                    'password' => $newPass,
                    'email' => $user->email,
                    'username' => $user->username,
                    'full_name' => $user->last_name . ' ' . $user->first_name
                ];
                
                Mail::send('mails.reset_pass', $dataEmail, function($mess) use($dataEmail) {
                    $mess->from(env('MAIL_USERNAME'), 'No-reply Email');
                    $mess->to($dataEmail['email'], $dataEmail['full_name']);
                    $mess->subject('Your new password on the hus.vnu.edu.vn');
                });

                return redirect()->route('forgot_get')->with('success', 'The new password was sent to your email!');
            }

            return redirect()->route('forgot_get')->with('error', 'Can not retrieve password!');
        }

        return redirect()->route('forgot_get')->with('error', 'Username was not found!');
    }
}
