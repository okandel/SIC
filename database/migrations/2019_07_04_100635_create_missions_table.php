<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {

            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('EmpId');
            $table->unsignedBigInteger('AssignedBy');
            $table->unsignedInteger('PriorityId');
            $table->unsignedBigInteger('ClientBranchId');

            $table->string('title', 200);
            $table->text('description');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('complete_date')->nullable();
            $table->unsignedInteger('StatusId')->nullable();

            $table->tinyInteger('recurring_type')->nullable();
            $table->string('repeat_value', 200)->nullable();
            $table->integer('total_cycle')->nullable();



            $table->timestamps();
        });
        Schema::table('missions', function (Blueprint $table) {
            $table->foreign('EmpId')->references('id')->on('employees');
            $table->foreign('AssignedBy')->references('id')->on('firms_logins');
            $table->foreign('PriorityId')->references('id')->on('mission_priorities');
            $table->foreign('ClientBranchId')->references('id')->on('client_branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missions');
    }
}
