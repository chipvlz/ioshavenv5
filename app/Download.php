<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
  public function app() {
    return $this->belongsTo('App\App');
  }

  public function user() {
    return $this->belongsTo('App\User');
  }
}
