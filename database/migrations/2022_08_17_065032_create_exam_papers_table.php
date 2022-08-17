<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamPapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_papers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_class_id')->index();
            $table->string('subject_code', 4);
            $table->unsignedSmallInteger('time_in_minute')->default(180);
            $table->unsignedFloat('mark')->default(100);
            $table->unsignedTinyInteger('language_type')->default(1)->comment('1 = Bangla, 2 = Arabic, 3 = English');
            $table->string('top_text')->nullable();
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
        Schema::dropIfExists('exam_papers');
    }
}
