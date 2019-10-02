<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->string('first_name', 200);
            $table->string('last_name', 200);
            $table->string('email', 200);
            $table->string('password', 200);
            $table->string('hash', 200);
            $table->string('phone', 200);
            $table->point('current_location')->nullable();
            $table->double('alt')->nullable();
            $table->float('speed')->nullable();
            $table->float('bearing_heading')->nullable();
            $table->boolean('email_verified')->default(0);
            $table->boolean('phone_verified')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('employees', function (Blueprint $table) { 
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
        Schema::dropIfExists('employees');
    }
}
