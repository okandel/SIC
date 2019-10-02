<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_branches', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('ClientId');
            $table->string('display_name', 200);
            $table->string('contact_person', 200);
            $table->string('email', 200)->nullable();
            $table->string('phone', 200);
            $table->integer('CountryId')->nullable();
            $table->integer('StateId')->nullable();
            $table->integer('CityId')->nullable();
            $table->string('address', 2000);
            $table->point('location')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('client_branches', function (Blueprint $table) { 
            $table->foreign('ClientId')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_branches');
    }
}
