<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesCitiesRegions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('countries', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement(); 
           
            $table->string('name', 100);
            $table->string('iso3', 3)->nullable();
            $table->string('iso2', 2)->nullable();
            $table->string('phonecode', 255)->nullable();
            $table->string('capital', 255)->nullable();
            $table->string('currency', 255)->nullable();   
            $table->timestamps(); 
        });
        
        Schema::create('states', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement(); 
            $table->unsignedInteger('country_id')->nullable();
           
            $table->string('name', 255); 
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement(); 
            $table->unsignedInteger('state_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
           
            $table->string('name', 255); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
    }
}
