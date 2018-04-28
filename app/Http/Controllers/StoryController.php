<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;
use App\StoryVersion;
use Gate;
use Auth;

class StoryController extends Controller
{
    public function showEditPage($uid, $vid=null) {
      if (Gate::denies('create stories')) abort(404);
      $story = Story::byuid($uid)->first();
      $version = !!$vid ? $story->version($vid) : $story->current();
      return view('dashboard.editStory', [
        "story" => $story,
        "version" => $version,
        "versions" => $story->versions()->orderBy('updated_at', 'desc')->get(),
        "types" => config('story-types'),
        "hasBottomNav" => true
      ]);
    }

    public function create () {
      $uid = str_random(7);
      $vid = str_random(20);

      $story = Story::create([
        "uid" => $uid,
        "user_id" => Auth::id(),
        "saved_version" => $vid,
      ]);

      $version = StoryVersion::create([
        'uid' => $vid,
        'story_id' => $story->id,
        'user_id' => Auth::id(),
        'commit' => 'Initial commit'
      ]);
      return redirect("/story/edit/$uid");
    }

    public function edit(Request $r) {
      $r->validate([
        "content" => "required|min:100",
        "title" => "required|min:10",
        "mini" => "required|min:10",
        "type" => "required",
      ]);
      $story = Story::byuid($r->uid)->first();
      if ($r->save) {
        $vid = str_random(20);
        $version = StoryVersion::firstOrCreate([
          'uid' => $r->vid,
          'user_id' => Auth::id(),
          'story_id' => $story->id,
          'type' => $r->type,
          'title' => $r->title,
          'mini' => $r->mini,
          'content' => $r->content,
          'image' => $story->version($r->vid)->image,
          'tags' => $r->tags,
        ]);
        if ($version->wasRecentlyCreated) {
          $version->uid = $vid;
          $version->commit = $r->commit;
          $version->save();
          $story->saved_version = $vid;
          $story->save();
        } else if ($version->uid != $story->current()->uid) {
          $story->saved_version = $r->vid;
          $story->save();
        }
      }
      if ($r->publish) {
        $story->published_version = $r->vid;
        $story->save();
      }
      return redirect("/story/edit/$story->uid");
    }
}
