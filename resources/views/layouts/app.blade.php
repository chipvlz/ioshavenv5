<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
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

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="/js/app.js" charset="utf-8"></script>
    <script src="/fa/svg-with-js/js/fontawesome-all.min.js" charset="utf-8"></script>
</body>
</html>
