<?php

namespace App\Http\Controllers;

use App\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function getList()
    {
    	$points = Point::first();
    	return view('hus.point.list', ['points' => $points])->with('title', 'Quản lý điểm');
    }
}
