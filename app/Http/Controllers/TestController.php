<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Permission;
use App\Story;
use App\Role;
use Report;
use Gate;
use Auth;


class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:upload apps');
    }

    public function test() {
      $story = Story::find(2);
      Auth::user()->like($story);

      dd(Auth::user()->likeCount("stories"), $story->likeCount());
    }
}
