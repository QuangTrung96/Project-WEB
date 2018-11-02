<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'username-or-email' => 'required',
            'password'          => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username-or-email.required' => 'Vui lòng nhập tên truy cập hoặc email của bạn!',
            'password.required'          => 'Vui lòng nhập mật khẩu của bạn!'
        ];
    }
}
