<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{env("APP_TYPE")}} Haven</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">

    </head>
    <body>

      <div id="app">
        @include('layouts.navigation')
        <div class="banner">
          <div class="logo-wrapper">
            <span class="logo {{ env('APP_TYPE')}}"></span>
            {{env("APP_TYPE")}} Haven
          </div>
        </div>
        <div class="posts container">
          @component('components.newspost')@endcomponent
          @component('components.newspost')@endcomponent
          @component('components.newspost')@endcomponent
        </div>
      </div>



      <script src="/js/app.js" charset="utf-8"></script>
      <script src="/fa/svg-with-js/js/fontawesome-all.min.js" charset="utf-8"></script>
    </body>
</html>
