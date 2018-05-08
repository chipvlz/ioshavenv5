<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Versionable;
use App\Traits\Likeable;

class Story extends Model
{
    use Versionable;
    use Likeable;

    protected $table = "stories";

    protected $fillable = [
      "uid", "user_id", "saved_version", "published_version", "queued_version"
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }


}
