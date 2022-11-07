<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $markJsonFormat = '[
            {
                "writing": double,
                "speaking": double,
                "student_id": int,
            },
            {
                "writing": double,
                "speaking": double,
                "student_id": int,
            }
        ]';

        Schema::create('results', function (Blueprint $table) use ($markJsonFormat) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('subject_code');
            $table->json('marks')->nullable()->comment($markJsonFormat);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['exam_id', 'class_id', 'subject_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
