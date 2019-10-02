<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMissionTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_tasks', function(Blueprint $table)
        {
            $table->unsignedInteger('TypeId')->change();
        });
        Schema::table('mission_tasks', function (Blueprint $table) {
            $table->foreign('TypeId')->references('id')->on('mission_task_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('mission_tasks', function (Blueprint $table) {  
            $table->dropForeign('mission_tasks_typeid_foreign');
        });

    }
}
