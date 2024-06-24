<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AllotBatch;
use App\Models\OnlineClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZoomController extends Controller
{
    public function onlineClasses(Request $request){
        if(Auth::check() || Auth::guard('teacher')->check() || Auth::guard('student')->check()){
            $id = \Crypt::decrypt($request->eq);
            $meetData = OnlineClass::find($id);
            if(Auth::guard('student')->check()){
                $checkData = AllotBatch::where(['status'=>1,'subjects_id'=>$meetData->subject_id,'students_id'=>Auth::guard('student')->user()->id])->count();
                if(!$checkData){
                    return redirect('/');
                }

            }
           
            $data['meetData'] = $meetData;
            $createdBy = 0;
            $fullName = '-';
            if(Auth::check()){
                $createdBy = Auth::id();
                $fullName = Auth::user()->name;
            }
            if(Auth::guard('teacher')->check()){
                $createdBy = Auth::guard('teacher')->user()->id;
                $fullName = Auth::guard('teacher')->user()->teacher_name;
            }
            if(Auth::guard('student')->check()){
                $fullName = Auth::guard('student')->user()->fname.' '.Auth::guard('student')->user()->lname;
            }

            $meetData->is_host = $createdBy == $meetData->created_by ? 1 : 0;
            $data['fullName'] = $fullName;
            return view('zoom.online-classes',$data);
        }
        return redirect('/');
       
    }

    public function currentMeeting(){
        return view('zoom.current-meeting');
    }

    public function generateZoomAccessToken(){
        $token = \Cache::remember('ZOOM_ACCESS_TOKEN',1800,function(){
            $accountId = getenv("ZOOM_ACCOUNT_ID");
            $apiKey = getenv("ZOOM_CLIENT_ID");
            $apiSecret = getenv('ZOOM_CLIENT_SECRET');
            $encoded = base64_encode($apiKey .":".$apiSecret);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://zoom.us/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=account_credentials&account_id='.$accountId,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic '.$encoded,
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response);
            return $data->access_token;
        });
        return $token;
    }
    
    public function storeOnlineClass(Request $request){
        $token = $this->generateZoomAccessToken();
        $url = 'https://api.zoom.us/v2/users/me/meetings';
        $dateTime = date("Y-m-d H:i:s",strtotime($request->start_date.' '.$request->start_time));
        $meetDateTime =  date("c", strtotime($dateTime));

        $meetingDetails = array(
            'topic' => $request->meeting_title,
            'type' => 2, // Scheduled meeting
            'start_time' => $meetDateTime, // Use ISO 8601 format for time
            'duration' => $request->duration, // Duration in minutes
            'timezone' => 'Asia/Kolkata'
        );
        // Headers for authentication
        $headers = array(
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        );
        // Make a POST request to create a meeting
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($meetingDetails));
        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpStatus == 201) {
            $resData = json_decode($response);
            // dd($resData);
            $classObj = new OnlineClass();
            $classObj->title = $request->meeting_title;
            $classObj->subject_id = $request->subject_id;
            $classObj->start_date_time = $dateTime;
            $classObj->duration = $request->duration;
            $classObj->meeting_id = $resData->id;
            $classObj->passcode = isset($resData->password) ? $resData->password: 'pascode';
            $classObj->created_by = Auth::check() ? Auth::id() : Auth::guard('teacher')->user()->id;
            $classObj->save();
            curl_close($ch);
            return redirect()->back()->with('success','class added successfully...');
        } else {
            // echo "Failed to create meeting. Status code: " . $httpStatus . "<br>";
            // echo "Response: " . $response;
            curl_close($ch);
        }
        return redirect()->back()->with('error','Something went wrong..class not added');  
    }

    public function onlineClassRemove(Request $request){
        $id = \Crypt::decrypt($request->eq);
        $meetingData = OnlineClass::find($id);
        $token = $this->generateZoomAccessToken();
        $meeting_id = $meetingData->meeting_id;
        $url = "https://api.zoom.us/v2/meetings/$meeting_id";
        $headers = array(
            "Authorization: Bearer $token",
            "Content-Type: application/json"
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        OnlineClass::where('id',$id)->delete();
        return redirect()->back()->with('success','Online class removed successfully...');
    }

}
