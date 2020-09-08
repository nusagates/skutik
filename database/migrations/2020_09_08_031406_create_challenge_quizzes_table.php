<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('type')->default('multiple_choice');
            $table->longText('question');
            $table->double('difficulty')->default(1);
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
        Schema::dropIfExists('challenge_quizzes');
    }
}
