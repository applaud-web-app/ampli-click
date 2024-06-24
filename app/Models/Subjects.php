<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;
    public function foldersystems(){
        return $this->hasMany(Foldersystem::class,'subjects_id','id')->where('type','!=','Folder')->where('status','=',1);
    }

    public function allot_subjects(){
        return $data = $this->hasMany(AllotBatch::class,'subjects_id','id')->where('status','=',1);
    }
}
