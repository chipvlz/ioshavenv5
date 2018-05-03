@extends('layouts.dashboard')

@section('content')

@component('components.appbanner', [
  "app" => $version
])@endcomponent

<div class="container">
  <form action="/app/edit" class="dropzone" method="post" id="app=dropzone">
    @csrf
    <input type="hidden" name="uid" value="{{$app->uid}}">
    <input type="hidden" name="description" id="app-description-value">
    <input type="hidden" name="icon" id="icon-image-input" value="{{ old('icon') ?? $version->icon }}">
    <input type="hidden" name="banner" id="banner-image-input" value="{{ old('banner') ?? $version->banner }}">
    <input type="hidden" name="apk" id="apk-input" value="{{ old('apk') ?? $version->apk }}">



    <div class="form-group">
      <label for="name" class="h6">Name</label>
      <input autocomplete="dashboard-app-{{$app->uid}}" value="{{old('name') ?? $version->name}}" type="text" class="form-control py-3 px-3" id="name" name="name" placeholder="App name...">
    </div>

    <div class="form-group">
      <label for="version" class="h6">Version</label>
      <input autocomplete="dashboard-app-{{$app->uid}}" value="{{old('version') ?? $version->version}}" type="text" class="form-control py-3 px-3" id="version" name="version" placeholder="App version...">
    </div>

    <div class="form-group">
      <label for="short" class="h6">Short description</label>
      <input autocomplete="dashboard-app-{{$app->uid}}" value="{{old('short') ?? $version->short}}" type="text" class="form-control py-3 px-3" id="short" name="short" placeholder="Short description...">
    </div>

    @if(env("APP_TYPE") === 'ios')
    <div class="form-group">
      <label for="short" class="h6">Signed link</label>
      <input autocomplete="dashboard-app-{{$app->uid}}" value="{{old('signed') ?? $version->signed}}" type="text" class="form-control py-3 px-3" id="signed" name="signed" placeholder="signed link...">
    </div>
    <div class="form-group">
      <label for="short" class="h6">Unsigned link</label>
      <input autocomplete="dashboard-app-{{$app->uid}}" value="{{old('unsigned') ?? $version->unsigned}}" type="text" class="form-control py-3 px-3" id="unsigned" name="unsigned" placeholder="Unsigned link...">
    </div>
    <div class="form-group">
      <label for="short" class="h6">Install as duplicate link</label>
      <input autocomplete="dashboard-app-{{$app->uid}}" value="{{old('duplicate') ?? $version->duplicate}}" type="text" class="form-control py-3 px-3" id="duplicate" name="duplicate" placeholder="Install as duplicate link...">
    </div>
    @endif

    @if(env("APP_TYPE") === 'apk')
    <div class="form-group">
      <label for="apk" class="h6">APK file</label>
      <file-upload id="apk" name="apk" @success="apkSuccess" class="mb-3" action="/upload/apk" :data="[{
        name: 'uid',
        value: '{{ $app->uid }}'
        },{
        name: 'vid',
        value: '{{ $version->uid }}'
        }]">
        <i class="fas fa-file-archive mr-2"></i>Upload .apk
      </file-upload>
    </div>
    @endif

    <div class="form-group">
      <label for="icon" class="h6">Icon</label>
      <file-upload id="icon" name="icon" @success="iconSuccess" class="mb-3" action="/upload/icon" :data="[{
        name: 'uid',
        value: '{{ $app->uid }}'
        },{
        name: 'vid',
        value: '{{ $version->uid }}'
        }]">
        <i class="fas fa-image mr-2"></i>Upload Icon
      </file-upload>
    </div>

    <div class="form-group">
      <label for="banner" class="h6">Banner</label>
      <file-upload id="banner" name="banner" @success="bannerSuccess" class="mb-3" action="/upload/banner" :data="[{
        name: 'uid',
        value: '{{ $app->uid }}'
        },{
        name: 'vid',
        value: '{{ $version->uid }}'
        }]">
        <i class="fas fa-image mr-2"></i>Upload Banner
      </file-upload>
    </div>

    <div class="form-group">
      <label class="h6">Description</label>
      <editor class="mb-3">{!!old('description') ?? $version->description!!}</editor>
    </div>

    @component('components.commit', [
      "uid" => $app->uid,
    ])@endcomponent



    <div class="card text-white bg-danger mb-3 w-100">
      <div class="card-header"><i class="fas fa-exclamation-triangle mr-2"></i>DANGER<i class="fas fa-exclamation-triangle ml-2"></i></div>
      <div class="card-body bg-light text-danger">
        <h5 class="card-title">Would you like to delete this application?</h5>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
          <i class="fal fa-trash-alt mr-2"></i>Delete
        </button>
      </div>
    </div>



    <div class="fixed-bottom p-3 bottom-nav">
      <small><span class="text-muted mr-2">
        Committed {{$version->updated_at->diffForHumans()}}</span></small>
        <button type="submit" class="btn btn-primary d-flex align-items-center mr-2 btn-sm" name="save" value="1"><i class="fas fa-save mr-2"></i>Save</button>
        @can('approve apps')
        <button type="submit" class="btn btn-success d-flex align-items-center mr-2 btn-sm" name="publish" value="1"><i class="fas fa-check mr-2"></i>Publish</button>
        @else
        <button type="submit" class="btn btn-success d-flex align-items-center mr-2 btn-sm" name="queue" value="1"><i class="fas fa-check mr-2"></i>Submit</button>
        @endcan
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Delete App?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you would like to delete this application: <strong>{{$version->name}}</strong>? Once this action is performed, it cannot be undone!
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" name="delete" value="1">Delete</button>
          </div>
        </div>
      </div>
    </div>

  </form>

</div>

@component('components.versionHistory', [
  "versions" => $versions,
  "version" => $version,
  "thing" => $app,
  "name" => "app"
])@endcomponent


  <!-- Create the editor container -->





</div>

@endsection