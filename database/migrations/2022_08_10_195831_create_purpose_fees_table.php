<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurposeFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purpose_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purpose_id')->index();
            $table->unsignedBigInteger('class_id')->index()->nullable();
            $table->unsignedFloat('amount');
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
        Schema::dropIfExists('purpose_fees');
    }
}
