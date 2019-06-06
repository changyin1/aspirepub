<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientRegionCompanyColumnsToQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedInteger('client')->after('question')
                ->nullable()
                ->default(null);
            $table->unsignedInteger('company')->after('client')
                ->nullable()
                ->default(null);
            $table->unsignedInteger('region')->after('company')
                ->nullable()
                ->default(null);
            $table->foreign('client')->references('id')->on('clients');
            $table->foreign('company')->references('id')->on('companies');
            $table->foreign('region')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('client');
            $table->dropColumn('company');
            $table->dropColumn('region');
        });
    }
}
