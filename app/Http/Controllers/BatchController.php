<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\SubjectController;
use App\Models\AllotBatch;
use App\Models\Category;
use App\Models\Subjects;

class BatchController extends Controller
{
   public function index(){
    return view('user.create-batch');
   }

   public function insert(Request $req){
        $req->validate([
            'name'=> 'required',
            'start_date'=> 'required | date',
            'end_date'=> 'required | date'
        ],[
            'name.required'=>'This Feild is required',
            'start_date.required'=>'This Feild is required',
            'start_date.date'=>'Please Enter a Valid Date',
            'end_date.required'=>'This Feild is required',
            'end_date.date'=>'Please Enter a Valid Date'
        ]);

        $checkEmail = Batch::where('name',$req->name)->count();
        if($checkEmail){
            return redirect()->back()->with('error','This Batch Name is already in use...');
        }

        $batch = new Batch;
        $batch->name = $req->name;
        $batch->start_date = $req->start_date;
        $batch->end_date = $req->end_date;
        $batch->created_at = date('Y-m-d');
        $batch->save();

        return redirect()->back()->withSuccess('Batch Created');
    }

   public function records(){

    $batchs = Batch::withCount('allot_batches')->paginate(10);

    return view('user.all-batch',['batchs'=>$batchs]);
   }

   public function singleRecord($id){
    $batch = \DB::table('batches')->where('id', $id)->first();
    return view('user.update-batch',['batch'=>$batch]);
   }

   public function update(Request $req){

    $req->validate([
        'name'=> 'required',
        'start_date'=> 'required | date',
        'end_date'=> 'required | date'
    ],[
        'name.required'=>'This Feild is required',
        'start_date.required'=>'This Feild is required',
        'start_date.date'=>'Please Enter a Valid Date',
        'end_date.required'=>'This Feild is required',
        'end_date.date'=>'Please Enter a Valid Date'
    ]);

    $checkBatch = Batch::where('name',$req->name)->count();
    if($checkBatch > 1){
        return redirect()->back()->with('error','This Batch Name is already in use...');
    } 

    $batch = Batch::find($req->id);
    $batch->name = $req->name;
    $batch->start_date = $req->start_date;
    $batch->end_date = $req->end_date;
    $batch->status = $req->status;
    $batch->save();

    return redirect()->back()->withSuccess('Batch Updated');
   }

//    public function searchDeactive(Request $req){
//     $batch = Batch::where('name', 'Like', "%".$req->input('search')."%")->where('status','=','0')->withCount('allot_batches')->get();
//     // $batch = \DB::table('batches')->get();
//     return response()->json([
//         'status'=>1,
//         'batch'=>$batch
//     ]);
//    }

//    public function searchEnded(Request $req){
//     $batch = Batch::where('name', 'Like', "%".$req->input('search')."%")->where('status','=','2')->withCount('allot_batches')->get();
//     // $batch = \DB::table('batches')->get();
//     return response()->json([
//         'status'=>1,
//         'batch'=>$batch
//     ]);
//    }

   public function showSubject($id){
        $subject = \DB::table('subjects')
        ->join('categories', 'categories.id', '=', 'subjects.categories_id',)
        ->join('sub_categories', 'sub_categories.id', '=', 'subjects.sub_categories_id')
        ->join('batches', 'batches.id', '=', 'subjects.batches_id')
        ->select('subjects.*', 'categories.title As parentCat','sub_categories.title As childCat','batches.name As batch')
        ->WHERE('subjects.status', '=','1')
        ->WHERE('subjects.batches_id', '=',$id)
        ->paginate(10);

        return view('user.all-subjects',['subjects'=>$subject]);
   }

   public function addsubject($id){
    $batch = \DB::table('batches')->select('name', 'id')->WHERE('status',1)->get();
    $category = \DB::table('categories')->select('title', 'id')->WHERE('status',1)->get();
    return view('user.create-subject',['categorys'=>$category],['batch'=>$id]);
   }

   // New Code     
   public function showCourseBatches($id){
        $courseBatch = Batch::Where('categories_id','=',$id)->where('status','=',1)->withCount(['allot_batches' => function($query) {
            $query->select(\DB::raw('count(distinct(studentS_id))'));
        }])->paginate(10);
        $courseName = Category::select('title','id')->Where('id',$id)->first();
        return view('user.course-batches',['courseBatchs'=>$courseBatch,'courseName'=>$courseName]);
    }

    public function updateStatus(Request $req){
        $batch = Batch::WHERE('id',$req->input('id'))->first();
        if($batch != null){
            $batch->status = $req->input('status');
            $batch->save();

            // $subjects = Subjects::WHERE('categories_id','=',$batch->categories_id)->update(['status'=>$req->input('status')]);
            // $allotSubject = AllotBatch::WHERE('batches_id',$req->input('id'))->update(['status'=>$req->input('status')]);
            
            return response()->json([
                'status'=>1,
                'success'=>'Status Updated Succesfully'
            ]);
        }
        return response()->json([
            'status'=>0,
            'error'=>'Oops Something Went Wrong!!'
        ]);
    }

    public function searchBatch(Request $req){
        $batch = Batch::Where('categories_id','=',$req->input('cid'))->where('name', 'Like', "%".$req->input('search')."%")->where('status','=',$req->input('status'))->withCount(['allot_batches' => function($query) {
            $query->select(\DB::raw('count(distinct(studentS_id))'));
        }])->get();

        return response()->json([
            'status'=>1,
            'batch'=>$batch,
        ]);
    }

    public function deleteBatch(Request $req){
        $batch = Batch::find($req->id);
        if(!is_null($batch)){
            $batch->status = 2;
            $batch->save();
            return redirect()->back()->withSuccess('Batch Deleted Successfully!');
        }
        return redirect()->back()->with('error','Oops Something Went Wrong!!');
    }

    public function fetchActiveRecord(Request $req){
        $Batch = Batch::Where('categories_id','=',$req->input('cid'))->WHERE('status',1)->withCount(['allot_batches' => function($query) {
            $query->select(\DB::raw('count(distinct(studentS_id))'));
        }])->get();
        return response()->json([
            'status'=>1,
            'Batchs'=>$Batch
        ]);
    }

    public function fetchDeactiveRecord(Request $req){
        $Batch = Batch::Where('categories_id','=',$req->input('cid'))->WHERE('status',0)->withCount(['allot_batches' => function($query) {
            $query->select(\DB::raw('count(distinct(studentS_id))'));
        }])->get();
        return response()->json([
            'status'=>1,
            'Batchs'=>$Batch
        ]);
    }

    public function fetchEndedRecord(Request $req){
        $Batch = Batch::Where('categories_id','=',$req->input('cid'))->WHERE('status',3)->withCount(['allot_batches' => function($query) {
            $query->select(\DB::raw('count(distinct(studentS_id))'));
        }])->get();
        return response()->json([
            'status'=>1,
            'Batchs'=>$Batch
        ]);
    }

    public function createBatch(Request $req){
        $req->validate([
            'batchName'=> 'required',
            'startDate'=> 'required | date',
            'endDate'=> 'required | date'
        ],[
            'batchName.required'=>'This Feild is required',
            'startDate.required'=>'This Feild is required',
            'startDate.date'=>'Please Enter a Valid Date',
            'endDate.required'=>'This Feild is required',
            'endDate.date'=>'Please Enter a Valid Date'
        ]);

        $checkBatch = Batch::where('name',$req->input('batchName'))->where('categories_id',$req->input('courseId'))->count();
        if($checkBatch > 0){
            return response()->json([
                'status'=>0,
                'message'=>'This batch name is already in use!!'
            ]);
        } 

        $batch = new Batch;
        $batch->name = $req->input('batchName');
        $batch->categories_id = $req->input('courseId');
        $batch->start_date = $req->input('startDate');
        $batch->end_date = $req->input('endDate');
        $batch->created_at = date('Y-m-d');
        $batch->save();
        $id = $batch->id;
        return response()->json([
            'status'=>1,
            'message'=>'Batch Created Succesfully!!',
            'redirect'=>$id
        ]);
    }

    public function updateCourseBatch(Request $req){
        $Batch = Batch::Where('id','=',$req->input('batch'))->first();
        return response()->json([
            'status'=>1,
            'Batchs'=>$Batch
        ]);
    }

    public function batchUpdate(Request $req){
        $Batch = Batch::Where('id','=',$req->input('batchId'))->first();

        if(is_null($Batch)){
            return response()->json([
                'status'=>0,
                'message'=>'Something Went Wrong!!'
            ]);
        }

        $Batch->name = $req->input('batchName');
        $Batch->start_date = $req->input('startDate');
        $Batch->end_date = $req->input('endDate');
        $Batch->save();

        return response()->json([
            'status'=>1,
            'message'=>'Batch Updated Succesfully!!'
        ]);
    }


}
