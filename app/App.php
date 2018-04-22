<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class app extends Model
{
    protected $hidden = ["id", "user_id"];
    public static function byuid($uid) {
      return static::where('uid', $uid);
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
