<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;
use App\App;
use Session;
use Report;
use Storage;

class MainController extends Controller
{
  public function locale(Request $r) {
      Session::put('locale', $r->locale);
      return back();
  }

  public function news(Request $r) {
    $s = Story::mergeVersions()->whereNotNull("published_version")->orderBy('released_at', 'desc');
    $stories = !$r->q ? $s
      : $s->where('title', 'like', "%$r->q%");

    $stories = $stories->paginate(10);

    if ($r->json) {
      foreach ($stories as $story) {
        $story->published = $story->published();
        $story->user = $story->user()->get();
        $story->released_at = $story->published()->released_at->diffForHumans();
      }
    }

    $data = [
      "stories" => $stories,
      "query" => $r->q,
      "search" => "/"
    ];
    return !$r->json ? view('welcome', $data) : response()->json($data);
  }

  public function showStory ($uid) {
    $story = Story::byuid($uid)->whereNotNull('published_version')->firstOrFail();
    return view('story', [
      "story" => $story,
      "published" => $story->published(),
    ]);
  }

  public function showApp ($uid) {
    $app = App::byuid($uid)->whereNotNull('published_version')->firstOrFail();
    return view('app', [
      "app" => $app,
      "published" => $app->published(),
    ]);
  }

  public function apps(Request $r) {
    $a = App::mergeVersions()->whereNotNull("published_version");
    $apps = !$r->q ? $a
      : $a->where('name', 'like', "%$r->q%")
          ->orWhere('tags', 'like', "%$r->q%");

    $apps = $apps->paginate(10);

    if ($r->json) {
      foreach ($apps as $app) {
<<<<<<< Updated upstream
        $app->icon = isset($app->current()->icon) ? $app->current()->icon : '/img/icon.png';
=======
        $app->icon = isset($app->current()->icon) $app->current()->icon : '/img/icon.png';
>>>>>>> Stashed changes
      }
    }

    $data = [
      "apps" => $apps,
      "query" => $r->q,
      "search" => "/apps"
    ];

    return !$r->json ? view('apps', $data) : response()->json($data);
  }

  public function like(Request $r) {
    switch ($r->table) {
      case 'stories':
        $thing = Story::byuid($r->uid)->first();
        break;
      case 'apps':
        $thing = App::byuid($r->uid)->first();
        break;
    }

    if ($thing->isLiked()) $thing->unlike();
    else $thing->like();

    $data = [
      "likes" => $thing->likeCount(),
      "isLiked" => $thing->isLiked(),
    ];

    return response()->json($data);
  }

  public function downloadApp ($type, $uid, $vid=null) {
    if (!in_array($type, ['apk', 'signed', 'unsigned', 'duplicate'])) return abort(404);

    $app = App::byuid($uid)->firstOrFail();
    $version = !!$vid ? $app->version($vid) : $app->published();

    return view('download', [
      "uid" => $app->uid,
      "vid" => $version->uid,
      "type" => $type,
    ]);
  }
}
