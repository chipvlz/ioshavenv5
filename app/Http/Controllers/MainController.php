<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class MainController extends Controller
{
  public function locale(Request $r)
  {
      // dd($r->all());
      Session::put('locale', $r->locale);
      return back();
  }
}
