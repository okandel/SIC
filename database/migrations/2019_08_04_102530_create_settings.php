<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->string('key', 500); 
            $table->string('value', 200); 
        });

        Schema::table('settings', function (Blueprint $table) { 
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
        Schema::dropIfExists('settings');
    }
}
