<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutineWatcherSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine_watcher_settings', function (Blueprint $table) {
            $table->foreignId('id')->constrained('users');
            $table->bigInteger('project_id')->nullable();
            $table->jsonb('tag_ids')->nullable();
            $table->boolean('due_filter')->nullable();
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
        Schema::dropIfExists('routine_watcher_settings');
    }
}
