<?php /*
@component('components.meta', [
  "description" => ,
  "height" => ,
  "author" => ,
  "image" => ,
  "title" => ,
  "width" => ,
  "type" => ,
  "url" => ,
  "released_at" => ,
  "updated_at" => ,
])@endcomponent
*/?>

<meta name="twitter:description"        content="{{ $description }}">
<meta name="twitter:image"              content="{{ $image ?? url('/img/' . env('APP_TYPE') . '-banner.png') }}">
<meta name="twitter:title"              content="{{ strtoupper(env('APP_TYPE')) }} Haven - {{ $title }}">
<meta name="twitter:card"               content="summary_large_image">
<meta name="twitter:site"               content="@ioshavenco">

<meta property="og:description"         content="{{ $description }}">
<meta property="og:image:width"         content="{{ $width ?? '1500' }}">
<meta property="og:image:height"        content="{{ $height ?? '500' }}">
<meta property="og:site_name"           content="{{ strtoupper(env('APP_TYPE')) }} Haven">
<meta property="og:image"               content="{{ $image ?? url('/img/' . env('APP_TYPE') . '-banner.png') }}">
<meta property="og:title"               content="{{ strtoupper(env('APP_TYPE')) }} Haven - {{ $title }}">
<meta property="og:type"                content="article">
<meta property="og:url"                 content="{{ $url ?? url('/') }}">

<meta property="article:published_time" content="{{ isset($released_at) ? $released_at : Carbon\Carbon::now() }}">
<meta property="article:modified_time"  content="{{ isset($updated_at) ? $updated_at : Carbon\Carbon::now() }}">
<meta property="article:section"        content="{{ $type ?? 'other' }}">
<meta property="article:author"         content="{{ $author ?? ''}}">

<meta name="title"                      content="{{ strtoupper(env('APP_TYPE')) }} Haven - {{ $title }}">
<meta name="description"                content="{{ $description }}">
