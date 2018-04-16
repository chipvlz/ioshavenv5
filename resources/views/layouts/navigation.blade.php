<div class="nav1">
  <div>
    <a href="" class="nav-link"><i class="fab fa-apple"></i></a>
    <a href="" class="nav-link android"><i class="fab fa-android"></i></a>
  </div>
  <div :class="['totop', {'show': hasScrolledOnePage}]">
    <a href="" class="nav-link"><i class="fal fa-angle-double-up"></i></a>
  </div>
  <div class="d-flex align-items-center">
    @if(Auth::guest())
      <a href="/login" class="nav-link">{{ __('Login') }}</a>
      |
      <a href="/register" class="nav-link mr-3">{{ __('Register') }}</a>
    @else
    <form action="/logout" id="logout" method="post">@csrf</form>
    <div class="dropdown">
      <img src="https://placeimg.com/250/250/people" data-toggle='dropdown' id="profile-dropdown" role="button" class="rounded-circle avatar mr-3" height="24" width="24" alt="profile image" aria-haspopup="true" aria-expanded="false">
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
        <a class="dropdown-item" href="#">Dashboard</a>
        <a class="dropdown-item" href="#">My Profile</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger logout" href="#">Logout</a>
      </div>
    </div>

    @endif

    <div class="dropdown">
      <form action="/locale" id="locale" method="post">
        @csrf
        <input type="hidden" name="locale" id="locale-value">
      </form>
      <a href="#" class="nav-link" data-toggle='dropdown' id="lang-dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        {{ config('languages')[Session::get('locale')] }}
        <i class="fas fa-sort-down"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
        @foreach(config('languages') as $locale => $language)
          <a class="dropdown-item locale" href="#" data-value="{{ $locale }}">{{ $language }}</a>
        @endforeach
      </div>
    </div>

  </div>
</div>
<div class="nav2">
  <div class="w-100 px-3 d-flex align-items-center justify-content-between">
    <div class="menu nav-link d-md-none" @click="showmoreclick = !showmoreclick">
      <i class="fal fa-bars"></i>
      {{ __('Menu') }}
      <div class="more" :class="{show: showmoreclick}" >
        @foreach(config('navigation') as $section)
          @foreach($section as $name => $data)
            <a href="{{ $data['url'] }}" class="nav-link {{ $data['color'] }}">
              <i class="mr-3 {{ $data['icon'] }}"></i>
              {{ __($name) }}
            </a>
          @endforeach
        @endforeach

      </div>
    </div>
    <div class="links d-none d-md-inline-block">

      @foreach(config('navigation.main') as $name => $data)
        <a href="{{ $data['url'] }}" class="nav-link px-2  {{ $data['color'] }}">
          <i class="{{ $data['icon'] }}"></i>
          {{ __($name) }}
        </a>
      @endforeach
      <div href="#more" class="nav-link px-2" @click="showmoreclick = !showmoreclick">
        {{ __('More') }}
        <i class="fas fa-caret-down"></i>
        <div class="more" :class="{show: showmoreclick}" >
          @foreach(config('navigation.more') as $name => $data)
            <a href="{{ $data['url'] }}" class="nav-link {{ $data['color'] }}">
              <i class="mr-3 {{ $data['icon'] }}"></i>
              {{ __($name) }}
            </a>
          @endforeach
        </div>
      </div>

    </div>
    <div class="wrapper d-flex align-items-center justify-content-end">
      <div class="socials d-flex align-items-center">
        @foreach(config('socials') as $social)
          <a href="{{ $social['url'] }}">
            <i class="{{ $social['icon'] }}"></i>
          </a>
        @endforeach
      </div>
      <form class="form-inline my-2 my-lg-0" action="/news/search">
        <input class="form-control ml-2 d-none d-sm-block" type="search" placeholder="Search" aria-label="Search">
      </form>
    </div>
  </div>
</div>
