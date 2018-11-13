<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function getList()
    {
    	$subjects = Subject::all();
    	return view('hus.subject.list', ['subjects' => $subjects])->with('title', 'Quản lý môn học');
    }
}
