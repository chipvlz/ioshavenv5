
<div class="nav2">
  <div class="w-100 px-3 d-flex align-items-center justify-content-between">
    <div class="menu nav-link d-md-none" @click="showmoreclick = !showmoreclick">
      <i class="fal fa-bars"></i> {{ __('Menu') }}
    </div>
    <div class="links d-none d-md-inline-block">

      @foreach(config('navigation.main') as $name => $data)
        <a href="{{ $data['url'] }}" class="nav-link px-2  {{ $data['color'] }}" v-pre>
          <i class="{{ $data['icon'] }}"></i>
          {{ __($name) }}
        </a>
      @endforeach
      <div href="#more" class="nav-link px-2 dropdown">
        <a id="moreDropdown" href="#" class="no-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          {{ __('More') }} <i class="fas fa-caret-down"></i>
        </a>


        <div class="dropdown-menu" aria-labelledby="moreDropdown">
          @foreach(config('navigation.more') as $name => $data)
            <a href="{{ $data['url'] }}" class="dropdown-item" v-pre>
              <i class="mr-3 {{ $data['icon'] }}" v-pre></i>
              {{ __($name) }}
            </a>
          @endforeach
        </div>
      </div>

    </div>
    <div class="wrapper d-flex align-items-center justify-content-end">
      <div class="socials d-flex align-items-center">
        @foreach(config('socials') as $social)
          <a href="{{ $social['url'] }}" target="_blank" v-pre>
            <i class="{{ $social['icon'] }}" v-pre></i>
          </a>
        @endforeach
      </div>
      <form class="form-inline my-2 my-lg-0" action="{{ $search ?? '' }}" v-pre>
        <input class="form-control ml-2 d-none d-sm-block" type="text" placeholder="Search" aria-label="Search" name="q" value="{{ $query ?? '' }}" v-pre>
      </form>
    </div>
  </div>
</div>

<div class="w-100 bg-white px-3 d-sm-none" v-show="showmoreclick" >
  <form class="form-inline py-2 my-lg-0" action="{{ $search ?? '' }}" v-pre>
    <input class="form-control ml-2 d-sm-block" type="text" placeholder="Search..." aria-label="Search" name="q" value="{{ $query ?? '' }}" v-pre>
  </form>
  @foreach(config('navigation') as $section)
    @foreach($section as $name => $data)
      <a href="{{ $data['url'] }}" class="nav-link d-block {{ $data['color'] }}" v-pre>
        <i class="mr-3 {{ $data['icon'] }}" v-pre></i>
        {{ __($name) }}
      </a>
    @endforeach
  @endforeach
</div>
