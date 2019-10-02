<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissionIdMissionTaskAttachent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_task_attachments', function($table) { 
            $table->unsignedBigInteger('MissionId')->nullable()->after('id');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mission_task_attachments', function (Blueprint $table) { 
            $table->dropColumn('MissionId');
        });
    }
}
