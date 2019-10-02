<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('missions', function(Blueprint $table)
        {
            $table->string('repeat_value', 200)->nullable()->change();
            $table->integer('total_cycle')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('missions', function(Blueprint $table)
        {
            $table->string('repeat_value', 200)->nullable(false)->change();
            $table->integer('total_cycle')->nullable(false)->change();
        });
    }
}
