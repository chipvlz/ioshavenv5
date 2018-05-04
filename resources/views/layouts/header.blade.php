<link rel="prefetch" href="{{ url('/css/app.css') }}">
<link href="{{ url('/fa/web-fonts-with-css/css/fontawesome-all.min.css') }}" rel="prefetch"></link>

<link href="https://fonts.googleapis.com/css?family=Nunito:400,600" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="{{ url('/fa/web-fonts-with-css/css/fontawesome-all.min.css') }}" rel="stylesheet"></link>
<link rel="stylesheet" href="{{ url('/css/app.css') }}">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png?v=bOLw3p3jEA">
<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png?v=bOLw3p3jEA">
<link rel="icon" type="image/png" sizes="194x194" href="/favicons/favicon-194x194.png?v=bOLw3p3jEA">
<link rel="icon" type="image/png" sizes="192x192" href="/favicons/android-chrome-192x192.png?v=bOLw3p3jEA">
<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png?v=bOLw3p3jEA">
<link rel="manifest" href="/favicons/site.webmanifest?v=bOLw3p3jEA">
<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg?v=bOLw3p3jEA" color="#ff3333">
<link rel="shortcut icon" href="/favicons/favicon.ico?v=bOLw3p3jEA">
<meta name="apple-mobile-web-app-title" content="{{ strtoupper(env('APP_TYPE')) }} Haven">
<meta name="application-name" content="{{ strtoupper(env('APP_TYPE')) }} Haven">
<meta name="msapplication-TileColor" content="#ff3333">
<meta name="msapplication-config" content="/favicons/browserconfig.xml?v=bOLw3p3jEA">
<meta name="theme-color" content="#ff3333">

<script defer type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5aeb628d96e6fc00110b2f1a&product=inline-share-buttons"></script>
<script defer src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script defer src="//embed.redditmedia.com/widgets/platform.js" charset="UTF-8"></script>
<script defer src="{{ url('/js/app.js') }}" charset="utf-8"></script>


<title>{{env("APP_TYPE")}} Haven</title>
