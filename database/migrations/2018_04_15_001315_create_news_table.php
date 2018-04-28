<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid');
            $table->integer("user_id");
            $table->string("published_version")->nullable();
            $table->string("saved_version");
            $table->timestamps();
        });

        Schema::create('story_versions', function (Blueprint $table) {
          $table->increments('id');
          $table->string('uid');
          $table->integer('user_id');
          $table->integer('story_id');
          $table->string("commit")->nullable();
          $table->string("type")->nullable();
          $table->string("title")->nullable();
          $table->string("mini")->nullable();
          $table->longText("content")->nullable();
          $table->string("image")->nullable();
          $table->string("tags")->nullable();
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
        Schema::dropIfExists('stories');
        Schema::dropIfExists('story_versions');
    }
}
