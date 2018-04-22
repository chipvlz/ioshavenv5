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
      <img src="http://placeimg.com/250/250/people" data-toggle='dropdown' id="profile-dropdown" role="button" class="rounded-circle avatar mr-3" height="24" width="24" alt="profile image" aria-haspopup="true" aria-expanded="false">
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
        <a class="dropdown-item" href="/dashboard">Dashboard</a>
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
        <i class="fas fa-sort-down locale-down"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
        @foreach(config('languages') as $locale => $language)
          <a class="dropdown-item locale" href="#" data-value="{{ $locale }}">{{ $language }}</a>
        @endforeach
      </div>
    </div>

  </div>
</div>
