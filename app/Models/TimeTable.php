<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;

    public function subject(){
        return $this->belongsTo(Subjects::class,'subject_id','id');
    }

    public function batch(){
        return $this->belongsTo(Batch::class,'batch_id','id');
    }

    public function course(){
        return $this->belongsTo(Category::class,'course_id','id');
    }
}
