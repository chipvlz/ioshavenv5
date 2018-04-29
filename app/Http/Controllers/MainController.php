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
    $stories = !$r->q ? Story::whereNotNull('published_version')
      : Story::whereNotNull('published_version')->where('name', 'like', "%$r->q%");

    $data = [
      "stories" => $stories->paginate(10),
      "query" => $r->q,
      "search" => "/"
    ];
    return !$r->json ? view('welcome', $data) : response()->json($data);
  }
}
