<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmpAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::rename('mission_resources', 'mission_assets');


        Schema::create('employee_assets', function (Blueprint $table) {

            $table->unsignedBigInteger('id')->autoIncrement(); 
            $table->unsignedBigInteger('EmployeeId');
            $table->unsignedBigInteger('VehicleId');
            $table->unsignedBigInteger('DeviceId');
            $table->timestamps();
        });
        Schema::table('employee_assets', function (Blueprint $table) { 
            $table->foreign('EmployeeId')->references('id')->on('employees');
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
        Schema::rename('mission_assets', 'mission_resources');

        Schema::dropIfExists('employee_assets');
    }
}
