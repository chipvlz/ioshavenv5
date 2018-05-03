<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VersionableChild;

class StoryVersion extends Model
{
    use VersionableChild;

    protected $table = "story_versions";

    protected $dates = [
      "released_at",
    ];

    protected $fillable = [
      "story_id", "uid", 'type', 'title', 'mini', 'content', 'image', 'tags', 'user_id', 'commit'
    ];

    public function story() {
      return $this->belongsTo('App\Story');
    }


}
