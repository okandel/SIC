<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('FirmId');
            $table->text('Client_IDs')->nullable();
            $table->text('Emp_IDs')->nullable();
            $table->string('subject', 500);
            $table->text('message')->nullable();
            $table->timestamp('published_at')->default(Carbon::today());
            $table->timestamps();
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->foreign('FirmId')->references('id')->on('firms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
