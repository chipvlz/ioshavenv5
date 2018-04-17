<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use App\Preview;
use App\Log;
use Auth;

class AppController extends Controller
{
    public function showEditPage($uid) {
      $app = Preview::byuid($uid)->first();
      return view('apps.edit', [
        "uid" => $uid,
        "preview" => $app
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
        'description' => 'required',
      ]);
      dd($r->all());
    }
}
