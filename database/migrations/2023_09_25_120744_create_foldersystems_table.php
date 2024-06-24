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
        Schema::create('foldersystems', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subjects_id')->unsigned();
            $table->foreign('subjects_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->string('node_name');
            $table->bigInteger('parent_node')->default(0);
            $table->text('description')->nullable();
            $table->string('type');
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
        Schema::dropIfExists('foldersystems');
    }
};
