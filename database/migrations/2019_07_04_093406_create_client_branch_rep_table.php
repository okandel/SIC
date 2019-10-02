<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientBranchRepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_branch_reps', function (Blueprint $table) { 
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('RepId');
            $table->unsignedBigInteger('BranchId'); 

            $table->timestamps();
        });
        Schema::table('client_branch_reps', function (Blueprint $table) { 
            $table->foreign('RepId')->references('id')->on('client_reps');
            $table->foreign('BranchId')->references('id')->on('client_branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_branch_rep');
    }
}
