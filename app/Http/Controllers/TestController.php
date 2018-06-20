<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Permission;
use App\Story;
use App\Role;
use App\App;
use Report;
use Gate;
use Auth;
use Session;


class TestController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:upload apps');
    }

    public function test() {
      return view('test');
    }

    public function upload(Request $r) {
      // dd(config('filesystems'));
      $path = $r->file('thing')->store('avatars');
      Session::flash('message', $path);
      Session::flash('message-type', 'success');
      return back();
    }
}
