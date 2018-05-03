<?php

namespace App\Database;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Version extends Schema
{
  public static function main($name, $callback) {
    static::create($name, function (Blueprint $table) use ($name, $callback) {
      $table->increments('id');
      $table->string('uid');
      $callback($table);
      $table->string("published_version")->nullable();
      $table->string("queued_version")->nullable();
      $table->string("saved_version");
      $table->timestamps();
    });
  }

  public static function versions($name, $callback) {
    static::create($name . '_versions', function (Blueprint $table) use ($name, $callback) {
      $table->increments('id');
      $table->string('uid');
      $table->integer('user_id');
      $table->integer($name . '_id');
      $table->string("commit")->nullable();
      $callback($table);
      $table->dateTime("released_at")->nullable();
      $table->timestamps();
    });
  }
}
