<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() 
    {
    	return view('hus.index')->with('title', 'Trường Đại học Khoa học Tự nhiên | ĐHQGHN');
    }
}
