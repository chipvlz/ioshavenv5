<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "log";

    protected $fillable = [
      "level",
      "scope",
      "message"
    ];

    public static function emergency($scope, $message) {
      static::create([
        "level" => 0,
        "scope" => $scope,
        "message" => $message
      ]);
    }

    public static function alert($scope, $message) {
      static::create([
        "level" => 1,
        "scope" => $scope,
        "message" => $message
      ]);
    }

    public static function critical($scope, $message) {
      static::create([
        "level" => 2,
        "scope" => $scope,
        "message" => $message
      ]);
    }

    public static function error($scope, $message) {
      static::create([
        "level" => 3,
        "scope" => $scope,
        "message" => $message
      ]);
    }

    public static function warning($scope, $message) {
      static::create([
        "level" => 4,
        "scope" => $scope,
        "message" => $message
      ]);
    }

    public static function notice($scope, $message) {
      static::create([
        "level" => 5,
        "scope" => $scope,
        "message" => $message
      ]);
    }

    public static function info($scope, $message) {
      static::create([
        "level" => 6,
        "scope" => $scope,
        "message" => $message
      ]);
    }

    public static function debug($scope, $message) {
      static::create([
        "level" => 7,
        "scope" => $scope,
        "message" => $message
      ]);
    }
}
