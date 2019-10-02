<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) { 

            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->string('os_type', 200);
            $table->string('display_name', 200);
            $table->string('device_unique_id', 200); 
            $table->timestamps(); 
        });
        Schema::table('devices', function (Blueprint $table) {
            $table->foreign('FirmId')->references('id')->on('firms'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
