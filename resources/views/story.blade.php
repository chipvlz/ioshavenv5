@extends('layouts.app')
@section('meta')
<link rel="preload" as="image" href="{{ !!$published->image ? Storage::url($published->image) : url('/img/banner.png') }}" v-pre>
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

<div class="app-banner mb-3 jumbotron-fluid">
  <img id="banner-image" src="{{ $published->image }}" class="w-100" alt="banner" v-pre>
</div>

<div class="container story">
  <div class="row">
    <div class="col-md-8 m-auto">
      <h1 class="pt-4" v-pre>{{$published->title}}</h1>
      <h5 v-pre>{{ $published->mini }}</h5>

      <div class="mt-5" v-pre>{!! $published->content !!}</div>

      <br>
      <hr>
      <div class="sharethis-inline-share-buttons my-4"
           data-url='{{url("/story/$story->uid")}}'
           data-title="{{ $published->title }}"
           data-image="{{ !!$published->image ? Storage::url($published->image) : url('/img/banner.png') }}"
           data-desciption="{{ $published->mini}}"
           v-pre
       ></div>


    </div>
  </div>
</div>

@component('components.actions', [
  "table" => "stories",
  "thing" => $story
])@endcomponent

@endsection
