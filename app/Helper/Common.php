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
            $directory = 'amp_file_manager/media';
        }else if($type == "Video"){
            $directory = 'amp_file_manager/video';
        }
        $path = Storage::disk('blockstorage')->putFileAs($directory, $uploadedFile, $filename);
        // Save the file description
        $file->description = $path;
    }
}