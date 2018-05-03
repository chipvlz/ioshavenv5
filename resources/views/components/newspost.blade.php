<div class="news-post col-lg-8 px-3 mb-2">
  <div class="header">
    <div class="type-image"></div>
    <span class="d-flex flex-wrap align-items-center">
      <div class="type w-100">{{ $story->published()->type }}</div>
      <span class="d-flex align-items-center">
        <div class="username m-0">{{ $story->user->username }}</div>
        <span class="tiny mx-1">•</span>
        <div class="time">{{ $story->published()->released_at->diffForHumans() }}</div>
      </span>
    </span>


  </div>

  <div class="image" style="background-image">
    <img src="{{!!$story->published()->image ? Storage::url($story->published()->image) : '/img/banner.png'}}" class="img" alt="news thumbnail">
  </div>

  <div class="footer">
    <a href="/story/{{$story->uid}}" class="title d-block no-link">{{ $story->published()->title }}</a>
    <a href="/story/{{$story->uid}}" class="mini d-block no-link">{{ $story->published()->mini }}</a>
    <a href="/story/{{$story->uid}}">Read More <small><i class="fal fa-chevron-right"></i></small></a>
  </div>
</div>
