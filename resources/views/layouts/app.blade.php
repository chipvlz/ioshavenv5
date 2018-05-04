<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.header')
    @yield('open-graph')
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
