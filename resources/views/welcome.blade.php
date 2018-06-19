@extends('layouts.app')

@section('content')
@if (!!$query)
<div class="banner home query2" v-pre>
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

  <div class="news-post col-lg-8 px-3 mb-2 linkable" v-for="story in stories" :url="'/story/' + story.uid">
    <div class="header">
      <div class="type-image"></div>
      <span class="d-flex flex-wrap align-items-center">
        <div class="type w-100">@{{ story.published.type }}</div>
        <span class="d-flex align-items-center">
          <div class="username m-0">@{{ story.user.username }}</div>
          <span class="tiny mx-1">•</span>
          <div class="time">@{{ story.released_at }}</div>
        </span>
      </span>


    </div>

    <div class="image" style="background-image">
      <img :src="story.published.image" class="img" alt="news thumbnail">
    </div>

    <div class="footer">
      <div class="title d-block no-link">@{{ story.published.title }}</div>
      <div class="mini d-block no-link">@{{ story.published.mini }}</div>
      <a :href="'/story/' + story.uid">Read More <small><i class="fal fa-chevron-right"></i></small></a>
    </div>
  </div>

</div>

<load-more
 :current="{{ $stories->currentPage() }}"
 :last="{{ $stories->lastPage() }}"
 search="/"
 array="stories"
 query="{{ $query }}"
 @update="addStories"
>Load more stories</load-more>
@endsection
