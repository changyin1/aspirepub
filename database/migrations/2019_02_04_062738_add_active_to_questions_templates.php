<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveToQuestionsTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions_templates', function (Blueprint $table) {
            $table->tinyInteger('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions_templates', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
}
