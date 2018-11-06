<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scholastic;

class ScholasticController extends Controller
{
    public function getList()
    {
    	$scholastics = Scholastic::all();
    	return view('hus.scholastic.list', ['scholastics' => $scholastics])->with('title', 'Quản lý năm học');
    }
}
