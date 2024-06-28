<?php

namespace App\Http\Controllers;

use Session;
use stdClass;
use App\Models\User;
use App\Models\Parents;
use App\Models\Students;
use App\Models\Teachers;
use App\Services\UserAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

   public function login(){
    if(Auth::guard('student')->check()){
      return redirect()->intended('/');
    }
    return view('/auth.login');
   }

   public function studentLogin(Request $req){
     $req->validate([
        'username'=>'required',
        'password'=>'required'
     ],[
        'username.required'=>'Username is Required!!',
        'password.required'=>'Password is Required!!'
     ]);

     if(!\Session::has('CURRMOBLOGIN')){
         return redirect()->back()->with('error','Verify your mobile number to login');
     }
     
      // $credentials = $req->only('username','password');
      // if(Auth::guard('student')->attempt($credentials)){
      //    return redirect()->intended('/')->withSuccess('Login Succesfully!!');
      // }
      // return redirect()->back()->with('error','Login Details Are Not Valid!!');

      \Session::forget('CURRMOBLOGIN');

      $data= $req->all();
      $credentials = $req->only('username','password');
      if(Auth::guard('student')->attempt(['username'=>$data['username'],'password'=>$data['password'],'status' => function ($query) {
         $query->where('status', '!=', 2);
      }],true)){
         // 
         $allowedDevices = Auth::guard('student')->user()->allowed_devices;
         $loggedInDevice = Auth::guard('student')->user()->logged_in_devices;
         if(($loggedInDevice + 1) > $allowedDevices){
            Auth::guard('student')->logout();
            return redirect()->back()->with('error','Exceed no. of allowed devices..contact admin for more details');
         }
         Students::where('id',Auth::guard('student')->user()->id)->update(['logged_in_devices'=>\DB::raw("logged_in_devices + 1")]);
         return redirect()->intended('/')->withSuccess('Login Succesfully!!');
      }
      return redirect()->back()->with('error','Login Details Are Not Valid!!');
   }

   public function register(){
      
      if(Auth::guard('student')->check()){
         return redirect()->intended('/');
      }
      $regData = new stdClass();
      $regData->fname = '';
      $regData->lname = '';
      $regData->username = '';
      $regData->password = '';
      $regData->mobile = '';
      $regData->email = '';
      if(\Session::has('REGDETAILS')){
         $regData = json_decode(\Session::get('REGDETAILS'));
      }
      $data['regData'] = $regData;

      return view('/auth.register',$data);
   }

   public function studentRegisteration(Request $req){
      $req->validate([
         'fname'=>'required',
         'username'=>'required',
         'password'=>'required',
         'mobile'=>'required',
         // 'aadhar'=>'required'
      ],[
         'fname.required'=>'This Field is Required',
         'username.required'=>'This Field is Required',
         'password.required'=>'This Field is Required',
         'mobile.required'=>'This Field is Required'         
      ]);
      $chechUser = Students::where('username',$req->username)->count();
      if($chechUser){
         return redirect()->back()->with('error','This Username is already in use.');
      }
      \Session::put('REGDETAILS',json_encode($req->all()));
      return redirect('verify-mobile-number');
      // $student = new Students;

      // $student->fname  = $req->fname;
      // $student->lname  = $req->lname;
      // $student->username  = $req->username;
      // $student->mobile  = $req->mobile; 
      // $student->password  = \Hash::make($req->password); 
      // // $student->aadhar  = $req->aadhar; 
      // $student->status  = 3; 
      // $student->logged_in_devices  = 1; 
      // $student->save();

      // $lastId = $student->id;  
      // $parent = new Parents;
      // $parent->students_id = $lastId;
      // $parent->save();

      // if($student->save() && $parent->save()){
      //    $credentials = $req->only('username','password');
      //    if(Auth::guard('student')->attempt($credentials,true)){
      //       return redirect()->intended('/')->withSuccess('Login Succesfully!!');
      //    }
      // }
      // return redirect()->back()->withSuccess('Succesfully Regestered');
   }

   public function logout(){

      $student = Students::where('id',Auth::guard('student')->user()->id)->first();
      if($student->logged_in_devices > 0){
         $loginCount = $student->logged_in_devices;
         $student->logged_in_devices = $loginCount-1;
      }else{
         $student->logged_in_devices = 0;
      }
      $student->save();
      Auth::guard('student')->logout();
      return redirect()->intended('/login')->withSuccess('Succesfully Logout');
   }

   // Staff Login
   public function staffLogin(){
      if(Auth::guard('teacher')->check() || Auth::check()){
         return redirect()->intended('/dashboard');
       }
       return view('/auth.stafflogin');
   }

   public function staffLoginCheck(Request $req){
      $req->validate([
         'email'=>'required',
         'password'=>'required'
      ],[
         'email.required'=>'Email is Required!!',
         'password.required'=>'Password is Required!!'
      ]);

      $data= $req->all();
 
       $credentials = $req->only('email','password');
       if(Auth::guard('teacher')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1],true)){
         Session::put('user', 'Teacher');
          return redirect()->intended('/dashboard')->withSuccess('Login Succesfully!!');
       }
       return redirect()->back()->with('error','Login Details Are Not Valid!!');
    }

    public function stafflogout(){
      Auth::guard('teacher')->logout();
      Auth::logout();
      session()->flush();
      return redirect()->intended('/staffLogin')->withSuccess('Succesfully Logout');
   }

   public function adminProfile($id,UserAgent $userAgent){
     
      $data['adminData'] = User::where('id',$id)->get()->first();
      // $sessionData = \DB::table('sessions')->where('user_id',$id)->get();
      // $finalData = [];
      // foreach($sessionData as $key=> $val){
      //    $finalData[$key] = $val;
      //    $userAgent->setAgent($val->user_agent);
      //    $agentData = $userAgent->getInfo();
      //    // dd($agentData);
      //    $finalData[$key]->device = $agentData['device_type'];
      //    $finalData[$key]->os = $agentData['os'];
      //    $finalData[$key]->browser = $agentData['browser'];
      // }
      // $data['sessionData'] = $finalData;
      return view('user.admin-profile',$data);
   }

   public function updateAdminProfile(Request $req){
      $req->validate([
         'email'=>'required',
         'name'=>'required',
         'designation'=>'required'
      ],[
         'email.required'=>'Email is Required!!',
         'name.required'=>'This Field is Required!!',
         'designation.required'=>'This Field is Required'
      ]);
 
      $adminData = User::where('id',$req->uid)->first();
      if(isset($req->image)){
         $imageName =  "ADMIN-".rand().".".$req->image->extension();
         $req->image->move(public_path('upload/teachers/') , $imageName);  
         $adminData->image  = $imageName; 
      }

      $adminData->email = $req->email;
      $adminData->name = $req->name;
      $adminData->designation = $req->designation;
      $adminData->save();

      return redirect()->back()->withSuccess('Profile Updated!!');
   }

   public function completeRegestration(Request $req){
      $req->validate([
         'front_aadhar'=>'required',
         'back_aadhar'=>'required',
         'gender'=>'required',
         'state'=>'required',
         'city'=>'required',
         'permanent_address'=>'required',
         'aadhar'=>'required'
      ]);

      $student = Students::where('id',$req->sid)->first();

      if(isset($req->image)){

         $base64_image       = $req->image;
         list($type, $data)  = explode(';', $base64_image);
         list(, $data)       = explode(',', $data);
         $data               = base64_decode($data);
         $thumb_name         = "STUDENT-".rand().'.png';
         $thumb_path         = public_path("upload/student/" . $thumb_name);
         file_put_contents($thumb_path, $data);

         $student->image   = $thumb_name; 
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

     if(isset($req->back_aadhar)){

         $base64_image       = $req->back_aadhar;
         list($type, $data)  = explode(';', $base64_image);
         list(, $data)       = explode(',', $data);
         $data               = base64_decode($data);
         $thumb_name         = "AADHAR-".rand().'.png';
         $thumb_path         = public_path("upload/studentAadhar/" . $thumb_name);
         file_put_contents($thumb_path, $data);
         $student->aadhar_back  = $thumb_name; 
     }

      // if(isset($req->image)){
      //    $imageName =  "STUDENT-".rand().".".$req->image->extension();
      //    $req->image->move(public_path('upload/student/') , $imageName);  
      //    $student->image  = $imageName; 
      // }

      // if(isset($req->front_aadhar)){
      //    $imageName =  "AADHAR-".rand().".".$req->front_aadhar->extension();
      //    $req->front_aadhar->move(public_path('upload/studentAadhar/') , $imageName);  
      //    $student->aadhar_front  = $imageName; 
      // }

      // if(isset($req->back_aadhar)){
      //    $imageName =  "AADHAR-".rand().".".$req->back_aadhar->extension();
      //    $req->back_aadhar->move(public_path('upload/studentAadhar/') , $imageName);  
      //    $student->aadhar_back  = $imageName; 
      // }
      $student->local_address = $req->local_address;
      $student->local_city = $req->local_city;
      $student->local_state = $req->local_state;
      $student->address = $req->permanent_address;
      $student->gender = $req->gender;
      $student->dob = $req->dob;
      $student->state = $req->state;
      $student->city = $req->city;
      $student->aadhar = $req->aadhar;
      $student->status = 0;
      $student->save();

      $parent = Parents::where('students_id',$req->sid)->first();
      $parent->parent_fname = $req->pname;
      $parent->parent_lname = $req->plname;
      $parent->email = $req->pemail;
      $parent->number = $req->pmobile;
      $parent->save();

      return redirect()->back()->withSuccess('Regestration Completed');
   }

   public function updatePass(Request $req){
      $req->validate([
          'password'=>'required'
      ]);

      if($req->uid){
          $changepass = User::WHERE('id','=',$req->uid)->first();
          $changepass->password = \Hash::make($req->password); 
          $changepass->save();
          return redirect()->back()->with('success','Password Updated Successfully!!');
      }

      if($req->tid){
          $changepass = Teachers::WHERE('id','=',$req->tid)->first();
          $changepass->password = \Hash::make($req->password);  
          $changepass->save();

          return redirect()->back()->with('success','Password Updated Successfully!!');
      }
  }

  public function adminLogin(){
   if(Auth::check()){
      return redirect()->intended('/dashboard');
    }
    return view('/auth.adminLogin');
  }

  public function adminLogincheck(Request $req){
   $req->validate([
      'email'=>'required',
      'password'=>'required'
   ],[
      'email.required'=>'Email is Required!!',
      'password.required'=>'Password is Required!!'
   ]);

   $data= $req->all();
   
   if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1],true)){
      Session::put('user', 'Admin');
      return redirect()->intended('/dashboard')->withSuccess('Login Succesfully!!');
   }
    return redirect()->back()->with('error','Login Details Are Not Valid!!');
 }

   public function termAndcondition(){
      return view('auth.term-and-conditions');
   }

   public function verifyMobileNumber(){
      if(!\Session::has('REGDETAILS')){
         return redirect('register');
      }
      $sessionData = json_decode(\Session::get('REGDETAILS'));
      $data['phoneNumber'] = $sessionData->mobile;
      return view('auth.verify-mobile-number',$data);
   }

   public function setUserMob(Request $request){
      $sessionData = json_decode(\Session::get('REGDETAILS'));
      $sessionData->verified_mobile = $request->mob_num;
      \Session::put('REGDETAILS',json_encode($sessionData));
      return response()->json(['s'=>1]);
   }

   public function registerProcess(Request $req){
      if(!\Session::has('REGDETAILS')){
         return redirect('register');
      }
      $sessionData = json_decode(\Session::get('REGDETAILS'));
      if(isset($sessionData->verified_mobile)){
         if($sessionData->verified_mobile == $sessionData->mobile){
            $student = new Students;
            $student->fname  = $sessionData->fname;
            $student->lname  = $sessionData->lname;
            $student->username  = $sessionData->username;
            $student->mobile  = $sessionData->mobile; 
            $student->email  = $sessionData->email; 
            $student->password  = \Hash::make($sessionData->password); 
            // $student->aadhar  = $req->aadhar; 
            $student->status  = 3; 
            $student->logged_in_devices  = 1; 
            $student->save();
   
            $lastId = $student->id;  
            $parent = new Parents;
            $parent->students_id = $lastId;
            $parent->save();
            \Session::forget('REGDETAILS');
            if($student->save() && $parent->save()){
               $credentials = ['username'=>$sessionData->username,'password'=>$sessionData->password];
               if(Auth::guard('student')->attempt($credentials,true)){
                  //send mail to student
                  try{
                     $data = array('name'=>$sessionData->fname);
                     Mail::send('auth.student-register-email', $data, function($message) use($sessionData){
                        $message->to($sessionData->email, getenv('APP_NAME'))->subject
                           ('Laravel HTML Testing Mail');
                        $message->from(getenv('MAIL_FROM_ADDRESS'),getenv('MAIL_FROM_NAME'));
                     });
                  }catch(\Exception $e){

                  }
                  
                  return redirect()->intended('/')->withSuccess('Login Succesfully!!');
               }
            }
            return redirect()->back()->withSuccess('Succesfully Regestered');
         }
      }
      return redirect('register');
   }

   public function getStuMobile(Request $request){
      $username = $request->username;
      $password = $request->password;
      if(\Auth::guard('student')->validate(['username'=>$username,'password'=>$password])){
         $userData = Students::select('mobile')->where('username',$username)->first();
         return response()->json(['s'=>1,'mobile'=>substr($userData->mobile,-10)]);
      }
      return response()->json(['s'=>2,'mobile'=>'']);
   }

   public function setUserMobSess(Request $request){
      \Session::put('CURRMOBLOGIN',$request->mob_num);
      return response()->json(['s'=>1]);
   }

   public function logoutDevice($id){
      $sessionData = \DB::table('sessions')->where('id',$id)->first();
      $userId = $sessionData->student_user_id;
      \DB::table('sessions')->where('id',$id)->delete();
     
      if($userId){
         $studentData = Students::where('id',$sessionData->student_user_id)->first();
         if($studentData->logged_in_devices > 0){
            $logged_in_devices = $studentData->logged_in_devices -1;
         }else{
            $logged_in_devices = 0;
         }
         
         $studentData->logged_in_devices = $logged_in_devices;
         $studentData->remember_token = null;
         $studentData->save();
         return redirect()->back()->with('success','Device logged out successfully...');
      }
      return redirect()->back()->with('warning','User Loggoed Out Itself...or Some Error Occur');
   }

  

}
