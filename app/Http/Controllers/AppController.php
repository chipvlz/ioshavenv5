<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Preview;
use App\App;
use Session;
use Storage;
use Report;
use Auth;
use Gate;


class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:upload apps');
    }

    public function showEditPage($uid, $vid=null) {
      $app = App::byuid($uid)->first();
      if(!Auth::user()->isAdmin() && !Auth::user()->apps()->pluck('uid')->contains($uid)) return abort(404);
      if ($app->type !== env('APP_TYPE')) abort(404);
      $version = !!$vid ? $app->version($vid) : $app->current();
      return view('dashboard.editApp', [
        "app" => $app,
        "version" => $version,
        "versions" => $app->versions()->sortByDesc('updated_at'),
        "hasBottomNav" => true
      ]);
    }

    public function create() {
      try {
        $uid = str_random(7);
        $vid = str_random(20);

        App::make([
          "uid" => $uid,
          "saved_version" => $vid,
          "type" => env('APP_TYPE')
        ], [
          "uid" => $vid,
        ]);

        Report::success([
          "message" => "created app",
          "data" => [
            "uid" => $uid,
            "vid" => $vid,
          ]
        ]);

        return redirect("/app/edit/$uid");
      } catch (\Exception $e) {
        Report::danger([
          "message" => "failed to create app",
          "message" => [
            "uid" => $uid,
            "vid" => $vid,
            "error" => Report::e($e),
          ]
        ]);
      }
    }

    public function edit(Request $r) {
        $app = App::byuid($r->uid)->first();
        if(!Auth::user()->isAdmin() && !Auth::user()->apps()->pluck('uid')->contains($r->uid)) return abort(404);
        if ($r->delete) {
          foreach($app->versions() as $v) {
            $app->removeVersion($v->uid);
          }
          $app->delete();
          Report::success([
            "message" => "deleted app",
            "data" => [
              "app" => $app
            ]
          ]);
          return redirect('/dashboard/apps');
        }
        if ($r->unpublish) {
          $app->unpublish();
          Report::success([
            "message" => "unpublished app",
            "data" => [
              "app" => $app,
            ]
          ]);
          return back();
        }
        if (env('APP_TYPE') === 'ios') {
          $rules = [
            'unsigned' => 'required_without_all:apk,signed,duplicate',
            'signed' => 'required_without_all:unsigned,apk,duplicate',
            'duplicate' => 'required_without_all:unsigned,signed,apk',
            'size' => 'required',
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
      try {
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
          "size" => $r->size ?? $app->size,
          "description" => remove_scripts($r->description),
          "tags" => $r->tags,
        ]);
        if ($r->save) {
          $version->setAsCurrent();
          Report::success([
            "message" => "saved app",
            "data" => [
              "app" => $app,
              "version" => $version,
            ]
          ]);
        }
        elseif ($r->publish) {
          $version->setAsCurrent();
          $version->publish();
          Report::success([
            "message" => "published app",
            "data" => [
              "app" => $app,
              "version" => $version,
            ]
          ]);
        }
        elseif ($r->queue) {
          $version->setAsCurrent();
          $version->queue();
          Report::success([
            "message" => "queued app",
            "data" => [
              "app" => $app,
              "version" => $version,
            ]
          ]);
        }
        return redirect("/app/edit/$app->uid");
      } catch (\Exception $e) {
        Report::danger([
          "message" => "failed to update app",
          "data" => [
            "error" => Report::e($e),
          ]
        ]);
      }
    }
}
