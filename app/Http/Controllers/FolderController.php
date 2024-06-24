<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Storage;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Subjects;
use App\Models\Foldersystem;
// use Common;
use Illuminate\Support\Facades\Log;



class FolderController extends Controller
{
    public function index($id){
        $subject = \DB::table('subjects')->select('id','sub_name','categories_id')->where('id',$id)->first();
        foreach ($subject as $subjec) {
            $id = $subject->id;
            $name = $subject->sub_name;
        }
        
        $uploadData = \DB::table('foldersystems')
        ->WHERE('subjects_id', '=',  $id)
        ->WHERE('parent_node', '=',  0)
        ->orderBy('id', 'ASC')->get();
        \Session::put('can-access','test');
        return view('user.upload-folder',['subject'=>$subject,'uploadData'=>$uploadData]);
    }

    public function Upload(Request $req){

        // dd($req->all());
        if($req->f_type == "Media"){
            $req->validate([
                'f_name'=> 'required',
            ],[
                'f_name.required'=>'This Feild is required',
            ]);

            $fileSystem = new Foldersystem;
            if(isset($req->image)){
                // NEW CODE
                $uploadedFile = $req->image;
                $filename = "MEDIA-" . rand() . "." . $uploadedFile->getClientOriginalExtension();
                $directory = 'filemanager/media';
                $path = Storage::disk('blockstorage')->putFileAs($directory, $uploadedFile, $filename);
                $fileSystem->description = $filename;
            }else{
                return redirect()->back()->with('error','Please Upload a Media File');
            }
            $fileSystem->subjects_id  = $req->sid;
            $fileSystem->node_name = $req->f_name;
            $fileSystem->type = $req->f_type;
            $fileSystem->save();
            return redirect()->back()->withSuccess('Media Uploaded');

        }else if($req->f_type == "Video"){
            $req->validate([
                'video_title'=> 'required',
                'file_name'=> 'required'
            ],[
                'f_name.required'=>'This Feild is required',
                'file_name.required'=>'This Feild is required'
            ]);

            $file = new Foldersystem;
            $file->subjects_id  = $req->sid;
            $file->node_name = $req->video_title;
            $file->type = $req->f_type;
            $file->description = $req->file_name;
            $file->save();
            return redirect()->back()->withSuccess('Video Uploaded');

        }else{

            $req->validate([
                'folder_name'=> 'required',
                'f_description'=> 'required'
            ],[
                'folder_name.required'=>'This Feild is required',
                'f_description.required'=>'This Feild is required'
            ]);

            $folder = new Foldersystem;
            $folder->subjects_id  = $req->sid;
            $folder->node_name = $req->folder_name;
            $folder->description = $req->f_description;
            $folder->type = $req->f_type;
            $folder->save();

            return redirect()->back()->withSuccess('Folder Uploaded');
           
        }
        
    }

    public function Uploadsub(Request $req){

        if($req->f_type == "Media"){
            $req->validate([
                'f_name'=> 'required',
                'image'=> 'required'
            ],[
                'f_name.required'=>'This Feild is required',
                'image.required'=>'This Feild is required'
            ]);

            $fileSystem = new Foldersystem;
            if(isset($req->image)){
                // NEW CODE
                $uploadedFile = $req->image;
                $filename = "MEDIA-" . rand() . "." . $uploadedFile->getClientOriginalExtension();
                $directory = 'filemanager/media';
                $path = Storage::disk('blockstorage')->putFileAs($directory, $uploadedFile, $filename);
                $fileSystem->description = $filename;
            }else{
                return redirect()->back()->with('error','Please Upload a Media File');
            }

            $fileSystem->subjects_id  = $req->sid;
            $fileSystem->node_name = $req->f_name;
            $fileSystem->parent_node = $req->parentFolder;
            $fileSystem->type = $req->f_type;
            $fileSystem->save();

            return redirect()->back()->withSuccess('Media Uploaded');
        }else if($req->f_type == "Video"){
            $req->validate([
                'video_title'=> 'required',
                'file_name'=> 'required'
            ],[
                'f_name.required'=>'This Feild is required',
                'file_name.required'=>'This Feild is required'
            ]);

            $file = new Foldersystem;
            $file->subjects_id  = $req->sid;
            $file->node_name = $req->video_title;
            $file->type = $req->f_type;
            $file->description = $req->file_name;
            $file->parent_node = $req->parentFolder;
            $file->save();
            return redirect()->back()->withSuccess('Video Uploaded');
        }else{
            $req->validate([
                'folder_name'=> 'required',
                'f_description'=> 'required'
            ],[
                'folder_name.required'=>'This Feild is required',
                'f_description.required'=>'This Feild is required'
            ]);

            $folder = new Foldersystem;
            $folder->subjects_id  = $req->sid;
            $folder->node_name = $req->folder_name;
            $folder->description = $req->f_description;
            $folder->parent_node = $req->parentFolder;
            $folder->type = $req->f_type;
            $folder->save();

            return redirect()->back()->withSuccess('Folder Uploaded');
           
        }
        
    }

    public function showchild(Request $req){
        $childs = \DB::table('foldersystems')->where('parent_node',$req->input('child_folder'))->get();
        return response()->json([
            'status'=>1,
            'childs'=>$childs
        ]);
    }

    public function upload2(Request $request) {
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        $save = $receiver->receive();
        if ($save->isFinished()) {
            return $this->saveFile($save->getFile(), $request);
        }
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }
    protected function saveFile(UploadedFile $file, Request $request) {
        $fileName = $this->createFilename($file);
        $filePath = "filemanager/videos/{$fileName}";
        $mime = str_replace('/', '-', $file->getMimeType());
        // Store the file in Vultr Block Storage
        Storage::disk('blockstorage')->put($filePath, fopen($file->getPathname(), 'r+'));
        // Optionally, delete the local file if not needed
        unlink($file->getPathname());
        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }
    protected function createFilename(UploadedFile $file) {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName());
        $filename = "VIDEO-".rand().$filename;
        return $filename.".".$extension;
    }
    public function delete(Request $request) {
        $file = $request->filename;
        $filePath = "filemanager/videos/{$file}";
        if (Storage::disk('blockstorage')->delete($filePath)) {
            return response()->json(['status' => 'ok'], 200);
        } else {
            return response()->json(['status' => 'error'], 403);
        }
    }

   public function deleteData($id){
        $folderData = Foldersystem::Where('id',$id)->first();
        if($folderData != NULL){
            $childData = Foldersystem::Where('parent_node',$id)->delete();
            $folderData->delete();
            return redirect()->back()->with('success','Deleted Successfully');
        }
        return redirect()->back();
   }

    public function uploadListingGallery(Request $request)
    {
        // Disable caching for uploads
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $chunkDir = '/mnt/blockstorage/filemanager/chunks/';
        $finalDir = '/mnt/blockstorage/filemanager/videos/';
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 15 * 3600; // Temp file age in seconds

        // Create directories if they don't exist
        if (!file_exists($chunkDir)) {
            mkdir($chunkDir, 0777, true);
        }
        if (!file_exists($finalDir)) {
            mkdir($finalDir, 0777, true);
        }

        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $chunkFilePath = $chunkDir . DIRECTORY_SEPARATOR . $fileName;
        $tempFilePath = $chunkFilePath . '.part';
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

        // Remove old temporary files
        if ($cleanupTargetDir) {
            if (!is_dir($chunkDir) || !$dir = opendir($chunkDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $chunkDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to next
                if ($tmpfilePath == "{$chunkFilePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }

        // Open temp file
        if (!$out = fopen($tempFilePath, $chunk == 0 ? "wb" : "ab")) { // Use "wb" for the first chunk and "ab" for subsequent chunks
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        // Acquire an exclusive lock on the file
        if (flock($out, LOCK_EX)) {
            // Read binary input stream and append it to temp file
            if (!empty($_FILES)) {
                if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                    fclose($out);
                    die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
                }

                if (!$in = fopen($_FILES["file"]["tmp_name"], "rb")) {
                    fclose($out);
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }
            } else {
                if (!$in = fopen("php://input", "rb")) {
                    fclose($out);
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                }
            }

            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }

            fclose($in);
            fflush($out); // Flush output before releasing the lock
            flock($out, LOCK_UN); // Release the lock
        }

        fclose($out);

        // Check if file has been uploaded fully
        if (!$chunks || $chunk == $chunks - 1) {
            // Generate a unique new filename to avoid collisions
            $newFileName = time() . '_' . Str::random(10) . '_' . $fileName;
            $finalFilePath = $finalDir . DIRECTORY_SEPARATOR . $newFileName;

            // Validate and finalize the file
            if ($this->finalizeFile($tempFilePath, $finalFilePath)) {
                $this->deleteChunkFiles($chunkDir); // Clean up chunk files after completion
            } else {
                die('{"jsonrpc" : "2.0", "error" : {"code": 104, "message": "File finalization failed."}, "id" : "id"}');
            }

            $arr = [
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => '200',
                    'message' => 'files uploaded',
                    'id' => $newFileName
                ]
            ];
        } else {
            $arr = [
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => '201',
                    'message' => 'chunk uploaded',
                    'id' => $fileName
                ]
            ];
        }

        return response()->json($arr);
    }

    private function finalizeFile($tempFilePath, $finalFilePath)
    {
        // Validate the integrity of the file if needed
        if (rename($tempFilePath, $finalFilePath)) {
            return true;
        }
        return false;
    }

    private function deleteChunkFiles($targetDir)
    {
        if ($dir = opendir($targetDir)) {
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
                if (preg_match('/\.part$/', $file)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }
    }
}
