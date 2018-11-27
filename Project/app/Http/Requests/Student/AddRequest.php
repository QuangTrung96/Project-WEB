<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'student_code' => 'required|unique:students,student_code',
            'last_name'    => 'required',
            'first_name'   => 'required',
            'birthday'     => 'required|date|date_format:Y-m-d',
            'address'      => 'required'
        ];
    }

    public function messages()
    {
        return [
            'student_code.required'  => 'Vui lòng nhập Mã sinh viên',
            'last_name.required'     => 'Vui lòng nhập Họ đệm',
            'first_name.required'    => 'Vui lòng nhập Tên',
            'birthday.required'      => 'Vui lòng nhập Ngày sinh',
            'address.required'       => 'Vui lòng nhập Địa chỉ',
            'student_code.unique'    => 'Mã sinh viên đã tồn tại, vui lòng nhập mã khác',
            'birthday.date'          => 'Ngày sinh nhập vào không hợp lệ',
            'birthday.date_format'   => 'Ngày sinh phải có định dạng là: m/d/Y'
        ];
    }
}
