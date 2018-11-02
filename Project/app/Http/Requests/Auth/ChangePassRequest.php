<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassRequest extends FormRequest
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
            'old-password'    => 'required',
            'new-password'    => 'required|min:6',
            're-new-password' => 'required|same:new-password'
        ];
    }

    public function messages()
    {
        return [
            'old-password.required'    => 'Vui lòng nhập mật khẩu cũ của bạn!',
            'new-password.required'    => 'Vui lòng nhập mật khẩu mới!',
            'new-password.min'         => 'Mật khẩu mới tối thiểu là :min ký tự',
            're-new-password.required' => 'Vui lòng nhập xác nhận mật khẩu mới',
            're-new-password.same'     => 'Xác nhận mật khẩu mới và mật khẩu mới không chính xác'
        ];
    }
}
