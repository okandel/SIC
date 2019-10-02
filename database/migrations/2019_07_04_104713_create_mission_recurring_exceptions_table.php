<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionRecurringExceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_recurring_exceptions', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->unsignedBigInteger('MissionId')->nullable();
            $table->tinyInteger('exception_type');
            $table->string('exception_value', 200);
 
           
            $table->timestamps();
        });
        Schema::table('mission_recurring_exceptions', function (Blueprint $table) { 
            $table->foreign('FirmId')->references('id')->on('firms');
            $table->foreign('MissionId')->references('id')->on('missions'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mission_recurring_exceptions');
    }
}
