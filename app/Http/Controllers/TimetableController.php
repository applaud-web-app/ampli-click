<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AllotBatch;
use App\Models\Batch;
use App\Models\Category;
use App\Models\StudentAttendance;
use App\Models\Subjects;
use App\Models\Teachers;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use Auth;

class TimetableController extends Controller
{
    public function teachersTimeTable(Request $request){
        $data['courses'] = Category::select('id','title')->where('status',1)->get();
        $courseId = $request->course > 0 ? $request->course : 0;
        $batchId = $request->batch > 0 ? $request->batch : 0;
        $data['course'] = $courseId;
        $data['batch'] = $batchId;
        $data['date'] = $request->date;
        $batches = [];
        $subjects = [];
        $timetableData = [];
        $showTable = 0;
        if($courseId){
            $batches = Batch::select('id','name')->where(['categories_id'=>$courseId,'status'=>1])->get();
            $subjects = Subjects::select('id','sub_name')->where(['categories_id'=>$courseId,'status'=>1])->get();
            $showTable = 1;
            $timetableDataAll = TimeTable::where(['t_date'=>$request->date,'batch_id'=>$batchId,'course_id'=>$courseId])->get();
            foreach($timetableDataAll as $val){
                $timetableData[$val->subject_id] = $val;
            }
        }
        $data['batches'] = $batches;
        $data['subjects'] = $subjects;
        $data['showTable'] = $showTable;
        $data['timetableData'] = $timetableData;
        $data['teachers'] = Teachers::select('id','teacher_name')->where('status',1)->get();
        return view('time-table.teachers-time-table',$data);
    }

    public function getBatchWithCourse(Request $request){
        $courseId = $request->id;
        $batchData = Batch::select('id','name')->where(['categories_id'=>$courseId,'status'=>1])->get();
        return response()->json($batchData);
    }

    public function storeTeacherTimetable(Request $request){
        $insArr = [];
        // TimeTable::where(['t_date'=>$request->date,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id])->delete();
        foreach($request->teacher as $k=>$val){
            if($request->teacher[$k]!=null && $request->start_time[$k]!=null && $request->end_time[$k]!=null){
               if($request->old_t_d[$k] > 0){
                    TimeTable::where('id',$request->old_t_d[$k])->update([
                        'teacher_id'=>$request->teacher[$k],
                        'start_date_time'=>date("Y-m-d H:i:s",strtotime($request->date.' '.$request->start_time[$k])),
                        'end_date_time'=>date("Y-m-d H:i:s",strtotime($request->date.' '.$request->end_time[$k])),
                        'course_id'=>$request->course_id,
                        'batch_id'=>$request->batch_id,
                        't_date'=>$request->date,
                        'subject_id'=>$k,
                        'updated_at'=>date("Y-m-d H:i:s"),
                    ]);
               }else{
                    $insArr[] = [
                        'teacher_id'=>$request->teacher[$k],
                        'start_date_time'=>date("Y-m-d H:i:s",strtotime($request->date.' '.$request->start_time[$k])),
                        'end_date_time'=>date("Y-m-d H:i:s",strtotime($request->date.' '.$request->end_time[$k])),
                        'course_id'=>$request->course_id,
                        'batch_id'=>$request->batch_id,
                        't_date'=>$request->date,
                        'subject_id'=>$k,
                        'created_at'=>date("Y-m-d H:i:s"),
                        'updated_at'=>date("Y-m-d H:i:s"),
                    ];
               }
                
            }
        }
        if($insArr){
            TimeTable::insert($insArr);
            return redirect()->back()->with('success','Timetable added successfully...');
        }
        
        return redirect()->back()->with('success','Timetable added successfully...');;
    }

    public function learnersAttendance(Request $request){
        $date = !empty($request->date) ? $request->date : date("Y-m-d");
        $data['date'] = $date;
        $data['attendaceData'] = TimeTable::with('subject')->with('batch')->with('course')->where('t_date',$date)->paginate(50);
        return view('time-table.learners-attendance',$data);
    }

    public function takeAttendance($timetableId){
        $timetableData = TimeTable::with('subject:id,sub_name')->with('batch:id,name')->with('course:id,title')->find($timetableId);
        $data['studentData'] = \DB::table('allot_batches')->select('s.id','fname','lname','image')->join('students as s','s.id','students_id')->where(['batches_id'=>$timetableData->batch_id,'subjects_id'=>$timetableData->subject_id,'s.status'=>1])->orderBy('fname','ASC')->get();
        $data['timetableData'] = $timetableData;
        $data['attData'] = StudentAttendance::where(['batch_id'=>$timetableData->batch_id,'subject_id'=>$timetableData->subject_id,'att_date'=>$timetableData->t_date])->pluck('att_status','student_id')->toArray();
        return view('time-table.take-attendance',$data);
    }

    public function storeStudentAttendance(Request $request){
        $checkAttData = StudentAttendance::where(['batch_id'=>$request->batch_id,'subject_id'=>$request->subject_id,'att_date'=>$request->date])->pluck('student_id')->toArray();
        $tId = 0;
        if(Auth::check()){
            $tId = Auth::id();
        }
        if(Auth::guard('teacher')->check()){
            $tId = Auth::guard('teacher')->user()->id;
        }
        $insArr = [];
        foreach($request->attendace as $k=>$v){
            if(in_array($k,$checkAttData)){
                StudentAttendance::where(['batch_id'=>$request->batch_id,'subject_id'=>$request->subject_id,'att_date'=>$request->date,'student_id'=>$k])->update([
                    'att_status'=>$v,
                    'updated_at'=>date("Y-m-d H:i:s"),
                ]);
            }else{
                $insArr[] = [
                    'student_id'=>$k,
                    'batch_id'=>$request->batch_id,
                    'subject_id'=>$request->subject_id,
                    'att_status'=>$v,
                    'att_date'=>$request->date,
                    'created_by'=>$tId,
                    'updated_by'=>$tId,
                    'created_at'=>date("Y-m-d H:i:s"),
                    'updated_at'=>date("Y-m-d H:i:s"),
                ];
            }
        }
        if($insArr){
            StudentAttendance::insert($insArr);
        }
        return redirect()->back()->with('success','Attendance marked successfully...');
    }

}
