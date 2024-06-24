<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\AllotBatch;
use App\Models\Foldersystem;
use Illuminate\Http\Request;
use Storage;
class ImageViewController extends Controller
{
    public function courseMedia($subjectId,$file){
        // check students purchase or allot this subject
      
        // if(\Session::get('can-access')!="TST_SESSION_VDO"){
        //     return abort(404);
        // }
        // \Session::put('can-access','TST_SESSION_VDO_DND');

        if(url()->previous()==url('course-media/'.$subjectId.'/'.$file)){
            return abort(404);
        }
        // echo \Session::get('can-access');die;
        if(\Auth::check()){
            // $filepath = storage_path("app/filemanager/videos/".$file);
            // return response()->file($filepath);

            // NEW
            $filePath = 'filemanager/videos/' . $file;
            $fullPath = Storage::disk('blockstorage')->path($filePath);
        
            if (file_exists($fullPath)) {
                return response()->file($fullPath);
            } else {
                abort(404, 'File not found');
            }
        }
        if(\Auth::guard('student')->check()){
            $studentId = Auth('student')->user()->id;
            $batchData = AllotBatch::where(['students_id'=>$studentId,'subjects_id'=>$subjectId,'status'=>1])->first();
            if($batchData){
                // $filepath = storage_path("app/filemanager/videos/".$file);
                $filePath = 'filemanager/videos/' . $file;
                $fullPath = Storage::disk('blockstorage')->path($filePath);
                
                return response()->file($fullPath);
            }
        }
        return abort(404);
    }

    // this
    public function accessCourseMedia($subjectId,$fileId){
        
        if(\Auth::guard('student')->check()){
            // \Session::put('can-access','TST_SESSION_VDO');
            $studentId = Auth('student')->user()->id;

            $batchData = AllotBatch::where(['students_id'=>$studentId,'subjects_id'=>$subjectId,'status'=>1])->first();
            if($batchData){
                $fileData = Foldersystem::where(['id'=>$fileId,'subjects_id'=>$subjectId])->first();
                return view('student.access-course-media',compact('fileData'));
            }
        }
        if(\Auth::check()){
            \Session::flash('can-access','TST_SESSION_VDO');
            $fileData = Foldersystem::where(['id'=>$fileId,'subjects_id'=>$subjectId])->first();
            return view('user.access-course-media',compact('fileData'));
        }
        abort(404);
    }

    public function courseMediaFile($subjectId,$file){
        // check students purchase or allot this subject
        if(url()->previous()==url('course-media/'.$subjectId.'/'.$file)){
            return abort(404);
        }
        if(\Auth::check()){
            // $filepath = storage_path("app/filemanager/media/".$file);
            // return response()->file($filepath);

            // NEW
            $filePath = 'filemanager/media/' . $file;
            $fullPath = Storage::disk('blockstorage')->path($filePath);
        
            if (file_exists($fullPath)) {
                return response()->file($fullPath);
            } else {
                abort(404, 'File not found');
            }
        }
        if(\Auth::guard('student')->check()){
            $studentId = Auth('student')->user()->id;
            $batchData = AllotBatch::where(['students_id'=>$studentId,'subjects_id'=>$subjectId,'status'=>1])->first();
            if($batchData){
                // $filepath = storage_path("app/filemanager/media/".$file);

                $filePath = 'filemanager/media/' . $file;
                $fullPath = Storage::disk('blockstorage')->path($filePath);

                return response()->file($fullPath);
            }
        }
        return abort(404);
    }
}