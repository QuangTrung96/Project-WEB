<?php

namespace App\Http\Controllers;

use DB;
use App\Student;
use Illuminate\Http\Request;
use App\Http\Requests\Student\AddRequest;
use App\Http\Requests\Student\EditRequest;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('keyword')){
            $keyword = $request->get('keyword');
            $students = Student::where('student_code','like','%'. $keyword .'%')->paginate(3);
        } else {
            $students = Student::paginate(3);
        }

    	return view('hus.student.index', ['students' => $students])->with('title', 'Quản lý sinh viên');
    }

    public function create()
    {
    	return view('hus.student.create')->with('title', 'Thêm sinh viên');
    }

    public function store(AddRequest $request)
    {
        $attributes = '';
        if ($request->has('attributes') && is_array($request->get('attributes')) && count($request->get('attributes')) > 0) {
            $attributes = $request->get('attributes');
            foreach ($attributes as $key => $attribute) {
                if (!isset($attribute['name'])) {
                    unset($attributes[$key]);
                    continue;
                }

                if (!isset($attribute['value'])) {
                    unset($attributes[$key]);
                    continue;
                }
            }

            $attributes = json_encode($attributes, JSON_UNESCAPED_UNICODE);
        }

        $student = new Student();
        $student->student_code = mb_strtoupper($request->get('student_code'), 'UTF-8');
        $student->last_name    = mb_convert_case($request->get('last_name'), MB_CASE_TITLE, 'UTF-8');
        $student->first_name   = mb_convert_case($request->get('first_name'), MB_CASE_TITLE, 'UTF-8');
        $student->birthday     = $request->get('birthday');
        $student->gender       = $request->get('gender');
        $student->address      = mb_convert_case($request->get('address'), MB_CASE_TITLE, 'UTF-8');
        $student->attributes   = $attributes;
        $student->save();

        return redirect()->route('student.index')->with('success', "Thêm sinh viên thành công !!!");
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('hus.student.show', ['student' => $student])->with('title', 'Sửa sinh viên');
    }

    public function update(EditRequest $request, $id)
    {
        $attributes = '';
        if ($request->has('attributes') && is_array($request->get('attributes')) && count($request->get('attributes')) > 0) {
            $attributes = $request->get('attributes');
            foreach ($attributes as $key => $attribute) {
                if (!isset($attribute['name'])) {
                    unset($attributes[$key]);
                    continue;
                }

                if (!isset($attribute['value'])) {
                    unset($attributes[$key]);
                    continue;
                }
            }

            $attributes = json_encode($attributes, JSON_UNESCAPED_UNICODE);
        }

        $student = Student::findOrFail($id);
        $student->student_code = mb_strtoupper($request->get('student_code'), 'UTF-8');
        $student->last_name    = mb_convert_case($request->get('last_name'), MB_CASE_TITLE, 'UTF-8');
        $student->first_name   = mb_convert_case($request->get('first_name'), MB_CASE_TITLE, 'UTF-8');
        $student->birthday     = $request->get('birthday');
        $student->gender       = $request->get('gender');
        $student->address      = mb_convert_case($request->get('address'), MB_CASE_TITLE, 'UTF-8');
        $student->attributes   = $attributes;
        $student->save();

        $link = route("student.show", ['id' => $student->id]);
        
        return redirect()->route("student.index")->with(['success' => 'Cập nhật sinh viên thành công !!!, ', 'link' => $link]);
    }

    public function delete($id)
    {
        $student = Student::findOrFail($id);
        if ($student->point->count() == 0) {
            $student->delete();
            return redirect()->route('student.index')->with('success', "Thực hiện xóa thành công !!!");
        }

        return redirect()->route('student.index')->with('error', "Bạn không thể xóa sinh viên này !!!");
    }
}
