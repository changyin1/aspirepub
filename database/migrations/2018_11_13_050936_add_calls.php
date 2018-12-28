<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCalls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('schedule_id');
            $table->integer('call_specialist')->nullable();
            $table->integer('coach')->nullable();
            $table->text('agent_name')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('scored_at')->nullable();
            $table->integer('call_recording_id')->nullable();
            $table->text('caller_notes')->nullable();
            $table->text('coach_notes')->nullable();
            $table->integer('call_score')->nullable();
            $table->text('reservation_confirmation')->nullable();
            $table->text('reservation_first_name')->nullable();
            $table->text('reservation_last_name')->nullable();
            $table->date('arrival_date')->nullable();
            $table->date('departure_date')->nullable();
            $table->text('cancelation_confirmation')->nullable();
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
        Schema::dropIfExists('calls');
    }
}
