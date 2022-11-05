<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password')->nullable();

            $table->string('phone')->nullable();
            $table->string('alternative_phone')->nullable();
            $table->unsignedSmallInteger('designation_id');

            $table->unsignedTinyInteger('gender')->nullable()->comment('1=Male, 2=Female');
            $table->date('date_of_birth')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('nid')->nullable();

            $table->string('father')->nullable();
            $table->string('mother')->nullable();

            $table->unsignedBigInteger('present_address_id')->nullable();
            $table->unsignedBigInteger('permanent_address_id')->nullable();

            $table->json('salaries')->nullable();

            $table->date('joining_date')->nullable();
            $table->boolean('active')->default(1);

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
        Schema::dropIfExists('staff');
    }
}
