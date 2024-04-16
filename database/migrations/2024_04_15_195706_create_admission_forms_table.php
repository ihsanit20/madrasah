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
        Schema::create('admission_forms', function (Blueprint $table) {
            $table->id();

            $table->string('session')->index();

            $table->string('type')->default('new')->comment('new or old');
            $table->unsignedBigInteger('student_id')->nullable();

            $table->string('name');

            $table->unsignedTinyInteger('gender')->nullable()->comment('1=Male, 2=Female');
            $table->unsignedTinyInteger('blood_group')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('birth_certificate')->nullable();

            $table->json('fathers_info')->nullable();
            $table->json('mothers_info')->nullable();
            $table->unsignedTinyInteger('guardian_type');
            $table->json('guardian_info')->nullable();

            $table->json('present_address_info')->nullable();
            $table->unsignedTinyInteger('is_same_address');
            $table->json('permanent_address_info')->nullable();

            $table->json('previous_info')->nullable();

            $table->unsignedSmallInteger('class_id');
            $table->unsignedTinyInteger('resident');
            
            $table->unsignedTinyInteger('status')->default(1);

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
        Schema::dropIfExists('admission_forms');
    }
};
