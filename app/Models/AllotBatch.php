<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllotBatch extends Model
{
    use HasFactory;

    public function show_batches(){
        return $this->belongsTo(Batch::class,'batches_id','id');
    }

    public function show_subjects(){
        return $this->belongsTo(Subjects::class,'id','students_id');
    }

    public function student(){
        return $this->belongsTo(Students::class,'students_id','id');
    }
}
