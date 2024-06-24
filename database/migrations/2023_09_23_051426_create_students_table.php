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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('username');
            $table->string('image')->nullable()->default('default.png');
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile');
            $table->string('password');
            $table->string('aadhar');
            $table->string('gender')->nullable()->comment('1=>male,2=>female,3=>other');
            $table->tinyInteger('status')->default(1);
            $table->integer('allowed_devices')->default(1);
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('students');
    }
};
