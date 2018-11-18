<?php

namespace App\Http\Controllers;

use App\Scholastic;
use Illuminate\Http\Request;

class ScholasticController extends Controller
{
    public function getList()
    {
    	$scholastics = Scholastic::orderBy('year', 'desc')->paginate(5);
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

    		$str  = "<tr id='scho_" . $scholastic->id . "'>";
    		$str .=		"<td class='wredy'>$scholastic->year</td>";
    		$str .=		"<td class='wredy'><a href='javascript:void(0)' onclick='editScho($scholastic->id, \"$scholastic->year\")'>Sửa</a></td>";
    		$str .= 	"<td class='wredy'><a href='javascript:void(0)' onclick='deleteScho($scholastic->id)'>Xóa</a></td>";
    		$str .= "</tr>";

    		return $str;
    	}

    	return redirect()->route('index')->with('error', 'Bạn không thể thực hiện hành động này.');
    }

    public function postEdit(Request $request) 
    {
        if ($request->ajax()) {
            $schoID = $request->get('schoID');
            $schoYear = $request->get('schoYear');
            $checkScho = Scholastic::where('year', $schoYear)
                                   ->where('id', '!=', $schoID)
                                   ->first();
            if ($checkScho) {
                return response()->json(['status' => 'error', 'mess' => 'Năm học này đã tồn tại.']);
            }

            $scholastic = Scholastic::findOrFail($schoID);
            $scholastic->year = $schoYear;
            $scholastic->save();

            $str  = "<td class='wredy'>$scholastic->year</td>";
            $str .= "<td class='wredy'><a href='javascript:void(0)' onclick='editScho($scholastic->id, \"$scholastic->year\")'>Sửa</a></td>";
            $str .= "<td class='wredy'><a href='javascript:void(0)' onclick='deleteScho($scholastic->id)'>Xóa</a></td>";

            return $str;
        }

        return redirect()->route('index')->with('error', 'Bạn không thể thực hiện hành động này.');
    }

    public function getDelete($id, Request $request) 
    {
        if ($request->ajax()) {
            $scholastic = Scholastic::findOrFail($id);
            if ($scholastic->semester->count() == 0) {
                $scholastic->delete();
                return response()->json(['status' => 'success', 'mess' => 'Xóa năm học thành công.']);
            }
            
            return response()->json(['status' => 'error', 'mess' => 'Bạn không thể xóa năm học này.']);
        }
        
        return redirect()->route('index')
                         ->with('error', 'Bạn không thể thực hiện hành động này.');
    }
}
