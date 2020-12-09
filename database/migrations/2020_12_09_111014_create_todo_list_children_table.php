<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoListChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_list_children', function (Blueprint $table) {
            $table->id();
            $table->foreignId("todo_list_id")->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->longText('description');
            $table->string('status', 20)->default('assigned');
            $table->integer('progress')->default(0);
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('todo_list_children');
    }
}
