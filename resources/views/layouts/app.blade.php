<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @if(View::hasSection('meta'))
      @yield('meta')
    @else
      @component('components.meta', [
        "description" => "Get all your iPhone app needs straight from the web. Including IPAs, signed apps, Apple developer betas, and jailbreaks.",
        "height" => "1920",
        "image" => url('/img/banner.png'),
        "title" => "Home",
        "width" => "1080",
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

</body>
</html>
