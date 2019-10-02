<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_tasks', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('MissionId');
            $table->unsignedBigInteger('ItemId');
            $table->tinyInteger('TypeId');
            $table->integer('quantity')->nullable()->default(1);
            $table->text('item_payload')->nullable();
 

            $table->timestamps();
        });
        Schema::table('mission_tasks', function (Blueprint $table) { 
            $table->foreign('MissionId')->references('id')->on('missions');
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
        Schema::dropIfExists('mission_tasks');
    }
}
