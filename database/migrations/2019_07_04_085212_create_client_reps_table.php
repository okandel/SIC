<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_reps', function (Blueprint $table) { 
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('ClientId');
            $table->string('first_name', 200);
            $table->string('last_name', 200);
            $table->string('position', 200);
            $table->string('email', 200);
            $table->string('phone', 200);
            $table->string('image', 1000)->nullable();
            $table->boolean('email_verified')->default(0);
            $table->boolean('phone_verified')->default(0);
            $table->boolean('is_main_contact')->default(0);


            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('client_reps', function (Blueprint $table) { 
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
        Schema::dropIfExists('client_reps');
    }
}
