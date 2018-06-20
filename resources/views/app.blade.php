@extends('layouts.app')
@section('meta')
<link rel="preload" as="image" v-pre href="{{ $published->banner }}">
<link rel="preload" as="image" v-pre href="{{ $published->icon }}">

@component('components.meta', [
  "description" => $published->short,
  "author" => $app->user->username,
  "image" => $published->banner,
  "title" => $published->name,
  "url" => url("/app/$app->uid"),
  "released_at" => $app->released_at,
  "updated_at" => $published->updated_at,
])@endcomponent


@endsection

@section('content')

<div class="mb-3 jumbotron-fluid">
  <img id="banner-image" v-pre src="{{ $published->banner }}" class="w-100" alt="banner">
</div>

<div class="container story">
  <div class="row">
    <div class="col-md-8 m-auto">

      <div class="d-flex align-items-start justify-content-start">
        <img class="mr-3" v-pre src="{{ $published->icon }}" alt="icon" width="100">
        <div>
          <h1 v-pre>{{ $published->name }}</h1>
          @if($published->apk)
          <a href="/download/app/apk/{{$app->uid}}" v-pre target="_blank" class="btn btn-sm btn-light mb-1 border border-dark"><i class="fas fa-file-archive mr-2"></i>Get .apk</a>
          @endif
          @if($published->unsigned)
          <a href="/download/app/unsigned/{{$app->uid}}" v-pre target="_blank" class="btn btn-sm btn-light mb-1 border border-dark"><i class="fas fa-file-archive mr-2"></i>Get .ipa</a>
          @endif
          @if($published->duplicate)
          <a href="/download/app/duplicate/{{$app->uid}}" v-pre target="_blank" class="btn btn-sm btn-success mb-1"><i class="fas fa-copy mr-2"></i>Duplicate</a>
          @endif
          @if($published->signed)
          <a href="/download/app/signed/{{$app->uid}}" v-pre target="_blank" class="btn btn-sm btn-primary mb-1"><i class="fas fa-download mr-2"></i>Install</a>
          @endif
          @if(!$published->apk && !$published->unsigned && !$published->signed && !$published->duplicate)
          <span>No download options available yet.</span>
          @endif
        </div>
      </div>

      <div class="mt-5" v-pre>{!! $published->description !!}</div>
      <br>
      <hr>
      <div class="sharethis-inline-share-buttons my-4"
           data-url='{{url("/app/$app->uid")}}'
           data-title="{{ $published->name }}"
           data-image="{{ !!$published->banner ? Storage::url($published->banner) : url('/img/banner.png') }}"
           data-desciption="{{ $published->short}}"
           v-pre
      ></div>
    </div>
  </div>
</div>

@component('components.actions', [
  "table" => "apps",
  "thing" => $app,
  "info" => [
    ["icon" => "download", "value" => formatNum($app->downloads()->get()->count())],
    ["icon" => "eye", "value" => formatNum($app->views)],
    ["icon" => "file-archive", "value" => formatBytes($published->size)],
    ["icon" => "code-branch", "value" => $published->version],
  ],
])@endcomponent

@endsection
