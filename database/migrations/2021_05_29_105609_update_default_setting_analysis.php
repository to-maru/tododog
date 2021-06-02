<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDefaultSettingAnalysis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_setting_analyses', function (Blueprint $table) {
            $table->boolean('autorun_enabled')->default(false)->change();
            $table->boolean('cheat_day_enabled')->default(false)->change();
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
            $table->boolean('autorun_enabled')->default(true)->change();
            $table->boolean('cheat_day_enabled')->default(true)->change();
        });
    }
}
