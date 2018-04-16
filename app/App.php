<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class app extends Model
{
    public static function byuid($uid) {
      return static::where('uid', $uid);
    }
}
