@extends('layouts.app')
@section('meta')
<link rel="preload" as="image" href="{{ !!$published->image ? Storage::url($published->image) : url('/img/banner.png') }}">
@component('components.meta', [
  "description" => $published->mini,
  "author" => $story->user->username,
  "image" => !!$published->image ? Storage::url($published->image) : url('/img/banner.png'),
  "title" => $published->title,
  "type" => $published->type,
  "url" => url("/story/$story->uid"),
  "released_at" => $story->released_at,
  "updated_at" => $published->updated_at,
])@endcomponent


@endsection

@section('content')

<div class="app-banner mb-3 jumbotron-fluid pt-4">
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

@component('components.actions', [
  "table" => "stories",
  "thing" => $story
])@endcomponent

@endsection
