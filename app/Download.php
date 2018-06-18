<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\App;
use Auth;

class Download extends Model
{
  public function app() {
    return $this->belongsTo('App\App');
  }

  public function user() {
    return $this->belongsTo('App\User');
  }

  public static function make(App $app) {
    $d = new static;
    if (Auth::check()) {
      $d->user_id = Auth::id();
    }
    else {
      $d->user_id = -1;
    }
    $d->app_id = $app->id;
    $d->save();
  }
}
