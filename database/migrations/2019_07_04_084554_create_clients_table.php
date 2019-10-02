<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->boolean('IsApproved')->default(0);
            $table->string('contact_person', 200);
            $table->string('email', 200)->nullable();
            $table->string('phone', 200);

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('clients', function (Blueprint $table) { 
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
        Schema::dropIfExists('clients');
    }
}
