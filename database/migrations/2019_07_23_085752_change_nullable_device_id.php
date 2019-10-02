<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableDeviceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_assets', function(Blueprint $table)
        {
            $table->unsignedBigInteger('DeviceId')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_assets', function(Blueprint $table)
        {
            $table->unsignedBigInteger('DeviceId')->nullable(false)->change();
        });
    }
}
