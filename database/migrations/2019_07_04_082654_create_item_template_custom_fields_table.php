<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTemplateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_template_custom_fields', function (Blueprint $table) {
           
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('ItemTemplateId');
            $table->string('display_name', 200);
            $table->tinyInteger('type');
            $table->text('options')->nullable();
            $table->string('default_value', 100)->nullable();
            $table->boolean('is_required')->default(0);

            $table->timestamps();
        });
        Schema::table('item_template_custom_fields', function (Blueprint $table) {
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
        Schema::dropIfExists('item_template_custom_fields');
    }
}
