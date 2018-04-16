<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use App\Log;
use Auth;

class AppController extends Controller
{
    public function showEditPage($uid) {
      return view('apps.edit', [
        "uid" => $uid
      ]);
    }

    public function create() {
      $app = new App;
      $app->uid = str_random(7);
      $app->user_id = Auth::id();
      $app->description = "No description";
      $app->save();
      Log::info("App:create", Auth::user()->username . ": Created application");
      return redirect("/app/$app->uid/edit");
    }

    public function edit(Request $r) {
      $r->validate([
        'description' => 'required',
      ]);
      dd($r->all());
    }
}
