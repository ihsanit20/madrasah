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
        Schema::create('software_charges', function (Blueprint $table) {
            $table->id();
            $table->string('purpose');
            $table->unsignedSmallInteger('total_student');
            $table->unsignedFloat('per_student_charge');
            $table->string('trx_id')->nullable();
            $table->unsignedFloat('amount')->default(0);
            $table->json('data')->nullable();
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
        Schema::dropIfExists('software_charges');
    }
};
