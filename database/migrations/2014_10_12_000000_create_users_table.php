<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar');
            $table->string('confirmation_token');
            $table->smallInteger('is_active')->default(0);
            $table->integer('contents_count')->default(0); //发表文章
            $table->integer('comments_count')->default(0); //多少评论
            $table->integer('favorites_count')->default(0); //收藏
            $table->integer('likes_count')->default(0);   //点赞
            $table->integer('followers_count')->default(0);   //关注人
            $table->integer('followings_count')->default(0); //被关注
            $table->rememberToken();
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
        Schema::drop('users');
    }
}