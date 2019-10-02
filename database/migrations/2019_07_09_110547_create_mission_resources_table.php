<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_resources', function (Blueprint $table) {

            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('MissionId');
            $table->unsignedBigInteger('VehicleId');
            $table->timestamps();
        });
        Schema::table('mission_resources', function (Blueprint $table) { 
            $table->foreign('MissionId')->references('id')->on('missions');
            $table->foreign('VehicleId')->references('id')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mission_resources');
    }
}
