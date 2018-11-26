<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
    	$students = Student::all();
    	return view('hus.student.index', ['students' => $students])->with('title', 'Quản lý sinh viên');
    }

    public function create()
    {
    	return view('hus.student.create')->with('title', 'Thêm sinh viên');
    }
}
