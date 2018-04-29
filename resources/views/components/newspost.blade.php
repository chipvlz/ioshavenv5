<div class="news-post col-lg-8">
  <div class="header">
    <div class="type-image"></div>
    <div class="type">{{ $story->published()->type }}</div>
    <div class="username">{{ $story->user->username }}</div>
    <i class="fas fa-circle circle"></i>
    <div class="time">{{ $story->published()->released_at->diffForHumans() }}</div>
  </div>

  <div class="image" style="background-image">
    <img src="{{!!$story->published()->image ? Storage::url($story->published()->image) : '/img/banner.png'}}" class="img" alt="news thumbnail">
  </div>

  <div class="footer">
    <div class="title">{{ $story->published()->title }}</div>
    <div class="mini">{{ $story->published()->mini }}</div>
    <div class="readmore">Read More <i class="fal fa-chevron-right"></i></div>
  </div>
</div>
