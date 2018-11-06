<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username-or-email'    => 'required',
            'g-recaptcha-response' => 'required|recaptcha'
        ];
    }

    public function messages()
    {
        return [
            'username-or-email.required'     => 'Vui lòng nhập tên truy cập hoặc email của bạn!',
            'g-recaptcha-response.required'  => 'Trường reCAPTCHA không được bỏ trống!',
            'g-recaptcha-response.recaptcha' => 'Trường reCAPTCHA không chính xác!'
        ];
    }
}
