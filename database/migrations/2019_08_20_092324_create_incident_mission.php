<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentMission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('incident_missions', function (Blueprint $table) {
           
                $table->unsignedBigInteger('id')->autoIncrement(); 
                $table->unsignedBigInteger('EmpId'); 
                $table->unsignedBigInteger('ClientBranchId');
    
                $table->string('title', 200);
                $table->text('description')->nullable();  
    
                $table->timestamps();
            });
            Schema::table('incident_missions', function (Blueprint $table) { 
                $table->foreign('EmpId')->references('id')->on('employees'); 
                $table->foreign('ClientBranchId')->references('id')->on('client_branches');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incident_missions');
    }
}
