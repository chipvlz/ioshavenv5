@extends('layouts.app')

@section('content')
<div class="container">

<form action="/app/edit" class="dropzone" method="post" id="app=dropzone">
  @csrf
  <input type="hidden" name="description" id="app-description-value" required>

  <file-upload id="apk" name="apk" class="mb-3" action="/upload/apk" :data="[{
    name: 'uid',
    value: '{{ $uid }}'
    }]">
    <i class="fas fa-file-archive mr-2"></i>Upload .apk
  </file-upload>

  <editor class="mb-3"></editor>
  <button type="submit" class="btn btn-primary">Save changes</button>
</form>
  <!-- Create the editor container -->





</div>
@endsection
