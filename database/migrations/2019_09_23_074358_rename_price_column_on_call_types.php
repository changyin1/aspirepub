<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenamePriceColumnOnCallTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('call_types', function (Blueprint $table) {
            $table->renameColumn('price', 'caller_amount');
            $table->string('coach_amount')->default('0.00');
            $table->string('grandfather_amount')->default('0.00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_types', function (Blueprint $table) {
            $table->renameColumn('caller_amount', 'price');
            $table->dropColumn('coach_amount');
            $table->dropColumn('grandfather_amount');
        });
    }
}
