<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Parents;
use App\Models\AllotBatch;
use App\Models\User;
use Auth;

class SubAdminController extends Controller
{
    public function index(){
        $subAdmin = User::Where('u_role',2)->where('status',1)->get();
        // dd($subAdmin);
        // die();
        return view('user.create-subAdmin',['subadmins'=>$subAdmin]);
    }

    public function createSubAdmin(Request $req){
        $req->validate([
            'name'=>'required',
            'designation'=>'required',
            'email'=>'email | required',
            'password'=>'required',
            'uploadImage'=>'mimes:jepg,jpg,png,gif | max:1000'
        ]);

        $chechUser = User::where('email',$req->email)->count();
        if($chechUser){
            return redirect()->back()->with('error','This Email already registered with us..');
        }

        $user = new User;
        if(isset($req->uploadImage)){
            $imageName =  "SUBADMIN-".rand().".".$req->uploadImage->extension();
            $req->uploadImage->move(public_path('upload/teachers/') , $imageName);  
            $user->image  = $imageName; 
        }

        $user->name  = $req->name;
        $user->designation  = $req->designation;
        $user->email  = $req->email;
        $user->password  = \Hash::make($req->password);  
        $user->u_role = 2;
        $user->save();
        return redirect()->back()->withSuccess('Sub Admin Created');
    }

    public function deleteSubAdmin(Request $req){
        $user = User::where('id',$req->id)->first();
        $user->status = 2;
        $user->save();
        return redirect()->back()->withSuccess('Deleted Succesfully');
    }

    public function editSubAdmin(Request $req){
        $user = User::Where('id','=',$req->input('id'))->first();
        return response()->json([
            'status'=>1,
            'user'=>$user
        ]);
    }

    public function updateSubadmin(Request $req){

        $chechUser = User::where('email',$req->email)->where('id',$req->input('id'))->count();
        if($chechUser > 1){
            return response()->json([
                'status'=>0,
                'message'=>'This Email is Alreay in use!!'
            ]);
        }

        $user = User::Where('id','=',$req->input('id'))->first();
        if(is_null($user)){
            return response()->json([
                'status'=>0,
                'message'=>'Something Went Wrong!!'
            ]);
        }

        if($req->hasFile('uploadImage')){
            $file = $req->file('uploadImage');
            $name = "SUBAMIN-".time().'.'.$file->getClientOriginalExtension();
            $image['filePath'] = $name;
            $file->move(public_path().'/upload/teachers/', $name);
            $user->image = $name;
        }

        $user->name = $req->input('name');
        $user->designation = $req->input('designation');
        $user->email   = $req->input('email');
        $user->password  = \Hash::make($req->password);  
        $user->save();
        return response()->json([
            'status'=>1,
            'message'=>'Sub-Admin Updated Succesfully!!'
        ]);
    }

     // Fetch By Status
     public function fetchSubAdminByStatus(Request $req){
        $user = User::WHERE('status',$req->input('status'))->where('u_role',2)->get();
        // dd($user);
        // die();
        return response()->json([
            'status'=>1,
            'users'=>$user
        ]);
    } 

    public function updateStatus(Request $req){
        $user = User::WHERE('id',$req->input('id'))->first();
        if($user != null){
            $user->status = $req->input('status');
            $user->save();
            
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

    public function search(Request $req){
        $user =  User::where('name', 'Like', "%".$req->input('search')."%")->where('status','=',$req->input('status'))->where('u_role',2)->get();
        return response()->json([
            'status'=>1,
            'users'=>$user
        ]);
    }
}
