<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Versionable;

class app extends Model
{
  use Versionable;

  protected $fillable = [
    "uid", "user_id", "saved_version", "published_version", "queued_version"
  ];

  public function user() {
    return $this->belongsTo('App\User');
  }
}
