<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Story;

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

    $data = [
      "stories" => $stories->paginate(10),
      "query" => $r->q,
      "search" => "/"
    ];
    return !$r->json ? view('welcome', $data) : response()->json($data);
  }
}
