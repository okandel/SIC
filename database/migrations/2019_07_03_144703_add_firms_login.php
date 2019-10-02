<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirmsLogin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firms_logins', function (Blueprint $table) {

            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->string('first_name', 200);
            $table->string('last_name', 200);
            $table->string('email', 200);
            $table->string('password', 200);
            $table->string('phone', 200);
            $table->boolean('email_verified')->default(0);
            $table->boolean('phone_verified')->default(0);

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('firms_logins', function (Blueprint $table) {
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
        Schema::dropIfExists('firms_logins');
    }
}
