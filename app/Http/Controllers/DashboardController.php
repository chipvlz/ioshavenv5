<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use Auth;
use App\Role;
use Storage;
use Gate;
use App\User;

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
      $a = Auth::user()->previews();
      $apps = !$r->q ? $a
        : $a->where('name', 'like', "%$r->q%");

      $apps = $apps->paginate(10);

      if ($r->json) {
        foreach ($apps as $app) {
          $app->icon = isset($app->icon) ? Storage::url($app->icon) : '/img/icon.png';
          $app->banner = isset($app->banner) ? Storage::url($app->banner) : '/img/banner.png';
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

    public function showProfile () {
      return view('dashboard.profile', [
        "user" => Auth::user(),
        "hasBottomNav" => true,
        "isAuth" => true
      ]);
    }

}
