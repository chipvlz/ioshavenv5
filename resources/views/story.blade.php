@extends('layouts.app')
@section('open-graph')
<meta name="twitter:description"        content="{{ $published->mini }}">
<meta name="twitter:image"              content="{{ !!$published->image ? Storage::url($published->image) : url('/img/banner.png') }}">
<meta name="twitter:title"              content="{{ strtoupper(env('APP_TYPE')) }} Haven - {{ $published->title }}">
<meta name="twitter:card"               content="summary_large_image">
<meta name="twitter:site"               content="@ioshavenco">

<meta property="og:description"         content="{{ $published->mini }}">
<meta property="og:image:width"         content="1500">
<meta property="og:image:height"        content="500">
<meta property="og:site_name"           content="{{ strtoupper(env('APP_TYPE')) }} Haven">
<meta property="og:image"               content="{{ !!$published->image ? Storage::url($published->image) : url('/img/banner.png') }}">
<meta property="og:title"               content="{{ strtoupper(env('APP_TYPE')) }} Haven - {{ $published->title }}">
<meta property="og:type"                content="article">

<meta property="article:published_time" content="{{ $published->released_at }}">
<meta property="article:modified_time"  content="{{ $published->updated_at }}">
<meta property="article:section"        content="{{ $published->type }}">
<meta property="article:author"         content="$story->user->username">

<meta name="title"                      content="{{ strtoupper(env('APP_TYPE')) }} Haven - {{ $published->title }}">
<meta name="description"                content="{{ $published->mini }}">

@endsection

@extends('layouts.app')
@section('content')

<div class="app-banner mb-3 jumbotron-fluid">
  <img id="banner-image" src="{{ !!$published->image ? Storage::url($published->image) : '/img/banner.png' }}" class="w-100" alt="banner">
</div>

<div class="container story">
  <div class="row">
    <div class="col-md-8 m-auto">
      <h1 class="pt-4">{{$published->title}}</h1>
      <h5>{{ $published->mini }}</h5>
      <div class="sharethis-inline-share-buttons mt-4"
           data-url='{{url("/story/$story->uid")}}'
           data-title="{{ $published->title }}"
           data-image="{{ !!$published->image ? Storage::url($published->image) : url('/img/banner.png') }}"
           data-desciption="{{ $published->mini}}"
      ></div>

      <hr>
      <br>
      <div>{!! $published->content !!}</div>
    </div>
  </div>

</div>


@endsection
