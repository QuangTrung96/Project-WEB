<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Subject;
use App\Semester;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function getList()
    {
    	$subjects = Subject::all();
        $credits = [
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5'
        ];

        $semesters = [
            '0' => '---'
        ];

        if (User::all()->count()) {
            $collection = User::select(DB::raw("CONCAT(last_name, ' ', first_name) as full_name, id"));
            $users = $collection->pluck('full_name', 'id');
        }

        if (Semester::all()->count()) {
            $semesters = Semester::pluck('semester_name', 'id');
        }

    	return view('hus.subject.list', ['subjects' => $subjects, 'users' => $users, 'semesters' => $semesters, 'credits' => $credits])->with('title', 'Quản lý môn học');
    }
}
