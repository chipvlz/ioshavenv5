<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Report extends Model
{
    protected $table = "log";

    protected $fillable = [
      "user_id",
      "level",
      "method",
      "message",
      "data",
      "tags"
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }

    public static function e($e) {
      return [
        "message" => $e->getMessage(),
        "code" => $e->getCode(),
        "file" => $e->getFile(),
        "line" => $e->getLine(),
      ];
    }

    private static function checkLevel($level) {
      $levels = collect(["danger", "warning", "info", "success", "debug"]);
      if (!$levels->contains($level)) throw new \Exception("Invalid report level: $level");
    }

    public static function make($level, $options=[], $scope=null) {
      static::checkLevel($level);
      $tags = $options['tags'] ?? '';
      $tags = gettype($tags) === 'array' ? join(', ', $tags) : $tags;
      static::create([
        "user_id" => Auth::id() ?? 1,
        "level" => $level,
        "method" => $scope ?? static::getScope(3),
        "message" => $options['message'],
        "data" => json_encode($options['data'] ?? ''),
        "tags" => $tags
      ]);
      if ($level === 'danger') abort(503);
    }

    private static function getScope($backtrace) {
      try {
        $d = debug_backtrace()[$backtrace];
        $res = $d['class'] . '@' . $d['function'];
        return $res;
      } catch (\Exception $e) {
        return null;
      }
    }

    public static function danger($options=[]) {
      static::make(__FUNCTION__, $options, static::getScope(2) ?? ($options['method'] ?? 'undefined'));
    }

    public static function warning($options=[]) {
      static::make(__FUNCTION__, $options, static::getScope(2) ?? ($options['method'] ?? 'undefined'));
    }

    public static function info($options=[]) {
      static::make(__FUNCTION__, $options, static::getScope(2) ?? ($options['method'] ?? 'undefined'));
    }

    public static function success($options=[]) {
      static::make(__FUNCTION__, $options, static::getScope(2) ?? ($options['method'] ?? 'undefined'));
    }

    public static function debug($options=[]) {
      static::make(__FUNCTION__, $options, static::getScope(2) ?? ($options['method'] ?? 'undefined'));
    }

}
