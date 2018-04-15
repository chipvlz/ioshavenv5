<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Session;

class Language
{
  public function handle($request, Closure $next)
  {
      if (!Session::has('locale')) {
        Session::put('locale', 'en');
      } 
      App::setLocale(Session::get('locale'));
      return $next($request);
  }
}
