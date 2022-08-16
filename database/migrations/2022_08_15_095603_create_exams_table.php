<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('session');
            $table->unsignedSmallInteger('class_id')->index();
            $table->string('subject_code', 4);
            $table->unsignedSmallInteger('time_in_minute')->default(180);
            $table->unsignedFloat('total_mark')->default(100);
            $table->unsignedTinyInteger('language_type')->default(1)->comment('1 = Bangla, 2 = Arabic, 3 = English');
            $table->string('top_text')->nullable();
            $table->string('bottom_text')->nullable();
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
        Schema::dropIfExists('exams');
    }
}
