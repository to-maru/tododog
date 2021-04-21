<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAutorunColumnToRoutineWatcherSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routine_watcher_settings', function (Blueprint $table) {
            $table->boolean('autorun_enabled')->default('true');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routine_watcher_settings', function (Blueprint $table) {
            $table->dropColumn('autorun_enabled');
        });
    }
}
