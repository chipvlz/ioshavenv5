<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use App\Preview;
use Image;
use Storage;
use Carbon\Carbon;
use Session;
use App\Download;

class DownloadController extends Controller
{
    // public function previewApk ($uid) {
    //   $app = Preview::byuid($uid)->first();
    //   return response()->download(storage_path($app->apk));
    // }
    //
    // public function previewImage ($folder, $file) {
    //   return Image::make(storage_path("app/$folder/$file"))->response();
    // }

    public function app (Request $r) {
      if (!in_array($r->type, ['apk', 'signed', 'unsigned', 'duplicate'])) return abort(404);
      $s = "$r->type:$r->uid:$r->vid";
      if ($r->force) {
        Session::put($s, Carbon::now()->addSeconds(5));
      }

      $time = Session::get($s);
      $app_raw = App::byuid($r->uid)->firstOrFail();
      $app = $app_raw->version($r->vid);
      $data = [
        "uid" => $r->uid,
        "vid" => $r->vid,
        "type" => $r->type,
        "time" => $time,
        "now" => Carbon::now(),
        "ready" => Carbon::now()->gt($time),
      ];

      if ($data['ready']) {
        Download::make($app_raw);
        if (Session::has($s)) {
          Session::forget($s);
        }
        if ($r->type === 'unsigned' || $r->type === 'apk') {
          $random = str_random(30);
          Session::put($s, $random);
          return response()->json([
            "download" => "/download/raw/$s/$random"
          ]);
        } else {
          $isSigned = $r->type === 'signed' ? true : false;
          return response()->json([
            "link" => $app->{$r->type},
            "isSigned" => $isSigned,
          ]);
        }

      }

      return response()->json($data);
    }

    public function downloadRaw($session, $random) {
      if (Session::has($session)) {
        if(Session::get($session) !== $random) abort(404);
      } else {
        abort(404);
      }
      list($type, $uid, $vid) = explode(":", $session);
      $app = App::byuid($uid)->firstOrFail()->version($vid);
      if ($type === "unsigned") {
        $ext = ".ipa";
      } else if ($type === 'apk') {
        $ext = '.apk';
      } else {
        abort(404);
      }
      Session::forget($session);
      return Storage::download($app->$type, $app->name . $ext);
      // dd($type, $uid, $vid);
    }
}
