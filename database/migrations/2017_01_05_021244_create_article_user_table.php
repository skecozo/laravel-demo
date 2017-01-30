<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index;
            $table->integer('article_id')->unsigned()->index;
            $table->timestamps();
            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelte('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelte('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_article');
    }
}
