<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Story;
use App\Role;
use App\User;
use App\App;
use Storage;
use Report;
use Auth;
use Gate;




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
        return view('dashboard.stats');
    }

    public function showApps(Request $r) {
      $this->authorize('upload apps');
      $a = Auth::user()->apps();

      $apps = !$r->q ? $a
        : $a->where('name', 'like', "%$r->q%");

      $apps = $apps->paginate(10);

      $data = [
        "apps" => $apps,
        "query" => $r->q,
        "search" => "/dashboard/apps"
      ];
      return !$r->json ? view('dashboard.apps', $data) : response()->json($data);
    }

    public function showRoles () {
      $this->authorize('manage roles');
      return view('dashboard.roles', [
        "roles" => Role::get(),
      ]);
    }

    public function showUsers (Request $r) {
      $this->authorize('manage users');
      $u =  User::withTrashed()->where('role_id', '>', 0);
      $users = !$r->q ? $u->paginate(10)
        : $u->where('username', 'like', "%$r->q%")->paginate(10);

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
      $this->authorize('create stories');
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

    public function showLogs(Request $r) {
      $this->authorize('view logs');

      $l = Report::orderBy('created_at', 'desc');

      $logs = !$r->q ? $l->paginate(10)
        : $l->where('message', 'like', "%$r->q%")->paginate(10);


      if ($r->json) {
        foreach ($logs as $log) {
          $log->user = $log->user()->first();
          $log->user->avatar = !!$log->user->avatar ? Storage::url($log->user->avatar) : 'https://api.adorable.io/avatars/200/'.$log->user->username;
          $log->time = $log->created_at->diffForHumans();
        }
      }

      $data = [
        "logs" => $logs,
        "query" => $r->q,
        "search" => "/dashboard/logs"
      ];
      return !$r->json ? view('dashboard.logs', $data) : response()->json($data);
    }

}
