<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveClientFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function ($table) {
            $table->dropColumn('state');
            $table->dropColumn('zip');
            $table->dropColumn('timezone');
            $table->dropColumn('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function ($table) {
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('timezone')->nullable();
            $table->string('address')->nullable();
        });
    }
}
