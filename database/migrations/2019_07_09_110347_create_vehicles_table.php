<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {

            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->string('type', 200);
            $table->string('brand', 200);
            $table->string('year', 200);
            $table->integer('no_of_passengers');
            $table->string('body_type'); 
            $table->timestamps();
        });
        Schema::table('vehicles', function (Blueprint $table) {
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
        Schema::dropIfExists('vehicles');
    }
}
