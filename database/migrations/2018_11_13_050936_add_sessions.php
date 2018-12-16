<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('coach_id');
            $table->integer('campaign_id');
            $table->integer('scribe_id')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('scored_at')->nullable();
            $table->integer('call_recording_id')->nullable();
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
        Schema::dropIfExists('sessions');
    }
}
