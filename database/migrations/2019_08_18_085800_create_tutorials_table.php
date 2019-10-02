<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorials', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->string('title', 200);
            $table->text('content')->nullable();
            $table->string('image', 1000)->nullable();
            $table->timestamps();

        });

        Schema::table('tutorials', function (Blueprint $table) {
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
        Schema::dropIfExists('tutorials');
    }
}
