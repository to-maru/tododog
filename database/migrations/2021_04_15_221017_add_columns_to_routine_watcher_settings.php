<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToRoutineWatcherSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routine_watcher_settings', function (Blueprint $table) {
            $table->boolean('cheat_day_enabled')->default('true');
            $table->integer('cheat_day_interval')->default(7);
            $table->integer('footprints_number')->default(7);
            $table->foreignId('footnote_prefix_id')->nullable();
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
            $table->dropColumn('cheat_day_enabled');
            $table->dropColumn('cheat_day_interval');
            $table->dropColumn('footprints_number');
            $table->dropColumn('footnote_prefix_id');
        });
    }
}
