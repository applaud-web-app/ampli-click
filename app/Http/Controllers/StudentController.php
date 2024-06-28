<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\City;
use App\Models\State;
use App\Models\Parents;
use App\Models\Students;
use App\Models\AllotBatch;
use App\Models\OnlineClass;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Services\UserAgent;

class StudentController extends Controller
{
    public function index(){
       $states = State::WHERE('country_id',101)->get();
       return view('user.add-student',['states'=>$states]);
    }

    public function insert(Request $req){
        $req->validate([
            'fname'=> 'required',
            'username'=>'required',
            'mobile'=>'required | numeric',
            'email'=>'required | email',
            'password'=>'required',
            'allowed_device'=>'required | numeric',
            'gender'=>'required',
            'aadhar'=>'required | numeric',
            'front_aadhar'=>'required',            
            'front_back'=>'required',
            'address'=>'required',
            'city'=>'required',
            'state'=>'required'
        ],[
            'fname.required'=>'This Feild is required!',
            'image.mimes'=>'Invalid File Type',
            'image.max'=>'File is too large',
            'email.required'=>'This Feild is Required',
            'email.email'=>'Enter a Valid Email!',
            'password.required'=>'This Feild is required!',
            'username.required'=>'This Feild is required!',
            'mobile.required'=>'This Feild is required!',
            'mobile.numeric'=>'Please Enter a valid Data!',
            'aadhar.required'=>'This Feild is required!',
            'aadhar.numeric'=>'Please Enter a valid Data!',
            'front_aadhar.required'=>'This Feild is required!',
            'front_back.required'=>'This Feild is required!',
            'city.required'=>'This Feild is required!',
            'state.required'=>'This Feild is required!',
            'allowed_device.required'=>'This Feild is required!',
            'allowed_device.numeric'=>'Please Enter a valid Number',
            'gender.required'=>'This Feild is required!',
            'address.required'=>'This Feild is required!'
        ]);


        $chechUser = Students::where('username',$req->username)->count();
        if($chechUser){
            return redirect()->back()->with('error','This Username already registered with us..');
        }

        $student = new Students;
        if(isset($req->image)){

            $base64_image       = $req->image;
            list($type, $data)  = explode(';', $base64_image);
            list(, $data)       = explode(',', $data);
            $data               = base64_decode($data);
            $thumb_name         = "STUDENT-".rand().'.png';
            $thumb_path         = public_path("upload/student/" . $thumb_name);
            file_put_contents($thumb_path, $data);

            $student->image  = $thumb_name; 
        }

        if(isset($req->front_aadhar)){

            $base64_image       = $req->front_aadhar;
            list($type, $data)  = explode(';', $base64_image);
            list(, $data)       = explode(',', $data);
            $data               = base64_decode($data);
            $thumb_name         = "AADHAR-".rand().'.png';
            $thumb_path         = public_path("upload/studentAadhar/" . $thumb_name);
            file_put_contents($thumb_path, $data);

            $student->aadhar_front  = $thumb_name; 

        }

        if(isset($req->front_back)){

            $base64_image       = $req->front_back;
            list($type, $data)  = explode(';', $base64_image);
            list(, $data)       = explode(',', $data);
            $data               = base64_decode($data);
            $thumb_name         = "AADHAR-".rand().'.png';
            $thumb_path         = public_path("upload/studentAadhar/" . $thumb_name);
            file_put_contents($thumb_path, $data);
            $student->aadhar_back  = $thumb_name; 
        }

        $student->fname  = $req->fname;
        $student->lname  = $req->lname;
        $student->username  = $req->username;
        $student->dob  =  $req->dob;
        $student->email  = $req->email; 
        $student->mobile  = $req->mobile; 
        $student->password  = \Hash::make($req->password); 
        $student->aadhar  = $req->aadhar; 
        $student->gender  = $req->gender;
        $student->allowed_devices  = $req->allowed_device;
        $student->state  = $req->state; 
        $student->city  = $req->city; 
        $student->address  = $req->address; 
        $student->local_state  = $req->local_state; 
        $student->local_city  = $req->local_city; 
        $student->local_address  = $req->local_address; 
        $student->save();

        $lastId = $student->id;  
        $parent = new Parents;
        $parent->students_id = $lastId;
        $parent->parent_fname = $req->p_fname;
        $parent->parent_lname = $req->p_fname;
        $parent->email = $req->p_email;
        $parent->number = $req->p_number;
        $parent->save();

        return redirect('/students')->with('success','Student Record Created');
    }

    public function view(){
    
        $student = \DB::table('students')
        ->leftJoin('parents', 'students.id', '=', 'parents.students_id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last')
        ->where('students.status', '=', 1)
        ->orderBy('students.id', 'desc')
        ->paginate(15);

        return view('user.all-students',['students'=>$student]);
    }

    public function singleRecord($id){
        $states = State::WHERE('country_id',101)->get();
        $student = \DB::table('students')
        ->leftJoin('parents', 'parents.students_id', '=', 'students.id',)
        // ->leftJoin('states', 'students.state', '=', 'states.id',)
        // ->leftJoin('states as localstate', 'students.local_state', '=', 'localstate.id',)
        // ->leftJoin('cities as localcity', 'students.local_city', '=', 'localcity.id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last','parents.email As p_email','parents.number As p_number')
        ->WHERE('students.id', '=',$id)
        ->get()->first();

        $studentState = Students::select('state','local_state')->where('id',$id)->first();
        $city = City::WHERE('state_id',$studentState->state)->get();
        $localcity = City::WHERE('state_id',$studentState->local_state)->get();
        // dd($student);
        if(!is_null($student)){
            return view('user.update-student',['students'=>$student,'states'=>$states,'citys'=>$city,'localcitys'=>$localcity]);
        }
        return redirect('/students');
    }

    
    public function update(Request $req){

        $req->validate([
            'fname'=> 'required',
            'username'=>'required',
            'mobile'=>'required | numeric',
            'email'=>'required | email',
            'allowed_device'=>'required | numeric',
            'gender'=>'required',
            'aadhar'=>'required | numeric',
            'state'=>'required',
            'city'=>'required',
            'address'=>'required',
            'status'=>'required'
        ],[
            'fname.required'=>'This Feild is required!',
            'email.required'=>'This Feild is required!',
            'email.email'=>'Please Enter a Valid Email',
            'username.required'=>'This Feild is required!',
            'mobile.required'=>'This Feild is required!',
            'mobile.numeric'=>'Please Enter a valid Data!',
            'aadhar.required'=>'This Feild is required!',
            'aadhar.numeric'=>'Please Enter a valid Data!',
            'allowed_device.required'=>'This Feild is required!',
            'allowed_device.numeric'=>'Please Enter a valid Number',
            'state.required'=>'This Feild is required!',
            'city.required'=>'This Feild is required!',
            'gender.required'=>'This Feild is required!',
            'address.required'=>'This Feild is required!',
            'status.required'=>'This Feild is required!'
        ]);

        $chechUser = Students::where('username',$req->username)->where('id','!=',$req->sid)->count();
        if($chechUser > 0){
            return redirect()->back()->with('error','This Username already registered with us..');
        }
        
        $student = Students::WHERE('id',$req->sid)->first();

        if(isset($req->image)){

            $base64_image       = $req->image;
            list($type, $data)  = explode(';', $base64_image);
            list(, $data)       = explode(',', $data);
            $data               = base64_decode($data);
            $thumb_name         = "STUDENT-".rand().'.png';
            $thumb_path         = public_path("upload/student/" . $thumb_name);
            file_put_contents($thumb_path, $data);

            $student->image  = $thumb_name; 
        }

        if(isset($req->front_aadhar)){

            $base64_image       = $req->front_aadhar;
            list($type, $data)  = explode(';', $base64_image);
            list(, $data)       = explode(',', $data);
            $data               = base64_decode($data);
            $thumb_name         = "AADHAR-".rand().'.png';
            $thumb_path         = public_path("upload/studentAadhar/" . $thumb_name);
            file_put_contents($thumb_path, $data);

            $student->aadhar_front  = $thumb_name; 

        }

        if(isset($req->front_back)){

            $base64_image       = $req->front_back;
            list($type, $data)  = explode(';', $base64_image);
            list(, $data)       = explode(',', $data);
            $data               = base64_decode($data);
            $thumb_name         = "AADHAR-".rand().'.png';
            $thumb_path         = public_path("upload/studentAadhar/" . $thumb_name);
            file_put_contents($thumb_path, $data);
            $student->aadhar_back  = $thumb_name; 
        }

        $student->fname  = $req->fname;
        $student->lname  = $req->lname;
        $student->username  = $req->username;
        $student->dob  =  $req->dob;
        $student->mobile  = $req->mobile; 
        $student->email  = $req->email; 
        $student->allowed_devices  = $req->allowed_device;
        $student->gender  = $req->gender;
        $student->status  = $req->status; 
        $student->aadhar  = $req->aadhar; 
        $student->state  = $req->state; 
        $student->city  = $req->city; 
        $student->address  = $req->address; 
        $student->local_state  = $req->local_state; 
        $student->local_city  = $req->local_city; 
        $student->logged_in_devices  = $req->logged_in_devices > 0 ? $req->logged_in_devices : 0;
        $student->local_address  = $req->local_address; 
        $student->save();
        
        $parent = Parents::WHERE('students_id',$req->sid)->first();
        $parent->parent_fname = $req->p_fname;
        $parent->parent_lname = $req->p_lname;
        $parent->email = $req->p_email;
        $parent->number = $req->p_number;
        $parent->save();

        return redirect('/students')->withSuccess($student->fname.' Record Updated');
    }

    public function search(Request $req){
        $searchStr = $req->input('search');
        $student = \DB::table('students')
        ->leftJoin('parents', 'parents.students_id', '=', 'students.id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last','parents.email As p_email','parents.number As p_number')
        ->where(function($q) use($searchStr){
            $q->where('students.fname', 'Like', "%".$searchStr."%")
            ->orWhere('students.lname', 'Like',"%".$searchStr."%")
            ->orWhere('students.username', 'Like',"%".$searchStr."%")
            ->orWhere('students.mobile', 'Like',"%".$searchStr."%")
            ->orWhere('students.email', 'Like',"%".$searchStr."%")
            ->orWhere('students.state', 'Like',"%".$searchStr."%")
            ->orWhere('students.city', 'Like',"%".$searchStr."%")
            ->orWhere('parents.parent_fname', 'Like',"%".$searchStr."%")
            ->orWhere('parents.parent_lname', 'Like',"%".$searchStr."%");
        })
        ->where('students.status', '=', $req->input('status'))
        ->orderBy('students.id', 'desc')
        ->get();
        
        return response()->json([
            'status'=>1,
            'students'=>$student
        ]);
    }

    public function filter(Request $req){
        $student = \DB::table('students')       
        ->leftJoin('parents', 'parents.students_id', '=', 'students.id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last','parents.email As p_email','parents.number As p_number')
        ->where('students.status', '=', $req->input('filter_status'))
        ->get();

        return response()->json([
            'status'=>1,
            'students'=>$student
        ]);
    }

    public function updateStatus(Request $req){
        $student = Students::where('id',$req->input('student_id'))->first();
        $student->status = $req->input('status');
        $student->save();

        $students = \DB::table('students')
        ->leftJoin('parents', 'students.id', '=', 'parents.students_id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last')
        ->where('students.status', '=', 1)
        ->orderBy('students.id', 'desc')
        ->get();


        return response()->json([
            'status'=>1,
            'students'=>$students
        ]);
    }

    // Student panel
    public function studentDashboard(){
       
        $states = State::WHERE('country_id',101)->get();
        $userId = Auth::guard('student')->id();
        $TotalBatches = AllotBatch::WHERE('students_id',$userId)->where('status','=',1)->withCount('show_batches')->get();
        $CompletedBatches = AllotBatch::WHERE('students_id',$userId)->where('status','=',0)->withCount('show_batches')->get();
        // $TotalSubject = AllotBatch::groupBy('batches_id')->select('batches_id', \DB::raw('count(*) as total'))->get();
        
        $TotalSubject =  \DB::table('allot_batches')
                 ->select('batches_id', \DB::raw('count(*) as total'))
                 ->groupBy('batches_id')->WHERE('students_id',$userId)->where('status','=',1)
                 ->get();

        // dd($TotalSubject);
        // die();
        return view('/student.dashboard',['TotalBatches'=>$TotalBatches,'TotalSubject'=>$TotalSubject,'CompletedBatches'=>$CompletedBatches,'states'=>$states]);
    }

    public function studentProfile(){
        $userId = Auth::guard('student')->id();
        $studentData = \DB::table('students')
        ->leftJoin('parents', 'parents.students_id', '=', 'students.id',)
        ->select('students.*', 'parents.parent_fname As parent_first','parents.parent_lname As parent_last','parents.email As p_email','parents.number As p_number')
        ->WHERE('students.id', '=',$userId)
        ->get()->first();

        return view('/student.profile',['studentData'=>$studentData]);
    }

    public function updateStudentProfile(Request $req){
        $req->validate([
            'fname'=> 'required',
            'image'=>'mimes:jepg,jpg,png,gif | max:1000',
            'username'=>'required',
            'mobile'=>'required | numeric',
            'aadhar'=>'required | numeric',
            'gender'=>'required',
            'address'=>'required',
            'pname'=>'required',
            'pemail'=>'required',
            'pmobile'=>'required'
        ],[
            'fname.required'=>'This Feild is required!',
            'image.mimes'=>'Invalid File Type',
            'image.max'=>'File is too large',
            'username.required'=>'This Feild is required!',
            'mobile.required'=>'This Feild is required!',
            'mobile.numeric'=>'Please Enter a valid Data!',
            'aadhar.required'=>'This Feild is required!',
            'aadhar.numeric'=>'Please Enter a valid Data!',
            'gender.required'=>'This Feild is required!',
            'address.required'=>'This Feild is required!',
            'pname.required'=>'This Feild is required!',
            'pemail.required'=>'This Feild is required!',
            'pmobile.required'=>'This Feild is required!',
        ]);

        $chechUser = Students::where('username',$req->username)->count();
        if($chechUser > 1){
            return redirect()->back()->with('error','This Username already registered with us..');
        }
        
        $student = Students::WHERE('id',$req->sid)->first();

        if(isset($req->image)){
            $imageName =  "STUDENT-".rand().".".$req->image->extension();
            $req->image->move(public_path('upload/student/') , $imageName);  
            $student->image  = $imageName; 
        }

        $student->fname  = $req->fname;
        $student->lname  = $req->lname;
        $student->username  = $req->username;
        $student->dob  =  $req->dob;
        $student->email  = $req->email; 
        $student->mobile  = $req->mobile; 
        $student->aadhar  = $req->aadhar; 
        $student->gender  = $req->gender;
        $student->city  = $req->city;  
        $student->address  = $req->address; 
        $student->save();
        
        $parent = Parents::WHERE('students_id',$req->sid)->first();
        $parent->parent_fname = $req->pname;
        $parent->parent_lname = $req->plname;
        $parent->email = $req->pemail;
        $parent->number = $req->pmobile;
        $parent->save();

        return redirect()->back()->withSuccess('Profile Updated');
    }

    public function allotedBatch(){
        $userId = Auth::guard('student')->id();
        $show_batches =  \DB::table('allot_batches')
        ->join('batches', 'batches.id', '=', 'allot_batches.batches_id')
        ->select('batches.name','batches.start_date','batches.end_date','allot_batches.batches_id', \DB::raw('count(*) as total'))->groupBy('allot_batches.batches_id','batches.name','batches.start_date','batches.end_date')->WHERE('allot_batches.students_id',$userId)->where('allot_batches.status','=',1)->WHERE('batches.status',1)->get();
        // dd($show_batches);
        // die();
        // $show_batches = AllotBatch::WHERE('students_id',$userId)->where('status','=',1)->with('show_batches')->paginate(10);
        // dd($show_batches);
        return view('/student.student-batch',['show_batches'=>$show_batches]);
    }

    public function showStudentSubject($id){
        // $subject = \DB::table('subjects')
        // ->join('categories', 'categories.id', '=', 'subjects.categories_id',)
        // ->join('batches', 'batches.id', '=', 'subjects.batches_id')
        // ->select('subjects.*', 'categories.title As parentCat','sub_categories.title As childCat','batches.name As batch')
        // ->WHERE('subjects.status', '=','1')
        // ->WHERE('subjects.batches_id', '=',$id)->get();
        // ->paginate(10);

        if(\Auth::guard('student')->check()){
            $studentId = Auth('student')->user()->id;
            $batchData = AllotBatch::where(['students_id'=>$studentId,'batches_id'=>$id,'status'=>1])->count();
            if($batchData <= 0){
                return redirect()->back();
            }else{

                $userId = Auth::guard('student')->id();
                $subject = \DB::table('allot_batches')
                ->join('subjects', 'subjects.id', '=', 'allot_batches.subjects_id')
                ->select('subjects.id','subjects.sub_name','subjects.sub_description','subjects.sub_image')
                ->where('allot_batches.students_id',$userId)->where('allot_batches.batches_id',$id)->where('allot_batches.status',1)->WHERE('subjects.status',1)->get();
                // dd($subject);
                // die();
                return view('student.view-subject',['subjects'=>$subject]);
            }
        }
        
       
    }

    public function subjectDetails($id){


        if(\Auth::guard('student')->check()){
            $studentId = Auth('student')->user()->id;
            $batchData = AllotBatch::where(['students_id'=>$studentId,'subjects_id'=>$id,'status'=>1])->count();
            if($batchData <= 0){
                return redirect()->back();
            }else{
                $subject = \DB::table('subjects')->select('id','sub_name','sub_description')->where('id',$id)->where('status','=',1)->first();
                foreach ($subject as $subjec) {
                    $id = $subject->id;
                    $name = $subject->sub_name;
                }
                
                $uploadData = \DB::table('foldersystems')
                ->WHERE('subjects_id', '=',  $id)
                ->WHERE('parent_node', '=',  0)
                ->orderBy('id', 'ASC')->get();
                return view('student.subject-details',['subject'=>$subject,'uploadData'=>$uploadData]);
            }
        }

    }

    public function updateStudentPass(Request $req){
        $req->validate([
            'password'=>'required'
        ],[
            'password.required'=>'This Feild is Required'
        ]);

        // dd($req->all());
        $changepass = Students::WHERE('id','=',$req->sid)->first();
        if($changepass){
            $changepass->password =\Hash::make($req->password); 
            $changepass->save();
            return redirect()->back()->withSuccess('Password Updated Succesfully!!');
        }
        return redirect()->back()->with('error','OOps!! Something Went Wrong!!');
    }

    public function updatePass(Request $req){
        $req->validate([
            'updatepassword'=>'required'
        ],[
            'updatepassword.required'=>'This Feild is required!'
        ]);

        $student = Students::where('id',$req->sid)->first();
        if(!is_null($student)){

            $student->password  = \Hash::make($req->updatepassword);   
            $student->logged_in_devices  = 0;
            $student->save();     
            \DB::table('sessions')->where('student_user_id',$req->sid)->delete();
            return redirect()->back()->withSuccess('Password Updated');
        }
        return redirect()->back()->with('error','Something Went Wrong!!');
    }


    public function fetchStudent($student_id = null){
        $student = \DB::table('students')->select('fname','lname','id')->WHERE('id',$student_id)->get();
        return response()->json([
            'status'=>1,
            'students'=>$student
        ]);
    }

    public function fetchCity(Request $req){
        $city = City::WHERE('state_id',$req->state)->get();
        return response()->json([
            'status'=>1,
            'city'=>$city
        ]);
    }

    public function fetchCityStudent(Request $req){
        $city = City::WHERE('state_id',$req->state)->get();
        return response()->json([
            'status'=>1,
            'city'=>$city
        ]);
    }

    public function studentOnlineClasses(){
        $data['classData'] = OnlineClass::select('online_classes.id','title','subject_id','start_date_time','duration','meeting_id','passcode','created_by')->join('allot_batches as ab','ab.subjects_id','subject_id')->where('students_id',Auth()->guard('student')->user()->id)->where('status',1)->orderBy('online_classes.id','DESC')->paginate(50);
        return view('student.student-online-classes',$data);
    }

    public function fetchUserLoginDetails($student_id = null,UserAgent $userAgent){
        $deviceData = \DB::table('sessions')->where('student_user_id',$student_id)->get();
        $finalData = [];
        foreach($deviceData as $key=> $val){
           $finalData[$key] = $val;
           $userAgent->setAgent($val->user_agent);
           $agentData = $userAgent->getInfo();
           // dd($agentData);
           $finalData[$key]->device = $agentData['device_type'];
           $finalData[$key]->os = $agentData['os'];
           $finalData[$key]->browser = $agentData['browser'];
           $finalData[$key]->last_activity = date("d M Y H:i A",$val->last_activity);
        }
        if(count($deviceData)){
            return response()->json([
                'status'=>1,
                'deviceData'=>$finalData
            ]);
        }
        return response()->json([
            'status'=>0,
        ]);

    }

}
