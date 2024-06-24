<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allot_batches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('students_id')->unsigned();
            $table->foreign('students_id')->references('id')->on('students')->onDelete('cascade');
            $table->bigInteger('batches_id')->unsigned();
            $table->foreign('batches_id')->references('id')->on('batches')->onDelete('cascade'); 
            $table->tinyInteger('status')->default(1);        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allot_batches');
    }
};
