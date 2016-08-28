<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('years', function (Blueprint $table) {
            $table->unsignedInteger('year_id');
            $table->unsignedInteger('year_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('years', function (Blueprint $table) {
            $table->dropColumn('year_id', 'year_type');
        });
    }
}
