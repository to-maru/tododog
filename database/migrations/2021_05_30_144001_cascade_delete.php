<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CascadeDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_setting_analyses', function (Blueprint $table) {
            $table->dropForeign('routine_watcher_settings_id_foreign');
//            $table->foreignId('id')->constrained('users')->cascadeOnDelete()->change();
            $table->foreign('id')->references('id')->on('users')->cascadeOnDelete()->change();
        });

        Schema::table('user_setting_notifications', function (Blueprint $table) {
            $table->dropForeign('notifiers_user_id_foreign');
//            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->change();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->change();
        });

        Schema::table('todo_applications', function (Blueprint $table) {
            $table->dropForeign('todo_applications_id_foreign');
//            $table->foreignId('id')->unique()->constrained('users')->cascadeOnDelete()->change();
            $table->foreign('id')->references('id')->on('users')->cascadeOnDelete()->change();
        });

        Schema::table('todos', function (Blueprint $table) {
            $table->dropForeign('todos_todo_application_id_foreign');
//            $table->foreignId('todo_application_id')->constrained()->cascadeOnDelete()->change();
            $table->foreign('todo_application_id')->references('id')->on('todo_applications')->cascadeOnDelete()->change();
        });

        Schema::table('todo_done_datetimes', function (Blueprint $table) {
            $table->dropForeign('todo_done_datetimes_todo_id_foreign');
//            $table->foreignId('todo_id')->constrained()->cascadeOnDelete()->change();
            $table->foreign('todo_id')->references('id')->on('todos')->cascadeOnDelete()->change();
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
            $table->dropForeign('user_setting_analyses_id_foreign');
            $table->foreign('id')->references('id')->on('users')->change();
        });

        Schema::table('user_setting_notifications', function (Blueprint $table) {
            $table->dropForeign('user_setting_notifications_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->change();
        });

        Schema::table('todo_applications', function (Blueprint $table) {
            $table->dropForeign('todo_applications_id_foreign');
            $table->foreign('id')->references('id')->on('users')->change();
        });

        Schema::table('todos', function (Blueprint $table) {
            $table->dropForeign('todos_todo_application_id_foreign');
            $table->foreign('todo_application_id')->references('id')->on('todo_applications')->change();
        });

        Schema::table('todo_done_datetimes', function (Blueprint $table) {
            $table->dropForeign('todo_done_datetimes_todo_id_foreign');
            $table->foreign('todo_id')->references('id')->on('todos')->change();
        });
    }
}
