<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;
use App\StoryVersion;
use Gate;
use Auth;
use Carbon\Carbon;

class StoryController extends Controller
{
    public function showEditPage($uid, $vid=null) {
      if (Gate::denies('create stories')) abort(404);
      $story = Story::byuid($uid)->firstOrFail();
      $version = !!$vid ? $story->version($vid) : $story->current();
      // dd($story->versions()->sortByDesc('updated_at'));
      return view('dashboard.editStory', [
        "story" => $story,
        "version" => $version,
        "versions" => $story->versions()->sortByDesc('updated_at'),
        "types" => config('story-types'),
        "hasBottomNav" => true
      ]);
    }

    public function view ($uid) {
      $story = Story::byuid($uid)->whereNotNull('published_version')->firstOrFail();

      return view('story', [
        "story" => $story,
        "published" => $story->published(),
      ]);
    }

    public function create () {
      $uid = str_random(7);
      $vid = str_random(20);

      Story::make([
        "uid" => $uid,
        "saved_version" => $vid
      ], [
        "uid" => $vid,
      ]);

      return redirect("/story/edit/$uid");
    }

    public function edit(Request $r) {
      $r->validate([
        "content" => "required|min:100",
        "title" => "required|min:10",
        "mini" => "required|min:10",
        "type" => "required",
        "image" => "required",
      ]);

      $story = Story::byuid($r->uid)->first();

      $version = $story->summary($r->commit)->commit([
        'type' => $r->type,
        'title' => $r->title,
        'mini' => $r->mini,
        'content' => remove_scripts($r->content),
        'image' => $r->image,
        'tags' => $r->tags,
      ]);

      if ($r->save) {
        $version->setAsCurrent();
      }
      elseif ($r->publish) {
        $version->setAsCurrent();
        $version->publish();
      }
      elseif ($r->queue) {
        $version->setAsCurrent();
        $version->queue();
      }
      return redirect("/story/edit/$story->uid");
    }
}
