<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Requests\Student\AddRequest;

class StudentController extends Controller
{
    public function index()
    {
    	$students = Student::paginate(3);
    	return view('hus.student.index', ['students' => $students])->with('title', 'Quản lý sinh viên');
    }

    public function create()
    {
    	return view('hus.student.create')->with('title', 'Thêm sinh viên');
    }

    public function store(AddRequest $request)
    {
        $attributes = '';
        if ($request->has('attributes') && is_array($request->get('attributes')) && count($request->get('attributes') > 0)) {
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
        $student->student_code = $request->get('student_code');
        $student->last_name    = $request->get('last_name');
        $student->first_name   = $request->get('first_name');
        $student->birthday     = $request->get('birthday');
        $student->gender       = $request->get('gender');
        $student->address      = $request->get('address');
        $student->attributes   = $attributes;
        $student->save();

        return redirect()->route('student.index')->with('success', "Thêm sinh viên thành công !!!");
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('hus.student.show', ['student' => $student])->with('title', 'Sửa sinh viên');
    }

    public function delete($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('student.index')->with('success', "Thực hiện xóa thành công !!!");
    }
}
