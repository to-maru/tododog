<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOffsetHourToUserSettingAnalyses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_setting_analyses', function (Blueprint $table) {
            $table->bigInteger('boundary_hour')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_setting_analyses', function (Blueprint $table) {
            $table->dropColumn('boundary_hour');
        });
    }
}
