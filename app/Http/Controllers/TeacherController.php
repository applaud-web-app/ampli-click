<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teachers;
use App\Models\Students;
use App\Models\Batch;
use App\Models\Subjects;
use App\Models\Category;

class TeacherController extends Controller
{
    public function index(){
        return view('user.add-teacher');
    }

    public function insert(Request $req){
        $req->validate([
            'name'=> 'required',
            'designation'=> 'required',
            'image'=>'mimes:jepg,jpg,png,gif | max:1000',
            'email'=>'required | email',
            'password'=>'required'
        ],[
            'name.required'=>'This Feild is required!',
            'designation.required'=>'This Feild is required!',
            'image.mimes'=>'Invalid File Type',
            'image.max'=>'File is too large',
            'email.required'=>'This Feild is required!',
            'email.email'=>'Please Enter a Valid Email',
            'password.required'=>'This Feild is required!'
        ]);


        $checkEmail = Teachers::where('email',$req->email)->count();
        if($checkEmail){
            return redirect()->back()->with('error','This Email already registered with us..');
        }

        $teacher = new Teachers;
        if(isset($req->image)){
            $imageName =  "TEACHER-".rand().".".$req->image->extension();
            $req->image->move(public_path('upload/teachers/') , $imageName);  
            $teacher->image  = $imageName; 
        }

        $teacher->teacher_name  = $req->name;
        $teacher->designation  = $req->designation;
        $teacher->email  = $req->email;
        $teacher->password  = \Hash::make($req->password);
        $teacher->number  =  $req->mobile;
        $teacher->gender  = $req->gender;          
        $teacher->save();  

        return redirect()->back()->withSuccess('Teacher Created');
    }

    public function view(){
        $teacher = Teachers::WHERE('status','!=',2)->paginate(12);
        return view('user.teachers',['teachers'=>$teacher]);
    }

    public function destroy($id){
        $teacher = Teachers::find($id);
        if(!is_null($teacher)){
            $teacher->status = 2;
            $teacher->save();
            // $teacher->delete();
            return redirect()->back()->withSuccess('Teacher Deleted');
        }
        return redirect()->back()->withSuccess('Oops!! Something Went Wrong!!');
    }

    public function singleRecord($id){
        $teacher = Teachers::WHERE('id',$id)->first();
        if(!is_null($teacher)){
            return view('user.update-teacher',['teachers'=>$teacher]);
        }
        return redirect('/teachers');
    }

    public function update(Request $req){

        $req->validate([
            'name'=> 'required',
            'designation'=> 'required',
            'image'=>'mimes:jepg,jpg,png,gif | max:1000',
            'email'=>'required | email',
            'status'=>'required'
        ],[
            'name.required'=>'This Feild is required!',
            'designation.required'=>'This Feild is required!',
            'image.mimes'=>'Invalid File Type',
            'image.max'=>'File is too large',
            'email.required'=>'This Feild is required!',
            'email.email'=>'Please Enter a Valid Email',
            'status.required'=>'This Feild is required!',
        ]);


        $checkEmail = Teachers::where('email',$req->email)->where('id','!=',$req->tid)->count();
        if($checkEmail > 0){
            return redirect()->back()->with('error','This Email already registered with us..');
        }
        
        $teacher = Teachers::WHERE('id',$req->tid)->first();

        if(isset($req->image)){
            $imageName =  "TEACHER-".rand().".".$req->image->extension();
            $req->image->move(public_path('upload/teachers/') , $imageName);  
            $teacher->image  = $imageName; 
        }

        $teacher->teacher_name  = $req->name;
        $teacher->designation  = $req->designation;
        $teacher->email  = $req->email;
        $teacher->number  =  $req->mobile;
        $teacher->gender  = $req->gender;    
        $teacher->status  = $req->status;          
        $teacher->save();  

        return redirect()->back()->withSuccess('Teacher Updated');
    }

    public function updatepass(Request $req){
        $req->validate([
            'updatepassword'=>'required'
        ],[
            'updatepassword.required'=>'This Feild is required!'
        ]);

        $teacher = Teachers::where('id',$req->tid)->first();
        if(!is_null($teacher)){

            $teacher->password  = \Hash::make($req->updatepassword);   
            $teacher->save();      
            return redirect()->back()->withSuccess('Password Updated');
        }
        return redirect()->back()->with('error','Something Went Wrong!!');
    }

    public function fetchTeacher($teacher_id = null){
        $teacher = \DB::table('teachers')->select('teacher_name','id')->WHERE('id',$teacher_id)->get();
        // dd($teacher);
        return response()->json([
            'status'=>1,
            'teachers'=>$teacher
        ]);
    }

    public function search(Request $req){
        $teachers = \DB::table('teachers')
        ->where('teacher_name', 'Like', "%".$req->input('search')."%")
        ->orWhere('email', 'Like',"%".$req->input('search')."%")
        ->orWhere('designation', 'Like',"%".$req->input('search')."%")
        ->get();
    
        return response()->json([
            'status'=>1,
            'teachers'=>$teachers
        ]);
    }

    public function dashboard(){
        // dd(auth()->user());
        $totalStudent = \DB::table('students')->WHERE('status','=',1)->count();
        $totalTeacher = \DB::table('teachers')->WHERE('status','=',1)->count();
        $totalCourses = \DB::table('categories')->where('status','=',1)->count();
        $totalAdmins = \DB::table('users')->where('status','=',1)->where('u_role',2)->count();
        $unapprovedStudent = Students::where('status','=',0)->count();
        $approvedStudent = Students::where('status','=',1)->count();

        // $totalBatch = \DB::table('batches')->WHERE('status','=',1)->count();
        // $totalSubject = \DB::table('subjects')->WHERE('status','=',1)->count();
        $latestSubjects = Subjects::select('sub_name','created_at','sub_image')->withCount('foldersystems')->orderBy('id', 'DESC')->paginate(5);
        $latestBatches = Batch::select('name','id')->WHERE('status','=',1)->withCount('allot_batches')->orderBy('id', 'DESC')->paginate(5);
        $recentStudent = Students::select('fname','lname','username','image')->where('status','=',1)->orderBy('id', 'DESC')->paginate(5);
        $recentUnapprovedStudent = Students::select('fname','lname','username','image','aadhar','email','mobile')->where('status','=',0)->orderBy('id', 'DESC')->paginate(5);
        $recentTeachers = Teachers::select('teacher_name','email','image')->where('status','=',1)->orderBy('id', 'DESC')->paginate(5);
        $Category = Category::WHERE('status',1)->withCount('total_subject')->withCount('total_batch')->orderBy('id','DESC')->paginate(10);

        

        return view('user.dashboard',['totalStudent'=>$totalStudent,'totalTeacher'=>$totalTeacher,'latestSubjects'=>$latestSubjects,'latestBatches'=>$latestBatches,'recentStudent'=>$recentStudent,'recentUnapprovedStudent'=>$recentUnapprovedStudent,'recentTeachers'=>$recentTeachers,'Categorys'=>$Category,'totalCourses'=>$totalCourses,'totalAdmins'=>$totalAdmins,'approvedStudent'=>$approvedStudent,'unapprovedStudent'=>$unapprovedStudent]);
    }

    public function teacherProfile($id){
        $teacher = Teachers::WHERE('id','=',$id)->first();
        return view('user.user-profile',['teacher'=>$teacher]);
    }

    public function UpdateTeacherProfile(Request $req){
        $req->validate([
            'name'=> 'required',
            'designation'=> 'required',
            'image'=>'mimes:jepg,jpg,png,gif | max:1000',
            'email'=>'required | email',
            'number'=>'required',
            'gender'=>'required',
        ],[
            'name.required'=>'This Feild is required!',
            'designation.required'=>'This Feild is required!',
            'image.mimes'=>'Invalid File Type',
            'image.max'=>'File is too large',
            'email.required'=>'This Feild is required!',
            'email.email'=>'Please Enter a Valid Email',
            'number.required'=>'This feild is required',
            'gender.required'=>'This feild is required',
        ]);

        $checkEmail = Teachers::where('email',$req->email)->WHERE('id','!=',$req->id)->count();
        if($checkEmail > 0){
            return redirect()->back()->with('error','This Email already registered with us..');
        }

        $teacher = Teachers::WHERE('id','=',$req->id)->first();
        if(isset($req->image)){
            $imageName =  "TEACHER-".rand().".".$req->image->extension();
            $req->image->move(public_path('upload/teachers/') , $imageName);  
            $teacher->image  = $imageName; 
        }

        $teacher->teacher_name  = $req->name;
        $teacher->designation  = $req->designation;
        $teacher->email  = $req->email;
        $teacher->number  =  $req->number;
        $teacher->gender  = $req->gender;          
        $teacher->save();  

        return redirect()->back()->withSuccess('Teacher Updatded Succesfully!!');
    }
}
