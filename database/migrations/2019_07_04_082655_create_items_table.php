<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('items', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->unsignedBigInteger('ItemTemplateId')->nullable();
            $table->string('name', 200);
            $table->string('description', 2000);
            $table->string('image', 1000)->nullable();
            $table->text('item_payload')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('FirmId')->references('id')->on('firms');
            $table->foreign('ItemTemplateId')->references('id')->on('item_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('items');
    }
}
