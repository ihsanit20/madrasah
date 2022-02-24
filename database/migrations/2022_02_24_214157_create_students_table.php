<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
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
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->unsignedTinyInteger('gender')->nullable()->comment('1=Male, 2=Female');
            $table->string('birth_certificate')->nullable();

            $table->unsignedBigInteger('father_info')->nullable();
            $table->unsignedBigInteger('mother_info')->nullable();
            $table->unsignedBigInteger('guardian_info')->nullable();

            $table->unsignedBigInteger('present_address_id')->nullable();
            $table->unsignedBigInteger('permanent_address_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
}
