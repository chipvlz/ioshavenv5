<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preview extends Model
{
    protected $table = "previews";

    protected $hidden = ["id", "user_id"];

    protected $fillable = [
      "user_id",
      "uid"
    ];

    public static function byuid($uid) {
      return static::where('uid', $uid);
    }
}
