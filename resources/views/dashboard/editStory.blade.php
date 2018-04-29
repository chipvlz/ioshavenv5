@extends('layouts.dashboard')
@section('content')

<!-- <div class="app-banner mb-3 jumbotron-fluid">
  <img id="story-image" src="{{ !!$version->image ? Storage::url($version->image) : '/img/banner.png' }}" class="w-100" alt="banner">
</div> -->

<div class="container mb-4">
  <div class="mb-3">
    <img id="story-image" src="{{ !!$version->image ? Storage::url($version->image) : '/img/banner.png' }}" height="120" alt="banner">
  </div>
  <h1 class="py-2 border-bottom d-flex align-items-end justify-content-between">{{ $version->title ?? 'New story' }}</h1>
</div>

<form action="/story/edit" method="post">
  @csrf
  <input type="hidden" name="uid" value="{{$story->uid}}">
  <input type="hidden" name="vid" value="{{$version->uid}}">
  <input type="hidden" name="content" id="app-description-value">

  <div class="container d-flex flex-wrap">

    <div class="form-group w-100">
      <label for="role">Select Type</label>
      <select class="form-control" id="type" name="type" required>
        @if ($version->type)
          <option selected="selected" value="{{$version->type}}">{{ $version->type }}</option>
        @else
          <option selected="selected" disabled="disabled" value="">--- Select type ---</option>
        @endif
        @foreach($types as $type)
          @if ($type != $version->type)
            <option value="{{$type}}">{{$type}}</option>
          @endif
        @endforeach
      </select>
    </div>

    <div class="form-group w-100">
      <label for="title" class="h6">Title</label>
      <input required autocomplete="dashboard-article-{{$story->uid}}" value="{{$version->title}}" type="text" class="form-control py-3 px-3" id="title" name="title" placeholder="Title...">
    </div>

    <div class="form-group w-100">
      <label for="mini" class="h6">Mini Description</label>
      <input required autocomplete="dashboard-article-{{$story->uid}}" value="{{$version->mini}}" type="text" class="form-control py-3 px-3" id="mini" name="mini" placeholder="Mini description...">
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
      <editor class="mb-3">{!!$version->content!!}</editor>
    </div>

    <div class="form-group w-100">
      <label for="commit" class="h6">Commit message</label>
      <input autocomplete="dashboard-article-{{$story->uid}}" value="" type="text" class="form-control py-3 px-3" id="commit" name="commit" placeholder="Commit message...">
    </div>


  </div>



  <div class="fixed-bottom p-3 bottom-nav">
    <small><span class="text-muted mr-2">{{$version->uid}} </span></small>
    <button type="submit" class="btn btn-primary d-flex align-items-center mr-2 btn-sm" name="save" value="1"><i class="fas fa-save mr-2"></i>Save</button>
    @can('approve apps')
    <button type="submit" class="btn btn-success d-flex align-items-center mr-2 btn-sm" name="publish" value="1"><i class="fas fa-check mr-2"></i>Publish</button>
    @else
    <button type="submit" class="btn btn-success d-flex align-items-center mr-2 btn-sm" name="queue" value="1"><i class="fas fa-check mr-2"></i>Submit</button>
    @endcan
  </div>
</form>


<div class="container mt-4">
  <h1 class="py-2 border-bottom mb-2">Version History</h1>
  <div class="list-group list-group-flush">
    @foreach($versions as $v)
    <div class="list-group-item p-2 d-flex align-items-center justify-content-between {{ ($version->uid != $v->uid) ? 'list-group-item-muted' : '' }}">
      <span class="font-weight-bold">
        <span class="mr-2" data-toggle="tooltip" data-placement="bottom" title="{{ $v->user->username }}">
          <img class="rounded-circle" id="avatar-image" src="{{!!$v->user->avatar ? Storage::url($v->user->avatar) : 'https://api.adorable.io/avatars/200/'.$v->user->username }}" width="20" height="20" alt="avatar">
        </span>
        <span>
          @if (!!$story->published() && $v->uid == $story->published()->uid)
          <span data-toggle="tooltip" data-placement="right" title="published">
            <i class="fas fa-check mr-1 text-success"></i>
          </span>
          @elseif (!!$story->queued() && $v->uid == $story->queued()->uid)
          <span data-toggle="tooltip" data-placement="right" title="awaiting approval">
            <i class="fas fa-spinner fa-pulse"></i>
          </span>
          @endif

          @if ($v->uid == $story->current()->uid)
          <span data-toggle="tooltip" data-placement="right" title="saved">
            <i class="fas fa-save mr-1 text-primary"></i>
          </span>
          @endif
          {{ $v->commit ?? "Unnamed commit: $v->uid" }}
        </span>
      </span>
      <a href="/story/edit/{{$story->uid .'/'. $v->uid}}" class="float-right btn btn-link p-0">
        <small>{{ $v->uid }}</small>
      </a>
    </div>
    @endforeach
  </div>
</div>


@endsection
