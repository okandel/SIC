<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentMissionTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('incident_mission_tasks', function (Blueprint $table) {
        
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('IncidentMissionId');
            $table->unsignedBigInteger('ItemId');
            $table->tinyInteger('TypeId');  
        });
        Schema::table('incident_mission_tasks', function (Blueprint $table) { 
            $table->foreign('IncidentMissionId')->references('id')->on('incident_missions');
            $table->foreign('ItemId')->references('id')->on('items');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incident_mission_tasks');
    }
}
