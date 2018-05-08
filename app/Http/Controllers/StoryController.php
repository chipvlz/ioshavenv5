<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoryVersion;
use Carbon\Carbon;
use App\Story;
use Report;
use Gate;
use Auth;

class StoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:create stories');
    }

    public function showEditPage($uid, $vid=null) {
      $story = Story::byuid($uid)->firstOrFail();
      $version = !!$vid ? $story->version($vid) : $story->current();

      return view('dashboard.editStory', [
        "story" => $story,
        "version" => $version,
        "versions" => $story->versions()->sortByDesc('updated_at'),
        "types" => config('story-types'),
        "hasBottomNav" => true
      ]);
    }



    public function create () {
      try {
        $uid = str_random(7);
        $vid = str_random(20);

        Story::make([
          "uid" => $uid,
          "saved_version" => $vid
        ], [
          "uid" => $vid,
        ]);

        Report::success([
          "message" => "created story",
          "data" => [
            "uid" => $uid,
            "vid" => $vid,
          ]
        ]);

        return redirect("/story/edit/$uid");

      } catch (\Exception $e) {

        Report::danger([
          "message" => "failed to create story",
          "data" => [
            "error" => Report::e($e)
          ]
        ]);

      }
    }

    public function edit(Request $r) {
      $r->validate([
        "content" => "required|min:100",
        "title" => "required|min:10",
        "mini" => "required|min:10",
        "type" => "required",
        "image" => "required",
      ]);

      try {
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
          Report::success([
            "message" => "saved story",
            "data" => [
              "story" => $story,
            ]
          ]);
        }
        elseif ($r->publish) {
          $version->setAsCurrent();
          $version->publish();
          $version->setAsCurrent();
          Report::success([
            "message" => "published story",
            "data" => [
              "story" => $story,
            ]
          ]);
        }
        elseif ($r->queue) {
          $version->setAsCurrent();
          $version->queue();
          $version->setAsCurrent();
          Report::success([
            "message" => "queued story",
            "data" => [
              "story" => $story,
            ]
          ]);
        }
        return redirect("/story/edit/$story->uid");

      } catch (\Exception $e) {
        Report::danger([
          "message" => "failed to edit story",
          "data" => [
            "error" => Report::e($e)
          ]
        ]);
      }


    }
}
