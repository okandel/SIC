<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firms', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement(); 
            $table->unsignedTinyInteger('PlanId')->nullable();
            $table->integer('CustomCssId')->nullable();
            $table->integer('TimezoneId');
            $table->string('display_name', 200);
            $table->string('contact_person', 200);
            $table->string('email', 200);
            $table->string('phone', 200);

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('firms', function (Blueprint $table) { 
            $table->foreign('PlanId')->references('id')->on('plans'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firms');
    }
}
