<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MissionOccurrenceTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_occurrence_task', function (Blueprint $table) {

            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('MissionOccurenceId');
            $table->unsignedBigInteger('TaskId')->nullable();
            $table->unsignedInteger('StatusId'); 
            $table->foreign('MissionOccurenceId')->references('id')->on('mission_occurrences');
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
        Schema::dropIfExists('mission_occurrence_task');
    }
}
