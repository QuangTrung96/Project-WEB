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
    	$subjects = Subject::orderBy('id', 'desc')->paginate(5);
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
            $collection = DB::table('scholastics')
                ->join('semesters', 'scholastics.id', '=', 'semesters.scholastic_id')
                ->select(DB::raw("CONCAT(semesters.semester_name, ' ', scholastics.year) as name, semesters.id"))
                ->orderBy('scholastics.year')
                ->orderBy('semesters.semester_name')
                ->get();
    
            $semesters = $collection->pluck('name', 'id');
        }

    	return view('hus.subject.list', ['subjects' => $subjects, 'users' => $users, 'semesters' => $semesters, 'credits' => $credits])->with('title', 'Quản lý môn học');
    }

    public function postAdd(Request $request)
    {
        if ($request->ajax()) {
            $subjectCode     = $request->get('subjectCode');
            $subjectName     = $request->get('subjectName');
            $userID          = $request->get('userID');
            $numberOfCredits = $request->get('numberOfCredits');
            $semesterID      = $request->get('semesterID');

            $result = Subject::where('subject_code', $subjectCode)
                             ->orWhere('subject_name', $subjectName)
                             ->first();

            if ($result) {
                return response()->json([
                    'status' => 'error', 
                    'mess'   => 'Môn học này đã tồn tại !!!'
                ]);
            }

            $subject = new Subject();
            $subject->subject_code      = strtoupper($subjectCode);
            $subject->subject_name      = ucwords($subjectName);
            $subject->user_id           = $userID;
            $subject->number_of_credits = $numberOfCredits;
            $subject->semester_id       = $semesterID;
            $subject->save();

            $full_name = $subject->user->last_name . ' ' . $subject->user->first_name;

            $str  = "<tr id='subj_" . $subject->id . "'>";
            $str .=     "<td class='wredy'>$subject->subject_code</td>";
            $str .=     "<td class='wredy'>$subject->subject_name</td>";
            $str .=     "<td class='wredy'>" . $full_name . "</td>";
            $str .=     "<td class='wredy'>$subject->number_of_credits</td>";
            $str .=     "<td class='wredy'>" . $subject->semester->semester_name . "</td>";
            $str .=     "<td class='wredy'><a href='javascript:void(0)' onclick='editSubj($subject->id, \"$subject->subject_code\", \"$subject->subject_name\", $subject->user_id, $subject->number_of_credits, $subject->semester_id)'>Sửa</a></td>";
            $str .=     "<td class='wredy'><a href='javascript:void(0)' onclick='deleteSubj($subject->id)'>Xóa</a></td>";
            $str .= "</tr>";

            return $str;
        }

        return redirect()->route('index')->with('error', 'Bạn không thể thực hiện hành động này !!!');
    }

    public function postEdit(Request $request)
    {
        if ($request->ajax()) {
            $subjID          = $request->get('subjID');
            $subjectCode     = strtoupper($request->get('subjectCode'));
            $subjectName     = ucwords($request->get('subjectName'));
            $userID          = $request->get('userID');
            $numberOfCredits = $request->get('numberOfCredits');
            $semesterID      = $request->get('semesterID');

            $result = Subject::where('id', '!=', $subjID)
                             ->where('subject_code', $subjectCode)
                             ->orWhere('id', '!=', $subjID)
                             ->where('subject_name', $subjectName)
                             ->first();

            if ($result) {
                return response()->json([
                    'status' => 'error', 
                    'mess'   => 'Môn học này đã tồn tại !!!'
                ]);
            }

            $subject = Subject::findOrFail($subjID);
            $subject->subject_code      = $subjectCode;
            $subject->subject_name      = $subjectName;
            $subject->user_id           = $userID;
            $subject->number_of_credits = $numberOfCredits;
            $subject->semester_id       = $semesterID;
            $subject->save();

            $full_name = $subject->user->last_name . ' ' . $subject->user->first_name;

            $str  =     "<td class='wredy'>$subject->subject_code</td>";
            $str .=     "<td class='wredy'>$subject->subject_name</td>";
            $str .=     "<td class='wredy'>" . $full_name . "</td>";
            $str .=     "<td class='wredy'>$subject->number_of_credits</td>";
            $str .=     "<td class='wredy'>" . $subject->semester->semester_name . "</td>";
            $str .=     "<td class='wredy'><a href='javascript:void(0)' onclick='editSubj($subject->id, \"$subject->subject_code\", \"$subject->subject_name\", $subject->user_id, $subject->number_of_credits, $subject->semester_id)'>Sửa</a></td>";
            $str .=     "<td class='wredy'><a href='javascript:void(0)' onclick='deleteSubj($subject->id)'>Xóa</a></td>";

            return $str;
        }

        return redirect()->route('index')->with('error', 'Bạn không thể thực hiện hành động này !!!');
    }

    public function getDelete($id, Request $request) 
    {
        if ($request->ajax()) {
            $subject = Subject::findOrFail($id);
            $subject->delete();
            
            return response()->json([
                'status' => 'success',
                'mess'   => 'Xóa môn học thành công !!!'
            ]);
        }
        
        return redirect()->route('index')
                         ->with('error', 'Bạn không thể thực hiện hành động này !!!');
    }
}
