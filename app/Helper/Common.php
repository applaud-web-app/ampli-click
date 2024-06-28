<?php

namespace App\Helper;

class Common
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public function uploadFileInBlockStorage($uploadedFile,$fileName,$type){
        if($type == "Media"){
            $directory = 'filemanager/media';
        }else if($type == "Video"){
            $directory = 'filemanager/video';
        }
        $path = Storage::disk('blockstorage')->putFileAs($directory, $uploadedFile, $filename);
        // Save the file description
        $file->description = $path;
    }
}