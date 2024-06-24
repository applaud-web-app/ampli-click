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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('categories_id')->unsigned();
            $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade');
            $table->bigInteger('sub_categories_id')->unsigned();
            $table->foreign('sub_categories_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->bigInteger('batches_id')->unsigned();
            $table->foreign('batches_id')->references('id')->on('batches')->onDelete('cascade');           
            $table->string('sub_name');
            $table->text('sub_description');
            $table->string('sub_image');
            $table->enum('status',['active'=>1, 'pending'=>0,'disable'=>2,'remove'=>3])->default(1);
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
        Schema::dropIfExists('subjects');
    }
};
