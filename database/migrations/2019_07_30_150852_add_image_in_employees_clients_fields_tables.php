<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageInEmployeesClientsFieldsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function($table) {
            $table->string('image', 1000)->nullable()->after('last_name');
        });

        Schema::table('clients', function($table) {
            $table->string('image', 1000)->nullable()->after('email');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('image');
        });

    }
}
