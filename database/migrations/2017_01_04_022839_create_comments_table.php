<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
         /*   $table->increments('id');
            $table->text('content');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('article_id')->unsigned();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->timestamps();*/
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->text('content');
            $table->unsignedInteger('commentable_id');
            $table->string('commentable_type');
            $table->unsignedInteger('parent_id')->nullable();
            $table->smallInteger('level')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
