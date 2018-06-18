@extends('layouts.dashboard')
@section('content')

<!-- <div class="app-banner mb-3 jumbotron-fluid">
  <img id="story-image"  v-presrc="{{ !!$version->image ? Storage::url($version->image) : '/img/banner.png' }}" class="w-100" alt="banner">
</div> -->

<div class="container mb-4">
  <div class="mb-3">
    <img id="story-image" src="{{ $version->image }}" height="120" alt="banner" v-pre>
  </div>
  <h1 class="py-2 border-bottom d-flex align-items-end justify-content-between" v-pre>{{ $version->title ?? 'New story' }}</h1>
</div>

<form action="/story/edit" method="post">
  @csrf
  <input type="hidden" name="uid" value="{{$story->uid}}" v-pre>
  <input type="hidden" name="vid" value="{{$version->uid}}" v-pre>
  <input type="hidden" name="content" id="app-description-value">
  <input type="hidden" name="image" id="story-image-input" value="{{ old('image') ?? $version->image }}" v-pre>

  <div class="container d-flex flex-wrap">

    <div class="form-group w-100">
      <label for="role">Select Type</label>
      <!-- This is the select label -->
      <select class="form-control" id="type" name="type" required>

        @if (old('type') || $version->type)
          <option selected="selected" value="{{old('type') ?? $version->type}}" v-pre>{{ old('type') ?? $version->type }}</option>
        @else
          <option selected="selected" disabled="disabled" value="">--- Select type ---</option>
        @endif
        @foreach($types as $type)
          @if ($type != $version->type && $type != old('type'))
            <option value="{{$type}}" v-pre>{{$type}}</option>
          @endif
        @endforeach
      </select>
    </div>

    <div class="form-group w-100">
      <label for="title" class="h6">Title</label>
      <input required autocomplete="dashboard-article-{{$story->uid}}" value="{{old('title') ?? $version->title}}" type="text" class="form-control py-3 px-3" id="title" name="title" placeholder="Title..." v-pre>
    </div>

    <div class="form-group w-100">
      <label for="mini" class="h6">Mini Description</label>
      <input required autocomplete="dashboard-article-{{$story->uid}}" value="{{old('mini') ?? $version->mini}}" type="text" class="form-control py-3 px-3" id="mini" name="mini" placeholder="Mini description..." v-pre>
    </div>

    <label for="image" class="h6">Content image</label>
    <file-upload id="image" name="image" @success="storySuccess" class="mb-3" action="/upload/story" :data="[{
      name: 'uid',
      value: '{{ $story->uid }}'
      },{
      name: 'vid',
      value: '{{ $version->uid }}'
      }]">
      <i class="fas fa-image mr-2"></i>Upload image
    </file-upload>

    <div class="form-group w-100">
      <label class="h6">Content</label>
      <editor class="mb-3" v-pre>{!!old('content') ?? $version->content!!}</editor>
    </div>

    @component('components.commit', [
      "uid" => $story->uid,
    ])@endcomponent


  </div>



  <div class="fixed-bottom p-3 bottom-nav">
    <small><span class="text-muted mr-2" v-pre>{{$version->uid}} </span></small>
    <button type="submit" class="btn btn-primary d-flex align-items-center mr-2 btn-sm" name="save" value="1"><i class="fas fa-save mr-2"></i>Save</button>
    @can('approve stories')
    <button type="submit" class="btn btn-success d-flex align-items-center mr-2 btn-sm" name="publish" value="1"><i class="fas fa-check mr-2"></i>Publish</button>
    @else
    <button type="submit" class="btn btn-success d-flex align-items-center mr-2 btn-sm" name="queue" value="1"><i class="fas fa-check mr-2"></i>Submit</button>
    @endcan
  </div>
</form>

@component('components.versionHistory', [
  "versions" => $versions,
  "version" => $version,
  "thing" => $story,
  "name" => "story"
])@endcomponent




@endsection


@section('footer')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endsection
