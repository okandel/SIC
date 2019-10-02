<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionTaskAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_task_attachments', function (Blueprint $table) {

            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('TaskId')->nullable();
            $table->string('attachment_url', 2000);
            $table->string('mime_type', 100);
           
            $table->timestamps();
        });
        Schema::table('mission_task_attachments', function (Blueprint $table) { 
            $table->foreign('TaskId')->references('id')->on('mission_tasks'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mission_task_attachments');
    }
}
