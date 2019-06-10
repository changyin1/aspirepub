<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleCustomAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_custom_agents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('agent_name');
            $table->unsignedInteger('schedule');
            $table->foreign('schedule')->references('id')->on('schedules');
            $table->boolean('contacted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_custom_agents');
    }
}
