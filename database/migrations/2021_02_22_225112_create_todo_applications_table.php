<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_applications', function (Blueprint $table) {
            $table->foreignId('id')->unique()->constrained('users');
            $table->bigInteger('type_id');
            $table->string('application_user_id');
            $table->string('access_token');
            $table->jsonb('raw_data')->nullable();
            $table->timestamp('synced_at')->nullable();
            $table->timestamp('origin_created_at')->nullable();
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
        Schema::dropIfExists('todo_applications');
    }
}
