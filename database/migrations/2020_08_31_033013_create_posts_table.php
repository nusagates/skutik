<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->longText('post_content');
            $table->text('post_title');
            $table->text('post_excerpt')->nullable();
            $table->string('post_type', 20)->default('post')->index();
            $table->string('post_status', 20)->default('publish')->index();
            $table->string('comment_status', 20)->default('open');
            $table->string('post_password', 255)->nullable();
            $table->string('slug', 200)->unique()->index();
            $table->unsignedBigInteger('post_view')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
