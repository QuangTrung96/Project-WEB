<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getList()
    {
    	return view('hus.student.list')->with('title', 'Quản lý sinh viên');
    }
}
