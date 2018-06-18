<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-100" id="download-page" data-uid="{{ $uid }}" data-vid="{{ $vid }}" data-type="{{ $type }}" v-pre>
<head>
    @if(View::hasSection('meta'))
      @yield('meta')
    @else
      @component('components.meta', [
        "description" => "Get all your iPhone app needs straight from the web. Including IPAs, signed apps, Apple developer betas, and jailbreaks.",
        "image" => url('/img/' . env('APP_TYPE') . '-banner.png'),
        "title" => "Home",
        "url" => url('/'),
      ])@endcomponent
    @endif
    @include('layouts.header')
</head>
<body class="h-100 banner" >
    <div id="app" class="h-100">
        <div class="container h-100">
          <div class="row h-100">
            <div class="col-lg-8 col-md-10 m-auto text-center">
              <div class="logo-wrapper mb-5" v-pre>
                <span class="logo {{ env('APP_TYPE')}}" v-pre></span>
                {{env("APP_TYPE")}} Haven
              </div>
              <h1 class="text-white" id="download-status">Loading download information...</h1>
              <h1><kbd id="time-remaining">loading...</kbd></h1>
            </div>
          </div>
        </div>
    </div>

    <script src="{{ url('/js/app.js') }}" charset="utf-8" v-pre></script>
</body>
</html>
