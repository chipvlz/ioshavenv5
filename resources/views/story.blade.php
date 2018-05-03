@extends('layouts.app')
@section('open-graph')
<meta property="og:title" content="{{ env('APP_TYPE') }} Haven - {{ $published->title }}">
<meta property="og:description" content="{{ $published->mini }}">
<meta property="og:site_name" content="{{ env('APP_TYPE') }} Haven">
<meta property="og:image" content="{{ !!$published->image ? Storage::url($published->image) : url('/img/banner.png') }}">
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