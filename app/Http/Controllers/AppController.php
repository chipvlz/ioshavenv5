<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use App\Preview;
use App\Log;
use Auth;

class AppController extends Controller
{
    public function get(Request $r) {
      $apps = !$r->q ? App::where("status", "published")
        : App::where("status", "published")->where('name', 'like', "%$r->q%");

      $data = [
        "apps" => $apps->paginate(10),
        "query" => $r->q,
        "search" => "/apps"
      ];
      return !$r->json ? view('apps', $data) : response()->json($data);
    }

    public function showEditPage($uid) {
      $app = Preview::byuid($uid)->first();
      return view('apps.edit', [
        "uid" => $uid,
        "preview" => $app,
        "hasBottomNav" => true
      ]);
    }

    public function create() {
      $uid = str_random(7);
      $app = Preview::create([
        "user_id" => Auth::id(),
        "uid" => $uid
      ]);
      Log::info("App:create", Auth::user()->username . ": Created application $uid");
      return redirect("/app/$app->uid/edit");
    }

    public function edit(Request $r) {
      $r->validate([
        'uid' => 'required',
        'name' => 'required',
        'description' => 'required'
      ]);
      $p = Preview::byuid($r->uid)->first();
      if ($r->delete) {
        $p->delete();
        return redirect('/dashboard');
      }
      $p->status = "saved";
      $p->name = $r->name;
      $p->unsigned = $r->unsigned;
      $p->signed = $r->signed;
      $p->duplicate = $r->duplicate;
      $p->version = $r->version;
      $p->short = $r->short;
      $p->description = $r->description;
      $p->tags = $r->tags;
      if ($r->review) {
        $p->review = 1;
        $p->status = 'pending';
      }
      $p->save();
      return back();
    }
}
