<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function allot_batches(){
        return $this->hasMany(AllotBatch::class,'batches_id','id')->where('status','=',1);
    }
}
