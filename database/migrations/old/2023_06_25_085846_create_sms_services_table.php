<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_services', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default("সাধারণ বার্তা");
            $table->text('body');
            $table->string('sender');
            $table->json('receivers');
            $table->unsignedTinyInteger('status')->default(1)->comment('1=>Preview, 2=>Send');
            $table->unsignedBigInteger('created_by')->index();
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
        Schema::dropIfExists('sms_services');
    }
}
