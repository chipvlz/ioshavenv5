<div class="news-post col-lg-8 px-3 mb-2 linkable" url="/story/{{$story->uid}}">
  <div class="header">
    <div class="type-image"></div>
    <span class="d-flex flex-wrap align-items-center">
      <div v-pre class="type w-100">{{ $story->published()->type }}</div>
      <span class="d-flex align-items-center">
        <div v-pre class="username m-0">{{ $story->user->username }}</div>
        <span class="tiny mx-1">•</span>
        <div v-pre class="time">{{ $story->published()->released_at->diffForHumans() }}</div>
      </span>
    </span>


  </div>

  <div class="image" style="background-image">
    <img v-pre src="{{ $story->published()->image }}" class="img" alt="news thumbnail">
  </div>

  <div class="footer">
    <div v-pre class="title d-block no-link">{{ $story->published()->title }}</div>
    <div v-pre class="mini d-block no-link">{{ $story->published()->mini }}</div>
    <a v-pre href="/story/{{$story->uid}}">Read More <small><i class="fal fa-chevron-right"></i></small></a>
  </div>
</div>
