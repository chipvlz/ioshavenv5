<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class View extends Model
{
    protected $fillable = [
      "table",
      "user_id",
      "table_id"
    ];

    public static function visit($thing) {
      static::create([
        "table" => $thing->getTable(),
        "user_id" => Auth::check() ? Auth::id() : -1,
        "table_id" => $thing->id
      ]);
    }
}
