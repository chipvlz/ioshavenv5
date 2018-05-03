<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use App\Preview;
use App\Log;
use Auth;
use Gate;
use Session;
use Storage;

class AppController extends Controller
{
    public function get(Request $r) {
      $a = App::mergeVersions()->whereNotNull("published_version");
      $apps = !$r->q ? $a
        : $a->where('name', 'like', "%$r->q%");

      $apps = $apps->paginate(10);

      if ($r->json) {
        foreach ($apps as $app) {
          $app->icon = isset($app->current()->icon) ? Storage::url($app->current()->icon) : '/img/icon.png';
        }
      }

      $data = [
        "apps" => $apps,
        "query" => $r->q,
        "search" => "/apps"
      ];

      return !$r->json ? view('apps', $data) : response()->json($data);
    }

    public function showEditPage($uid, $vid=null) {
      if (Gate::denies('upload apps')) abort(404);
      $app = App::byuid($uid)->first();
      $version = !!$vid ? $app->version($vid) : $app->current();
      return view('dashboard.editApp', [
        "app" => $app,
        "version" => $version,
        "versions" => $app->versions()->sortByDesc('updated_at'),
        "hasBottomNav" => true
      ]);
    }

    public function create() {
      $uid = str_random(7);
      $vid = str_random(20);

      App::make([
        "uid" => $uid,
        "saved_version" => $vid
      ], [
        "uid" => $vid,
      ]);

      Log::info("App:create", Auth::user()->username . ": Created application $uid");
      return redirect("/app/edit/$uid");
    }

    public function edit(Request $r) {
      // if(!$r->apk && !$r->unsigned && !$r->signed && !$r->duplicate) {
      //   Session::flash('danger', 'Please add an application.');
      //   return back();
      // }
      if (env('APP_TYPE') === 'ios') {
        $rules = [
          'unsigned' => 'required_without_all:apk,signed,duplicate',
          'signed' => 'required_without_all:unsigned,apk,duplicate',
          'duplicate' => 'required_without_all:unsigned,signed,apk',
        ];
      } else {
        $rules = [
          'apk' => 'required',
        ];
      }
      $r->validate([
        'uid' => 'required',
        'name' => 'required',
        'description' => 'required|min:20',
        'version' => 'required',
        'short' => 'required|min:10',
        'icon' => 'required',
        'banner' => 'required',
      ] + $rules);

      $app = App::byuid($r->uid)->first();
      $version = $app->summary($r->commit)->commit([
        "name" => $r->name,
        "unsigned" => $r->unsigned,
        "signed" => $r->signed,
        "duplicate" => $r->duplicate,
        "version" => $r->version,
        "banner" => $r->banner,
        "icon" => $r->icon,
        "apk" => $r->apk,
        "short" => $r->short,
        "description" => remove_scripts($r->description),
        "tags" => $r->tags,
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
      return redirect("/app/edit/$app->uid");
    }
}
