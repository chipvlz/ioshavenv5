
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
      <form class="form-inline my-2 my-lg-0" action="{{ $search ?? '' }}">
        <input class="form-control ml-2 d-none d-sm-block" type="text" placeholder="Search" aria-label="Search" name="q" value="{{ $query ?? '' }}">
      </form>
    </div>
  </div>
</div>
