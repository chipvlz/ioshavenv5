@extends('layouts.app')

@section('content')

@component('components.appbanner', [
  "app" => $preview
])@endcomponent

<div class="container">
  <form action="/app/edit" class="dropzone" method="post" id="app=dropzone">
    @csrf

    <div class="form-group">
      <label for="name" class="h6">App name</label>
      <input autocomplete="{{$preview->uid}}" type="text" class="form-control py-3 px-3" id="name" name="name" placeholder="App name...">
    </div>

    <div class="form-group">
      <label for="name" class="h6">App version</label>
      <input autocomplete="{{$preview->uid}}" type="text" class="form-control py-3 px-3" id="name" name="name" placeholder="App version...">
    </div>

    <div class="form-group">
      <label for="name" class="h6">Short description</label>
      <input autocomplete="{{$preview->uid}}" type="text" class="form-control py-3 px-3" id="name" name="name" placeholder="Short description...">
    </div>

    <div class="form-group">
      <label for="name" class="h6">App file</label>
      <file-upload id="apk" name="apk" @success="apkSuccess" class="mb-3" action="/upload/apk" :data="[{
        name: 'uid',
        value: '{{ $uid }}'
        }]">
        <i class="fas fa-file-archive mr-2"></i>Upload .apk
      </file-upload>
    </div>

    <div class="form-group">
      <label for="name" class="h6">App icon</label>
      <file-upload id="icon" name="icon" @success="iconSuccess" class="mb-3" action="/upload/icon" :data="[{
        name: 'uid',
        value: '{{ $uid }}'
        }]">
        <i class="fas fa-image mr-2"></i>Upload Icon
      </file-upload>
    </div>

    <div class="form-group">
      <label for="name" class="h6">App banner</label>
      <file-upload id="banner" name="banner" @success="bannerSuccess" class="mb-3" action="/upload/banner" :data="[{
        name: 'uid',
        value: '{{ $uid }}'
        }]">
        <i class="fas fa-image mr-2"></i>Upload Banner
      </file-upload>
    </div>

    <div class="form-group">
      <label for="name" class="h6">App description</label>
      <editor class="mb-3"></editor>
    </div>

    <button type="submit" class="btn btn-primary">Save changes</button>
  </form>
</div>

  <!-- Create the editor container -->





</div>
@endsection
