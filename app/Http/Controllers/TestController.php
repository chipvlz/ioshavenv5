<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Permission;
use App\Role;
use App\Log;
use App\Story;
use Illuminate\Support\Facades\Gate;

class TestController extends Controller
{
    public function test() {
      return view('test');
    }
}
