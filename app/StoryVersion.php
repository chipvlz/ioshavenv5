<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoryVersion extends Model
{
    protected $table = "story_versions";

    protected $fillable = [
      "story_id", "uid", 'type', 'title', 'mini', 'content', 'image', 'tags', 'user_id', 'commit'
    ];

    public function story() {
      return $this->belongsTo('App\Story');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }
}
