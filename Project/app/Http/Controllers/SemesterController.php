<?php

namespace App\Http\Controllers;

use App\Semester;
use App\Scholastic;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function getList()
    {
    	$semesters = Semester::all();
    	$scholastics = Scholastic::pluck('year', 'id');
    	return view('hus.semester.list', ['semesters' => $semesters,'scholastics' => $scholastics])->with('title', 'Quản lý học kỳ');
    }
}
