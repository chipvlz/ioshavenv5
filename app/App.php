<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Versionable;
use App\Traits\Likeable;

class app extends Model
{
  use Versionable;
  use Likeable;

  protected $fillable = [
    "uid", "user_id", "saved_version", "published_version", "queued_version", "type"
  ];

  public function user() {
    return $this->belongsTo('App\User');
  }

  public function downloads() {
    return $this->hasMany('App\Download');
  }
}
