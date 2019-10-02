<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_devices', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('MissionId');
            $table->unsignedBigInteger('DeviceId');
            $table->timestamps();
        });
        Schema::table('mission_devices', function (Blueprint $table) { 
            $table->foreign('MissionId')->references('id')->on('missions');
            $table->foreign('DeviceId')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mission_devices');
    }
}
