<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('todo_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('list_id')->nullable()
                ->constrained('todo_lists')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('log_type', 20)->default('created');
            $table->string('log_content')->nullable();
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
        Schema::dropIfExists('todo_logs');
    }
}
