<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTodoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('todo_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('assigned_to')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('description');
            $table->string('repeat_type', 20)->default('once');
            $table->string('status', 20)->default('assigned');
            $table->integer('progress')->default(0);
            $table->integer('order')->default(0);
            $table->date('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('end_date')->nullable();
            $table->dateTime('finished_at')->nullable();
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
        Schema::dropIfExists('todo_lists');
    }
}
