<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['apps', 'previews'];
        foreach ($tables as $t) {
          Schema::create($t, function (Blueprint $table) {
              $table->increments('id');
              $table->integer('user_id');
              $table->string('uid');
              $table->string("status")->default("unpublished");
              $table->string('name')->default("No name");
              $table->string('icon')->nullable();
              $table->string('banner')->nullable();
              $table->string('unsigned')->nullable();
              $table->string('signed')->nullable();
              $table->string('apk')->nullable();
              $table->string('version')->nullable();
              $table->string('short')->default("A short snippet");
              $table->longText('description')->nullable();
              $table->string('tags')->nullable();
              $table->bigInteger('views')->default(0);
              $table->bigInteger('downloads')->default(0);
              $table->bigInteger('size')->default(0);
              $table->softDeletes();
              $table->timestamps();
          });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps');
        Schema::dropIfExists('previews');
    }
}
