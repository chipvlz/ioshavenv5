<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use Auth;
use App\Role;
use Storage;
use Gate;
use App\User;
use App\Story;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('dashboard.index');
    }

    public function showApps(Request $r) {
      if (Gate::denies('upload apps')) abort(404);
      $a = Auth::user()->apps();

      $apps = !$r->q ? $a
        : $a->where('name', 'like', "%$r->q%");

      $apps = $apps->paginate(10);
      
      if ($r->json) {
        foreach ($apps as $app) {
          $app->icon = isset($app->current()->icon) ? Storage::url($app->current()->icon) : '/img/icon.png';
          $app->banner = isset($app->current()->banner) ? Storage::url($app->current()->banner) : '/img/banner.png';
        }
      }

      $data = [
        "apps" => $apps,
        "query" => $r->q,
        "search" => "/dashboard/apps"
      ];
      return !$r->json ? view('dashboard.apps', $data) : response()->json($data);
    }

    public function showRoles () {
      if (Gate::denies('manage roles')) abort(404);
      return view('dashboard.roles', [
        "roles" => Role::get(),
      ]);
    }

    public function showUsers (Request $r) {
      if (Gate::denies('manage users')) abort(404);
      $users = !$r->q ? User::withTrashed()->paginate(10)
        : User::withTrashed()->where('username', 'like', "%$r->q%")->paginate(10);

      if ($r->json) {
        foreach ($users as $user) {
          $user->avatar = !!$user->avatar ? Storage::url($user->avatar) : 'https://api.adorable.io/avatars/200/'.$user->username;
          $user->role = $user->role()->first();
        }
      }

      $data = [
        "users" => $users,
        "query" => $r->q
      ];

      return !$r->json ? view('dashboard.users', $data) : response()->json($data);
    }

    public function showStories (Request $r) {
      if (Gate::denies('create stories')) abort(404);
      $stories = !$r->q ? Story::paginate(10)
        : Story::where('title', 'like', "%$r->q%")->paginate(10);

      if ($r->json) {
        foreach ($stories as $story) {
          $story->image = !!$story->image ? Storage::url($story->image) : '/img/banner.png';
          $story->role = $user->role()->first();
        }
      }

      $data = [
        "stories" => $stories,
        "query" => $r->q
      ];

      return !$r->json ? view('dashboard.stories', $data) : response()->json($data);
    }

    public function showProfile () {
      return view('dashboard.profile', [
        "user" => Auth::user(),
        "hasBottomNav" => true,
        "isAuth" => true
      ]);
    }

}
