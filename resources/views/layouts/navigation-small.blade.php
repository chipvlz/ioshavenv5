<div class="nav1">
  <div>
    <a href="https://alpha.ioshaven.co" class="nav-link"><i class="fab fa-apple"></i></a>
    <a href="https://alpha.apkhaven.co" class="nav-link android"><i class="fab fa-android"></i></a>
  </div>
  <div :class="['totop', {'show': hasScrolledOnePage}]">
    <a href="" class="nav-link"><i class="fal fa-angle-double-up"></i></a>
  </div>
  <div class="d-flex align-items-center">
    @if(Auth::guest())
      <a href="/login" class="nav-link d-none d-md-inline-block" v-pre>{{ __('Login') }}</a>
      <span class="tiny mx-1 d-none d-md-inline-block">•</span>
      <a href="/register" class="nav-link mr-3 d-none d-md-inline-block" v-pre>{{ __('Register') }}</a>
      <a href="/login" class="nav-link mr-2 d-inline-block d-md-none">
        <i class="far fa-sign-in"></i>
      </a>
    @else
    <form action="/logout" id="logout" method="post">@csrf</form>
    <div class="dropdown">
      <img src="{{ Auth::user()->avatar }}" data-toggle='dropdown' id="profile-dropdown" role="button" class="rounded-circle avatar mr-3" height="24" width="24" alt="profile image" aria-haspopup="true" aria-expanded="false" v-pre>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown">
        <a class="dropdown-item" href="/dashboard">
          <i class="fas fa-cogs mr-2"></i>
          Dashboard</a>
        <a class="dropdown-item" href="/dashboard/profile">
          <i class="fas fa-user mr-2"></i>
          My Profile</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger logout" href="#">
          <i class="fal fa-sign-out-alt mr-2"></i>
          Logout</a>
      </div>
    </div>

    @endif

    <div class="dropdown">
      <form action="/locale" id="locale" method="post">
        @csrf
        <input type="hidden" name="locale" id="locale-value">
      </form>
      <a href="#" class="nav-link" data-toggle='dropdown' id="lang-dropdown" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ config('languages')[Session::get('locale')] }}
        <i class="fas fa-sort-down locale-down"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profile-dropdown" v-pre>
        @foreach(config('languages') as $locale => $language)
          <a class="dropdown-item locale" href="#" data-value="{{ $locale }}" v-pre>{{ $language }}</a>
        @endforeach
      </div>
    </div>

  </div>
</div>
