<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use Auth;

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

    public function apps(Request $r) {
      $a = Auth::user()->previews();
      $apps = !$r->q ? $a
        : $a->where('name', 'like', "%$r->q%");

      $data = [
        "apps" => $apps->paginate(10),
        "query" => $r->q,
        "search" => "/apps"
      ];
      return !$r->json ? view('dashboard.apps', $data) : response()->json($data);
    }

}
