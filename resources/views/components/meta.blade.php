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

<meta v-pre name="twitter:description"        content="{{ $description }}">
<meta v-pre name="twitter:image"              content="{{ $image ?? url('/img/' . env('APP_TYPE') . '-banner.png') }}">
<meta v-pre name="twitter:title"              content="{{ strtoupper(env('APP_TYPE')) }} Haven - {{ $title }}">
<meta v-pre name="twitter:card"               content="summary_large_image">
<meta v-pre name="twitter:site"               content="@ioshavenco">

<meta v-pre property="og:description"         content="{{ $description }}">
<meta v-pre property="og:image:width"         content="{{ $width ?? '1500' }}">
<meta v-pre property="og:image:height"        content="{{ $height ?? '500' }}">
<meta v-pre property="og:site_name"           content="{{ strtoupper(env('APP_TYPE')) }} Haven">
<meta v-pre property="og:image"               content="{{ $image ?? url('/img/' . env('APP_TYPE') . '-banner.png') }}">
<meta v-pre property="og:title"               content="{{ strtoupper(env('APP_TYPE')) }} Haven - {{ $title }}">
<meta v-pre property="og:type"                content="article">
<meta v-pre property="og:url"                 content="{{ $url ?? url('/') }}">

<meta v-pre property="article:published_time" content="{{ isset($released_at) ? $released_at : Carbon\Carbon::now() }}">
<meta v-pre property="article:modified_time"  content="{{ isset($updated_at) ? $updated_at : Carbon\Carbon::now() }}">
<meta v-pre property="article:section"        content="{{ $type ?? 'other' }}">
<meta v-pre property="article:author"         content="{{ $author ?? ''}}">

<meta v-pre name="title"                      content="{{ strtoupper(env('APP_TYPE')) }} Haven - {{ $title }}">
<meta v-pre name="description"                content="{{ $description }}">
