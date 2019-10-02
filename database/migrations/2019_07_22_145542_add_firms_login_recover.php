<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirmsLoginRecover extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firms_logins_recover', function (Blueprint $table) {
            $table->unsignedInteger('FirmId');
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
        Schema::table('firms_logins_recover', function (Blueprint $table) { 
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
        Schema::dropIfExists('firms_logins_recover');
    }
}
