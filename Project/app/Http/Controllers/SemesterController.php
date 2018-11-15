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
        $scholastics = [
            '0' => '---'
        ];

        if (Scholastic::all()->count()) {
            $scholastics = Scholastic::pluck('year', 'id');
        }
    	
    	return view('hus.semester.list', ['semesters' => $semesters,'scholastics' => $scholastics])->with('title', 'Quản lý học kỳ');
    }

    public function postAdd(Request $request)
    {
    	if ($request->ajax()) {
    		$semesterName = $request->get('semesterName');
            $scholasticID = $request->get('scholasticID');
            $result = Semester::where('semester_name', $semesterName)
                              ->where('scholastic_id', $scholasticID)
                              ->first();

    		if ($result) {
    			return response()->json([
                    'status' => 'error', 
                    'mess' => $semesterName . ' năm ' . $result->scholastic->year . ' đã tồn tại.'
                ]);
    		}

    		$semester = new Semester();
            $semester->semester_name = $semesterName;
    		$semester->scholastic_id = $scholasticID;
    		$semester->save();

    		$str  = "<tr id='seme_" . $semester->id . "'>";
            $str .=     "<td class='wredy'>$semester->semester_name</td>";
    		$str .=		"<td class='wredy'>" . $semester->scholastic->year . "</td>";
    		$str .=		"<td class='wredy'><a href='javascript:void(0)' onclick='editSeme($semester->id, \"$semester->semester_name\", $semester->scholastic_id)'>Sửa</a></td>";
    		$str .= 	"<td class='wredy'><a href='javascript:void(0)' onclick='deleteSeme($semester->id)'>Xóa</a></td>";
    		$str .= "</tr>";

    		return $str;
    	}

    	return redirect()->route('index')->with('error', 'Bạn không thể thực hiện hành động này.');
    }

    public function postEdit(Request $request)
    {
        if ($request->ajax()) {
            $semeID = $request->get('semeID');
            $semesterName = $request->get('semesterName');
            $scholasticID = $request->get('scholasticID');

            $result = Semester::where('semester_name', $semesterName)
                              ->where('scholastic_id', $scholasticID)
                              ->where('id', '!=', $semeID)
                              ->first();

            if ($result) {
                return response()->json([
                    'status' => 'error', 
                    'mess' => $semesterName . ' năm ' . $result->scholastic->year . ' đã tồn tại.'
                ]);
            }

            $semester = Semester::findOrFail($semeID);
            $semester->semester_name = $semesterName;
            $semester->scholastic_id = $scholasticID;
            $semester->save();

            $str  =     "<td class='wredy'>$semester->semester_name</td>";
            $str .=     "<td class='wredy'>" . $semester->scholastic->year . "</td>";
            $str .=     "<td class='wredy'><a href='javascript:void(0)' onclick='editSeme($semester->id, \"$semester->semester_name\", $semester->scholastic_id)'>Sửa</a></td>";
            $str .=     "<td class='wredy'><a href='javascript:void(0)' onclick='deleteSeme($semester->id)'>Xóa</a></td>";

            return $str;
        }

        return redirect()->route('index')->with('error', 'Bạn không thể thực hiện hành động này.');
    }

    public function getDelete($id, Request $request) 
    {
        if ($request->ajax()) {
            $semester = Semester::findOrFail($id);
            $semester->delete();
            return response()->json(['status' => 'success', 'mess' => 'Xóa học kỳ thành công.']);
        }
        
        return redirect()->route('index')
                         ->with('error', 'Bạn không thể thực hiện hành động này.');
    }
}
