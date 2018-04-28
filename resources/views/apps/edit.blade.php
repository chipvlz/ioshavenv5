@extends('layouts.dashboard')

@section('content')

@component('components.appbanner', [
  "app" => $preview
])@endcomponent

<div class="container">
  <form action="/app/edit" class="dropzone" method="post" id="app=dropzone">
    @csrf
    <input type="hidden" name="uid" value="{{$preview->uid}}">
    <input type="hidden" name="description" id="app-description-value">

    <div class="form-group">
      <label for="name" class="h6">App name</label>
      <input autocomplete="{{$preview->uid}}" value="{{$preview->name}}" type="text" class="form-control py-3 px-3" id="name" name="name" placeholder="App name...">
    </div>

    <div class="form-group">
      <label for="version" class="h6">App version</label>
      <input autocomplete="{{$preview->uid}}" value="{{$preview->version}}" type="text" class="form-control py-3 px-3" id="version" name="version" placeholder="App version...">
    </div>

    <div class="form-group">
      <label for="short" class="h6">Short description</label>
      <input autocomplete="{{$preview->uid}}" value="{{$preview->short}}" type="text" class="form-control py-3 px-3" id="short" name="short" placeholder="Short description...">
    </div>

    <div class="form-group">
      <label for="apk" class="h6">App file</label>
      <file-upload id="apk" name="apk" @success="apkSuccess" class="mb-3" action="/upload/apk" :data="[{
        name: 'uid',
        value: '{{ $uid }}'
        }]">
        <i class="fas fa-file-archive mr-2"></i>Upload .apk
      </file-upload>
    </div>

    <div class="form-group">
      <label for="icon" class="h6">App icon</label>
      <file-upload id="icon" name="icon" @success="iconSuccess" class="mb-3" action="/upload/icon" :data="[{
        name: 'uid',
        value: '{{ $uid }}'
        }]">
        <i class="fas fa-image mr-2"></i>Upload Icon
      </file-upload>
    </div>

    <div class="form-group">
      <label for="banner" class="h6">App banner</label>
      <file-upload id="banner" name="banner" @success="bannerSuccess" class="mb-3" action="/upload/banner" :data="[{
        name: 'uid',
        value: '{{ $uid }}'
        }]">
        <i class="fas fa-image mr-2"></i>Upload Banner
      </file-upload>
    </div>

    <div class="form-group">
      <label class="h6">App description</label>
      <editor class="mb-3">{!!$preview->description!!}</editor>
    </div>

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
        {{ ($preview->created_at == $preview->updated_at) ? 'Created' : 'Saved'}}
        {{$preview->updated_at->diffForHumans()}}</span></small>
      <button type="submit" class="btn btn-primary d-flex align-items-center mr-2 btn-sm" name="review" value="0"><i class="fas fa-save mr-2"></i>Save</button>
      <button type="submit" class="btn btn-success d-flex align-items-center btn-sm" name="review" value="1"><i class="fas fa-check mr-2"></i>Publish</button>
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
            Are you sure you would like to delete this application: <strong>{{$preview->name}}</strong>? Once this action is performed, it cannot be undone!
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



  <!-- Create the editor container -->





</div>

@endsection
