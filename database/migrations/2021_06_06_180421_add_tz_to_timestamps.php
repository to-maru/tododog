<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTzToTimestamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todo_application_types', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('todo_application_types', function (Blueprint $table) {
            $table->timestampsTz();
        });

        Schema::table('todo_applications', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn('synced_at');
            $table->dropColumn('origin_created_at');
        });
        Schema::table('todo_applications', function (Blueprint $table) {
            $table->timestampsTz();
            $table->timestampTz('synced_at')->nullable();
            $table->timestampTz('origin_created_at')->nullable();
        });

        Schema::table('todo_done_datetimes', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn('done_datetime');
        });
        Schema::table('todo_done_datetimes', function (Blueprint $table) {
            $table->timestampsTz();
            $table->timestampTz('done_datetime');
        });

        Schema::table('todos', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn('origin_created_at');
        });
        Schema::table('todos', function (Blueprint $table) {
            $table->timestampsTz();
            $table->timestampTz('origin_created_at')->nullable();
        });

        Schema::table('user_setting_analyses', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('user_setting_analyses', function (Blueprint $table) {
            $table->timestampsTz();
        });

        Schema::table('user_setting_notifications', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('user_setting_notifications', function (Blueprint $table) {
            $table->timestampsTz();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropSoftDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todo_application_types', function (Blueprint $table) {
            $table->dropTimestampTzs();
        });
        Schema::table('todo_application_types', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('todo_applications', function (Blueprint $table) {
            $table->dropTimestampsTz();
            $table->dropColumn('synced_at');
            $table->dropColumn('origin_created_at');
        });
        Schema::table('todo_applications', function (Blueprint $table) {
            $table->timestamps();
            $table->timestamp('synced_at')->nullable();
            $table->timestamp('origin_created_at')->nullable();
        });

        Schema::table('todo_done_datetimes', function (Blueprint $table) {
            $table->dropTimestampsTz();
            $table->dropColumn('done_datetime');
        });
        Schema::table('todo_done_datetimes', function (Blueprint $table) {
            $table->timestamps();
            $table->timestamp('done_datetime');
        });

        Schema::table('todos', function (Blueprint $table) {
            $table->dropTimestampsTz();
            $table->dropColumn('origin_created_at');
        });
        Schema::table('todos', function (Blueprint $table) {
            $table->timestamps();
            $table->timestamp('origin_created_at')->nullable();
        });

        Schema::table('user_setting_analyses', function (Blueprint $table) {
            $table->dropTimestampsTz();
        });
        Schema::table('user_setting_analyses', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('user_setting_notifications', function (Blueprint $table) {
            $table->dropTimestampsTz();
        });
        Schema::table('user_setting_notifications', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropTimestampsTz();
            $table->dropSoftDeletesTz();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
