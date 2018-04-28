<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\StoryVersion;

class Story extends Model
{
    protected $table = "stories";

    protected $fillable = [
      "uid", "user_id", "saved_version", "published_version"
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function published() {
      return StoryVersion::where('uid', $this->published_version)->first();
    }

    public function current() {
      return StoryVersion::where('uid', $this->saved_version)->first();
    }

    public function version($vid) {
      return StoryVersion::where('uid', $vid)->first();
    }

    public function versions() {
      return $this->hasMany('App\StoryVersion');
    }

    public static function byuid($uid) {
      return static::where('uid', $uid);
    }
}
