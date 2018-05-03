<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Database\Version;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Version::main('stories', function (Blueprint $table) {
            $table->integer("user_id");
        });

        Version::versions('story', function (Blueprint $table) {
          $table->string("type")->nullable();
          $table->string("title")->nullable();
          $table->string("mini")->nullable();
          $table->longText("content")->nullable();
          $table->string("image")->nullable();
          $table->string("tags")->nullable();
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
