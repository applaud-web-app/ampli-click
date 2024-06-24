<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subjects;
use App\Models\Batch;
use App\Models\AllotBatch;
use App\Models\OnlineClass;

class CategoryController extends Controller
{
    public function index(){
        return view('user.category');
    }

    public function insert(Request $req){
        $req->validate([
            'cat_name'=> 'required',
            'cat_description'=> 'required',
            'cat_image'=> 'mimes:jepg,jpg,png,gif',
        ],[
            'cat_name.required'=>'This Feild is required!',
            'cat_description.required'=>'This Feild is required!',
            'cat_image.mimes'=>'Invalid File Format',
        ]);

        $checkCourse = Category::where('title',$req->cat_name)->count();
        if($checkCourse > 0){
            return redirect()->back()->with('error','This Course already Exists..');
        }

        $category = new Category;

        if(isset($req->cat_image)){
            $imageName =  "COURSE-".rand().".".$req->cat_image->extension();
            $req->cat_image->move(public_path('upload/course/') , $imageName);  
            $category->course_img  = $imageName; 
        }
        $category->title = $req->cat_name;
        $category->description = $req->cat_description;
        $category->save();
        $id = $category->id;
        \Session::flash('model', 'true'); 
        return redirect('/course-subject/'.$id)->withSuccess('Course Created Succesfully');
    }

    public function modelPreview($id){
        \Session::flash('model', 'true'); 
        return redirect('/course-subject/'.$id);
    }

    public function view(){
        $Category = Category::WHERE('status',1)->withCount('total_subject')->withCount('total_batch')->orderBy('id','DESC')->paginate(10);
        return view('user.view-category',['Categorys'=>$Category]);
    }

    
    public function destroy(Request $req){
        $Category = Category::find($req->id);
        if(!is_null($Category)){
            $Category->status = 2;
            $Category->save();
            return redirect()->back()->withSuccess('Course Deleted Successfully!');
        }
        return redirect()->back()->with('error','Oops Something Went Wrong!!');
    }

    public function singleRecord($id){
        $Category = Category::WHERE('id',$id)->first();
        if(!is_null($Category)){
            return view('user.update-category',['Categorys'=>$Category]);
        }
        return redirect('/view-category');
    }

    public function update(Request $req){
        $req->validate([
            'cat_name'=> 'required',
            'cat_description'=> 'required',
            'cat_image'=> 'mimes:jepg,jpg,png,gif'
        ],[
            'cat_name.required'=>'This Feild is required!',
            'cat_description.required'=>'This Feild is required!',
            'cat_image.mimes'=>'Invalid File Format'
        ]);

        $checkCat = Category::where('title',$req->cat_name)->WHERE('id','!=',$req->cat_id)->count();
        if($checkCat > 0){
            return redirect()->back()->with('error','This Course name already exist..');
        } 

        $Category = Category::WHERE('id',$req->cat_id)->first();
        if(!is_null($Category)){

            if(isset($req->cat_image)){
                $imageName =  "COURSE-".rand().".".$req->cat_image->extension();
                $req->cat_image->move(public_path('upload/course/') , $imageName);  
                $Category->course_img  = $imageName; 
            }

            $Category->title = $req->cat_name;
            $Category->description = $req->cat_description;
            $Category->save();
            return redirect()->back()->withSuccess('Course Updated Succesfully');
        }
        return redirect()->back()->with('error','Oops Something Went Wrong!!');
    }

    public function search(Request $req){
        $category =  Category::where('title', 'Like', "%".$req->input('search')."%")->where('status','=',$req->input('status'))->withCount('total_subject')->withCount('total_batch')->get();
        return response()->json([
            'status'=>1,
            'categorys'=>$category
        ]);
    }

    public function updateStatus(Request $req){
        $category = Category::WHERE('id',$req->input('id'))->first();

        if($category != null){
            $category->status = $req->input('status');
            $category->save();

            $subjects = Subjects::WHERE('categories_id','=',$req->input('id'))->update(['status'=>$req->input('status')]);

            $batch = Batch::WHERE('categories_id','=',$req->input('id'))->update(['status'=>$req->input('status')]);

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

    public function fetchActiveRecord(Request $req){
        $category = Category::WHERE('status',1)->withCount('total_subject')->withCount('total_batch')->get();
        return response()->json([
            'status'=>1,
            'categorys'=>$category
        ]);
    }

    public function fetchDeactiveRecord(Request $req){
        $category = Category::WHERE('status',0)->withCount('total_subject')->withCount('total_batch')->get();
        return response()->json([
            'status'=>1,
            'categorys'=>$category
        ]);
    }

    // Course Subject
    public function showSubject($id){
        $categoryName = Category::select('title','id')->where('id',$id)->first();
        $subject = Subjects::WHERE('categories_id',$id)->WHERE('status',1)->withCount('allot_subjects')->orderBy('id','DESC')->paginate(10);
        // dd($subject);
        // die();
        return view('user.all-subjects',['subjects'=>$subject,'categoryName'=>$categoryName]);
    }

    // Subject By Status Fetch
    public function fetchSubjectByStatus(Request $req){
        $subject = Subjects::WHERE('status',$req->input('status'))->WHERE('categories_id',$req->input('cId'))->withCount('allot_subjects')->orderBy('id','DESC')->get();
        return response()->json([
            'status'=>1,
            'subjects'=>$subject
        ]);
    }   

    // Search Subject
    public function searchSubject(Request $req){
        $searchStr = $req->input('search');
        $subject = Subjects::WHERE('status',$req->input('status'))->WHERE('categories_id',$req->input('cId'))->where('subjects.sub_name', 'Like', "%".$searchStr."%")->withCount('allot_subjects')->orderBy('id','DESC')->get();
    
        return response()->json([
            'status'=>1,
            'subjects'=>$subject
        ]);
    }

    //Update Subject Status
    public function updateCourseSubjectStatus(Request $req){
        $subject = Subjects::WHERE('id',$req->input('id'))->first();
        if($subject != null){
            $subject->status = $req->input('status');
            $subject->save();

            $allotSubject = AllotBatch::WHERE('subjects_id',$req->input('id'))->update(['status'=>$req->input('status')]);
            
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

    // Delete Subject
    public function deleteCourseSubject(Request $req){
        $subject = Subjects::find($req->id);
        if(!is_null($subject)){
            $subject->status = '2';
            $subject->save();
            return redirect()->back()->withSuccess('Course Deleted Successfully!');
        }
        return redirect()->back()->with('error','Oops Something Went Wrong!!');
    }

    public function addNewSubject(Request $req){
        $req->validate([
            'sub_name'=> 'required',
            'sub_descp'=> 'required'
        ],[
            'sub_name.required'=>'This Feild is required',
            'sub_descp.required'=>'This Feild is required'
        ]);

        $checkSubject = Subjects::where('sub_name',$req->input('sub_name'))->where('categories_id',$req->input('cid'))->count();
        if($checkSubject > 0){
            return response()->json([
                'status'=>0,
                'message'=>'This Subject name is already in use!!'
            ]);
        } 

        $subject = new Subjects;
        if($req->hasFile('banner_image')){
            $file = $req->file('banner_image');
            $name = "SUBJECT-".time().'.'.$file->getClientOriginalExtension();
            $image['filePath'] = $name;
            $file->move(public_path().'/upload/subject/', $name);
            $subject->sub_image = $name;
        }

        $subject->sub_name = $req->input('sub_name');
        $subject->sub_description = $req->input('sub_descp');
        $subject->categories_id  = $req->input('cid');
        $subject->save();
        $new_id = $subject->id;

        return response()->json([
            'status'=>1,
            'message'=>'Subject Created Succesfully!!',
            'redirect'=>$new_id,
        ]);
    }

    public function fetchSubjectRecord(Request $req){
        $subject = Subjects::Where('id','=',$req->input('subject'))->first();
        return response()->json([
            'status'=>1,
            'subject'=>$subject
        ]);
    }

    public function updateCourseSubject(Request $req){
        $subject = Subjects::Where('id','=',$req->input('id'))->first();

        if(is_null($subject)){
            return response()->json([
                'status'=>0,
                'message'=>'Something Went Wrong!!'
            ]);
        }

        if($req->hasFile('banner_image')){
            $file = $req->file('banner_image');
            $name = "SUBJECT-".time().'.'.$file->getClientOriginalExtension();
            $image['filePath'] = $name;
            $file->move(public_path().'/upload/subject/', $name);
            $subject->sub_image = $name;
        }
        $subject->sub_name = $req->input('sub_name');
        $subject->sub_description = $req->input('sub_descp');
        $subject->categories_id  = $req->input('cid');
        $subject->save();
        return response()->json([
            'status'=>1,
            'message'=>'Subject Updated Succesfully!!'
        ]);
    }

    public function allOnlineClasses($subjectId){
        $data['subjectId']  = $subjectId;
        $data['classData'] = OnlineClass::where('subject_id',$subjectId)->orderBy('id','DESC')->paginate(50);
        return view('user.all-online-classes',$data);
    }

   

  
}
