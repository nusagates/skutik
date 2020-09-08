<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->longText('challenge_content');
            $table->text('challenge_title');
            $table->string('challenge_type', 20)->default('post')->index();
            $table->string('challenge_status', 20)->default('publish')->index();
            $table->string('comment_status', 20)->default('open');
            $table->string('challenge_password', 255)->nullable();
            $table->string('challenge_slug', 200)->unique()->index();
            $table->unsignedBigInteger('challenge_view')->default(0);
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
        Schema::dropIfExists('challenges');
    }
}
