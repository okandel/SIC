<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionPrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_priorities', function (Blueprint $table) { 
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->string('name', 200);
            $table->tinyInteger('order');

            $table->timestamps();
        });
        Schema::table('mission_priorities', function (Blueprint $table) { 
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
        Schema::dropIfExists('mission_priorities');
    }
}
