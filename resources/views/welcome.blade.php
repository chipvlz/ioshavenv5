@extends('layouts.app')

@section('content')
@if (!!$query)
<div class="banner home query2">
    <div class="p-4 text-center w-100">
      {{ $stories->total() }} Search results for <strong>{{ $query }}</strong>
    </div>
</div>
@else
<div class="banner home">
  <div class="logo-wrapper">
    <span class="logo {{ env('APP_TYPE')}}"></span>
    {{env("APP_TYPE")}} Haven
  </div>
</div>
@endif
<div class="posts container {{ !!$query ? 'query' : '' }}">
  @foreach($stories as $story)
    @component('components.newspost', [
      "story" => $story
    ])@endcomponent
  @endforeach
</div>
@endsection
