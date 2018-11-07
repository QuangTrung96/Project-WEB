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

    public function postAdd(Request $request) 
    {
    	if ($request->ajax()) {
    		$schoYear = $request->get('schoYear');
    		$year = Scholastic::where('year', $schoYear)->first();

    		if ($year) {
    			return response()->json(['status' => 'error', 'mess' => 'Năm học đã tồn tại.']);
    		}

    		$scholastic = new Scholastic();
    		$scholastic->year = $schoYear;
    		$scholastic->save();

    		$str = "<tr id='scho_" . $scholastic->id . "'>";
    		$str .=		"<td class='wredy'>$scholastic->year</td>";
    		$str .=		"<td class='wredy'><a href='javascript:void(0)' onclick='editScho($scholastic->id, \"$scholastic->year\")'>Sửa</a></td>";
    		$str .= 	"<td class='wredy'><a href='javascript:void(0)' onclick='deleteScho($scholastic->id)'>Xóa</a></td>";
    		$str .= "</tr>";

    		return $str;
    	}

    	return redirect()->route('index')->with('error', 'Bạn không thể thực hiện hành động này.');
    }

    public function postEdit() {
        die('123');
    }
}
