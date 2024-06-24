<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function total_subject(){
        return $data = $this->hasMany(Subjects::class,'categories_id','id')->where('status','=',1);
    }

    public function total_batch(){
        return $data = $this->hasMany(Batch::class,'categories_id','id')->where('status','=',1);
    }
}
