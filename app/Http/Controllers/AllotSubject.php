<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\StudentController;
use App\Models\AllotBatch;
use App\Models\Teachers;
use App\Models\User;
use App\Models\Subjects;
use App\Models\Category;

class AllotSubject extends Controller
{
    public function index($id){

        // Active batch Student
        $student_id = \DB::table('allot_batches')
        ->select('students_id')
        ->WHERE('batches_id', '=',$id)->get();

        $arry = $student_id->toArray();
        $row = [];
        foreach( $arry as $rr){
            $row[] += $rr->students_id ;
        };

        $student = \DB::table('students')
        ->leftJoin('parents', 'parents.students_id', '=', 'students.id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last','parents.email As p_email','parents.number As p_number')
        ->Where('students.status','=','1')
        ->whereNotIn('students.id', $row)->get();

        // Inactive Bath Student
        $Inactive = \DB::table('allot_batches')
        ->select('students_id')
        ->where('status','=',2)
        ->WHERE('batches_id', '=',$id)->get();

        $arry = $Inactive->toArray();
        $row2 = [];
        foreach( $arry as $rr){
            $row2[] += $rr->students_id ;
        };

        $Inactivestudent = \DB::table('students')
        ->leftJoin('parents', 'parents.students_id', '=', 'students.id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last','parents.email As p_email','parents.number As p_number')
        ->Where('students.status','=','1')
        ->whereIn('students.id', $row2)->get();


        // Active Student
        $Active = \DB::table('allot_batches')
        ->select('students_id')
        ->where('status','=',1)
        ->WHERE('batches_id', '=',$id)->get();

        $arry = $Active->toArray();
        $row3 = [];
        foreach( $arry as $rr){
            $row3[] += $rr->students_id ;
        };

        $Activestudent = \DB::table('students')
        ->leftJoin('parents', 'parents.students_id', '=', 'students.id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last','parents.email As p_email','parents.number As p_number')
        ->Where('students.status','=','1')
        ->whereIn('students.id', $row3)->get();

        return view('user.allot-batch',['students'=>$student,'Inactivestudents'=>$Inactivestudent,'Activestudents'=>$Activestudent],['batch_id'=>$id]);
    }

    public function allotBatch(Request $req){
        $req->validate([
            'allotCourse'=>'required'
        ],[
            'allotCourse'=>'Please Select a Student!!'
        ]);

        if(!is_string($req->allotCourse)){
            foreach($req->allotCourse as $student) {
                $users = new AllotBatch;
                $users->students_id = $student;
                $users->batches_id  = $req->bId;
                $users->save();
            }
            
            return redirect()->back()->with('success','Batch Alloted Successfully!!');
        }
        return redirect()->back()->with('error','Please Select a Student!!');
    }

    public function activeStudentbatch(Request $req){
        $req->validate([
            'unactiveCourse'=>'required'
        ],[
            'unactiveCourse'=>'Please Select a Student!!'
        ]);
        
        if(!is_string($req->unactiveCourse)){
            foreach($req->unactiveCourse as $student) {
                $users = AllotBatch::WHERE('students_id','=',$student)->first();
                $users->status = 1;
                $users->save();
            }
           return redirect()->back()->with('success','Student Batch Active Successfully!!');
        }
        return redirect()->back()->with('error','Please Select a Student!!');
    }

    public function unallotBatch(Request $req){
        $req->validate([
            'unallotedCourse'=>'required'
        ],[
            'unallotedCourse'=>'Please Select a Student!!'
        ]);
        
        if(!is_string($req->allotCourse)){
            foreach($req->unallotedCourse as $student) {
                $users = AllotBatch::WHERE('students_id','=',$student)->first();
                $users->status = 2;
                $users->save();
            }
            
            return redirect()->back()->with('success','Batch Unalloted Successfully!!');
       }
       return redirect()->back()->with('error','Please Select a Student!!');
    }

    public function studentAllotBatch($id){

        // $batchID = \DB::table('allot_batches')
        // ->select('batches_id')
        // ->where('status','=','1')
        // ->WHERE('students_id', '=',$id)->get();


        // $arry = $batchID->toArray();
        // $row = [];
        // foreach( $arry as $rr){
        //     $row[] += $rr->batches_id ;
        // };

        // $batchs = \DB::table('batches')
        // ->Where('status','=','1')
        // ->whereNotIn('id', $row)->get();

        $courses = Category::select('title','id')->where('status','=','1')->get();

        // $batchs = Batch::WHERE('status','=',1)->get();
        return view('user.student-allot-batch',['courses'=>$courses,'studentID'=>$id]);
    }

    public function fecthCourseBatch(Request $req){
        $batch = Batch::select('name','id')->where('status','=','1')->where('categories_id','=',$req->input('course'))->get();
    
        return response()->json([
            'status'=>1,
            'batch'=>$batch
        ]);
    }

    public function fetchbatchSubject(Request $req){
        $allotedSubject = AllotBatch::select('subjects_id')->where('status','=',1)->where('batches_id','=',$req->input('batch'))->WHERE('students_id','=',$req->input('studentId'))->get();

        $arry = $allotedSubject->toArray();
        $row = [];
        foreach( $arry as $rr){
            $row[] = $rr['subjects_id'];
        };

        $subjects =  \DB::table('subjects')
        ->select('id','sub_name')
        ->where('categories_id','=',$req->input('course'))
        ->whereNotIn('id', $row)->get();
        

        return response()->json([
            'status'=>1,
            'subject'=>$subjects
        ]);
    }

    public function singlestudentBatch(Request $req){
        $req->validate([
            'subjectId'=>'required'
        ],[
            'subjectId'=>'Please Select a Subject!!'
        ]);

        if(!is_string($req->allotCourse)){
            foreach($req->subjectId as $id) {
                $users = new AllotBatch;
                $users->students_id = $req->sid;
                $users->batches_id  = $req->batch;
                $users->subjects_id = $id;
                $users->save();
            }
            return redirect()->back()->with('success','Batch Alloted Successfully!!');
        }
          return redirect()->back()->with('error','Please Select a Student!!');
    }


    // New Code
    public function allotSubject($id){
      // Active batch Student
    //   $student_id = \DB::table('allot_batches')
    //   ->select('students_id')
    //   ->WHERE('batches_id', '=',$id)->get();

    //   $arry = $student_id->toArray();
    //   $row = [];
    //   foreach( $arry as $rr){
    //       $row[] += $rr->students_id ;
    //   };

    //   $students = \DB::table('students')
    //   ->leftJoin('parents', 'parents.students_id', '=', 'students.id',)
    //   ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last','parents.email As p_email','parents.number As p_number')
    //   ->Where('students.status','=','1')
    //   ->whereNotIn('students.id', $row)->get();

       $courseId = Batch::select('categories_id','name')->WHERE('id','=',$id)->first();
       $subject = Subjects::select('sub_name','id')->WHERE('categories_id','=',$courseId->categories_id)->get();


       return view('user.batch-allot',['BatchId'=>$id,'subjects'=>$subject,'courseId'=>$courseId]);
    }

    public function allotBatchSubject(Request $req){
        $req->validate([
            'allotCourse'=>'required',
            'subjectId'=>'required'
        ],[
            'allotCourse'=>'Please Select a Student!!',
            'subjectId'=>'Please Select Any Subject'
        ]);

        $courseId =  Batch::select('categories_id')->WHERE('id','=',$req->bid)->first();
        if(!is_string($req->allotCourse)){
            foreach($req->allotCourse as $student) {
                foreach($req->subjectId as $Id){
                    
                    $users = AllotBatch::WHERE('status',1)->where('students_id',$student)->where('batches_id',$req->bid)->where('subjects_id',$Id)->count();

                    if($users > 0){

                    }else{
                        $users = new AllotBatch;
                        $users->students_id = $student;
                        $users->batches_id  = $req->bid;
                        $users->subjects_id = $Id;
                        $users->save();
                    }
                };
            }
            
            return redirect('/course/batch/'.$courseId->categories_id)->with('success','Batch Alloted Successfully!!');
        }
        return redirect()->back()->with('error','Please Select a Student!!');
    }

    public function fetchStudentDetails(Request $req){

        $studentId = \DB::table('allot_batches')
        ->select('students_id',\DB::raw('GROUP_CONCAT(subjects_id) as subjects'))
        ->whereIn('subjects_id',$req->input('sids'))->groupBy('students_id')->get();

        $arry = $studentId->toArray();
        $row = [];
        foreach( $arry as $rr){
            $exp = explode(",",$rr->subjects);
            if($req->input('sids')==$exp){
                $row[] += $rr->students_id;
            }
            
        };

        $student = \DB::table('students')
        ->leftJoin('parents', 'parents.students_id', '=', 'students.id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last','parents.email As p_email','parents.number As p_number')
        ->Where('students.status','=','1')
        ->whereNotIn('students.id', $row)->get();

        return response()->json([
            'status'=>1,
            'students'=>$student
        ]);

    }

    
    public function unallotSubject($id){

        $courseId = Batch::select('categories_id')->WHERE('id','=',$id)->first();
        $subject = Subjects::select('sub_name','id')->WHERE('categories_id','=',$courseId->categories_id)->get();

        return view('user.unallot-batch',['BatchId'=>$id,'subjects'=>$subject]);
    }

    public function unallotBatchSubject(Request $req){

        // dd($req->all());
        $req->validate([
            'allotCourse'=>'required',
            'subjectId'=>'required'
        ],[
            'allotCourse'=>'Please Select a Student!!',
            'subjectId'=>'Please Select Any Subject'
        ]);

        $courseId =  Batch::select('categories_id')->WHERE('id','=',$req->bid)->first();
        if(!is_string($req->allotCourse)){
            foreach($req->allotCourse as $student) {
                foreach($req->subjectId as $Id){
                    $deleteSubject = AllotBatch::Where('status',1)->where('batches_id','=',$req->bid)->where('subjects_id','=',$Id)->where('students_id','=',$student)->first();
                    $deleteSubject->delete();
                };
            }
            return redirect()->back()->with('success','Batch Deleted Successfully!!');
        }
        return redirect()->back()->with('error','Please Select a Student!!');
    }

    public function fetchAllotedStudentDetails(Request $req){
        $studentId = \DB::table('allot_batches')
        ->select('students_id',\DB::raw('GROUP_CONCAT(subjects_id) as subjects'))
        ->whereIn('subjects_id',$req->input('sids'))->groupBy('students_id')->get();

        $arry = $studentId->toArray();
        $row = [];
        foreach( $arry as $rr){
            $exp = explode(",",$rr->subjects);
            if($req->input('sids')==$exp){
                $row[] += $rr->students_id;
            }
            
        };

        $student = \DB::table('students')
        ->leftJoin('parents', 'parents.students_id', '=', 'students.id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last','parents.email As p_email','parents.number As p_number')
        ->Where('students.status','=','1')
        ->whereIn('students.id', $row)->get();

        return response()->json([
            'status'=>1,
            'students'=>$student
        ]);
    }
}
