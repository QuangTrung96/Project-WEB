<?php

namespace App\Http\Controllers;

use DB;
use App\Point;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\Point\AddEditRequest;

class PointController extends Controller
{
    public function index()
    {
    	$subjects = [
    		'0' => '---'
    	];

    	if (Subject::all()->count()) {
            $collection = Subject::select(DB::raw("CONCAT(subject_code, ': ', subject_name) as full_name, subject_code"));
            $subjects = $collection->pluck('full_name', 'subject_code');
        }

        $points = Point::all();

    	return view('hus.point.index', compact('points', 'subjects'))->with('title', 'Quản lý điểm');
    }

    public function store(AddEditRequest $request)
    {

    }
}
