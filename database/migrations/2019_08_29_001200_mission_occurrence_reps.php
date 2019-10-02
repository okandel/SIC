<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MissionOccurrenceReps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_occurrence_reps', function (Blueprint $table) {

            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('MissionOccurenceId');
            $table->unsignedBigInteger('RepId'); 
            $table->foreign('MissionOccurenceId')->references('id')->on('mission_occurrences');
            $table->foreign('RepId')->references('id')->on('client_reps');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mission_occurrence_reps');
    }
}
