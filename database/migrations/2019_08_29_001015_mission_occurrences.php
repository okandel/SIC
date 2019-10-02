<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MissionOccurrences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_occurrences', function (Blueprint $table) {

            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('MissionId');
            $table->unsignedBigInteger('EmpId')->nullable();
            $table->unsignedInteger('StatusId')->nullable();
            $table->unsignedInteger('ReasonId')->nullable();
            $table->dateTime('scheduled_date')->nullable();
            $table->text('comment'); 
            $table->timestamps();
        });
        Schema::table('mission_occurrences', function (Blueprint $table) { 
       
            $table->foreign('MissionId')->references('id')->on('missions');
            $table->foreign('StatusId')->references('id')->on('mission_statuses');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mission_occurrences');
    }
}
