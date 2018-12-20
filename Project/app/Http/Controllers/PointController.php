<?php

namespace App\Http\Controllers;

use DB;
use App\Point;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\Point\AddRequest;
use App\Http\Requests\Point\EditRequest;

class PointController extends Controller
{
    public function index(Request $request)
    {
        $points = Point::join('subjects','points.subject_code', '=', 'subjects.subject_code')
                       ->select('points.id', 'points.subject_code', 'points.student_code', 'points.point', 'points.exam_day', 'subjects.subject_name');

        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
            $points  = $points->where('points.student_code', 'like', '%' . $keyword . '%')
                              ->orWhere('points.subject_code', 'like', '%' . $keyword . '%')
                              ->orWhere('subjects.subject_name', 'like', '%' . $keyword . '%');
        }

        $points = $points->orderBy('points.id', 'desc')
                         ->paginate(5);

    	return view('hus.point.index', compact('points'))->with('title', 'Quản lý điểm');
    }

    public function create()
    {
        $subjects = [
            '0' => '---'
        ];

        if (Subject::all()->count()) {
            $collection = Subject::select(DB::raw("CONCAT(subject_code, ': ', subject_name) as full_name, subject_code"));
            $subjects = $collection->pluck('full_name', 'subject_code');
        }

        return view('hus.point.create', compact('subjects'))->with('title', 'Thêm điểm');
    }

    public function store(AddRequest $request)
    {
        $point2       = $request->get('point');
        $exam_day     = $request->get('exam_day');
        $subject_code = $request->get('subject_code');
        $student_code = $request->get('student_code');

        $result = Point::where('student_code', $student_code)
                       ->where('subject_code', $subject_code)
                       ->first();

        if ($result) {
            return redirect()->back()->withInput()->with('error', 'Sinh viên này đã có điểm của môn học này !!!');
        }

        $point = new Point();
        $point->point        = $point2;
        $point->exam_day     = $exam_day;
        $point->student_code = $student_code;
        $point->subject_code = $subject_code;
        $point->save();

        return redirect()->route('point.index')->with('success', 'Thêm điểm cho sinh viên thành công !!!'); 
    }

    public function show($id)
    {
        $collection = Subject::select(DB::raw("CONCAT(subject_code, ': ', subject_name) as full_name, subject_code"));
        $subjects = $collection->pluck('full_name', 'subject_code');

        $point = Point::findOrFail($id);
        return view('hus.point.show', compact('point', 'subjects'))->with('title', 'Sửa điểm');
    }

    public function update(EditRequest $request, $id)
    {
        $point = Point::findOrFail($id);
        $point->point = $request->get('point');
        $point->exam_day = $request->get('exam_day');
        $point->subject_code = $request->get('subject_code');
        $point->student_code = $request->get('student_code');
        $point->save();

        return redirect()->route("point.index")->with(['success' => 'Cập nhật điểm cho sinh viên thành công !!!']);
    }

    public function delete($id)
    {
        $point = Point::findOrFail($id);
        $point->delete();

        return redirect()->route('point.index')->with('success', "Thực hiện xóa thành công !!!");
    }
}
