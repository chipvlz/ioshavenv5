<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
<body>
    <div id="app">
        @include('layouts.navigation-small')
        @include('layouts.navigation-big')

        <main class="pb-5">
            @yield('content')
        </main>
    </div>

    <script src="{{ url('/js/app.js') }}" charset="utf-8"></script>
</body>
</html>
