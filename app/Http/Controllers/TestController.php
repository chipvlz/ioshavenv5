<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Permission;
use App\Role;
use App\Log;
use Illuminate\Support\Facades\Gate;

class TestController extends Controller
{
    public function test() {
      // dump(Auth::user()->role->name);
      // foreach(Permission::with('roles')->get() as $perm) {
      //   dump($perm->roles->contains('name', Auth::user()->role->name));
      // }
      $r = Role::find(1);
      dd($r->isAllowedTo('upload apps') ? 'checked' : '');

      return view('test');
    }
}
