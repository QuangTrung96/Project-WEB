<?php

namespace App\Http\Requests\Point;

use Illuminate\Foundation\Http\FormRequest;

class AddEditRequest extends FormRequest
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
            'subject_code' => 'required|exists:subjects,subject_code',
            'student_code' => 'required|exists:students,student_code',
            'point'        => 'required|numeric|min:0|max:10',
            'exam_day'    => 'required|date|date_format:Y-m-d'
        ];
    }

    public function messages()
    {
        return [
            'subject_code.required'  => 'Vui lòng nhập Mã môn học',
            'student_code.required'  => 'Vui lòng nhập Mã sinh viên',
            'point.required'         => 'Vui lòng nhập Điểm thi',
            'exam_day.required'     => 'Vui lòng nhập Ngày thi',
            'subject_code.exists'    => 'Mã môn học nhập vào không có trong hệ thống',
            'student_code.exists'    => 'Mã sinh viên nhập vào không có trong hệ thống',
            'point.numeric'          => 'Vui lòng nhập số với Điểm thi',
            'point.min'              => 'Điểm thi nhập vào không được nhỏ hơn :min',
            'point.max'              => 'Điểm thi nhập vào không được lớn hơn :max',
            'exam_day.date'         => 'Ngày thi nhập vào không hợp lệ',
            'exam_day.date_format'  => 'Ngày thi phải có định dạng là: m/d/Y'
        ];
    }
}
