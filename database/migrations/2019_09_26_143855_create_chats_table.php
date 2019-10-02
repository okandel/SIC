<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->unsignedBigInteger('UserId')->nullable();
            $table->unsignedBigInteger('EmployeeId')->nullable();
            $table->unsignedBigInteger('ClientRepId')->nullable();
            $table->unsignedBigInteger('MissionId')->nullable();
            $table->unsignedInteger('GroupId')->nullable();
            $table->string('from_entry_type', 1);
            $table->text('message')->nullable();
            $table->string('attachment_url', 2000)->nullable();
            $table->string('mime_type', 100)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->foreign('FirmId')->references('id')->on('firms');
            $table->foreign('UserId')->references('id')->on('firms_logins');
            $table->foreign('EmployeeId')->references('id')->on('employees');
            $table->foreign('ClientRepId')->references('id')->on('client_reps');
            $table->foreign('MissionId')->references('id')->on('missions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
