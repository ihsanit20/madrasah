<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_forms', function (Blueprint $table) {
            $table->id();

            $table->string('session')->index();

            $table->string('name');
            $table->date('date_of_birth')->nullable();

            $table->string('phone')->nullable();
            $table->string('alternative_phone')->nullable();

            $table->string('nid')->nullable();
            $table->unsignedTinyInteger('gender')->nullable()->comment('1=Male, 2=Female');
            $table->unsignedTinyInteger('blood_group')->nullable();
            
            $table->json('fathers_info')->nullable();
            $table->json('mothers_info')->nullable();
            $table->json('reference_info')->nullable();

            $table->json('present_address_info')->nullable();
            $table->boolean('is_same_address');
            $table->json('permanent_address_info')->nullable();
            
            $table->json('educational_qualifications')->nullable();
            
            $table->json('previous_experience')->nullable();

            $table->unsignedSmallInteger('designation_id');
            $table->string('expected_salary')->nullable();

            $table->json('default_salaries')->nullable();

            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('complete_by')->nullable();

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
        Schema::dropIfExists('staff_forms');
    }
}
