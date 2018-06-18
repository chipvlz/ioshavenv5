@extends('layouts.app')
@section('content')

<div class="container mt-4">
  <form action="/test" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="thing">
    <input type="submit">
  </form>
  @if(Session::has('message'))
  <h1 class="mt-3 text-{{Session::get('message-type')}}">{{Session::get('message')}}</h1>
  @endif
</div>

@endsection
