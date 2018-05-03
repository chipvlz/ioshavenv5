<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @yield('open-graph')
    @include('layouts.header')
</head>
<body>
    <div id="app">
        @include('layouts.navigation-small')
        @include('layouts.navigation-big')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="/js/app.js" charset="utf-8"></script>
    <script src="/fa/svg-with-js/js/fontawesome-all.min.js" charset="utf-8"></script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script async src="//embed.redditmedia.com/widgets/platform.js" charset="UTF-8"></script>

</body>
</html>
