@extends('layouts.dashboard')

@section('content')

@if(!!$query)
<div class="banner home query">
    <div class="p-4 text-center w-100">
      {{ $apps->total() }} Search results for <strong>{{ $query }}</strong>
    </div>
    @if($apps->count())
    <div class="container mb-4">
      <h1 class="py-2 border-bottom">Apps</h1>
    </div>
    @endif
</div>
@else
<div class="container mb-4">
  <h1 class="py-2 border-bottom">Apps</h1>
</div>
@endif

<div class="container">

  <div class="row">
    @foreach($apps as $app)

        <div class="col-lg-4 col-md-6 col-12">
          <a class="app mb-2 py-1 px-2" href="/app/{{ $app->uid }}/edit">
            <div class="icon">
              <img src="http://placeimg.com/100/100/tech" alt="app-icon" width="60" height="60">
            </div>
            <!-- <div class="w-100"> -->
              <div class="info pl-2 pr-0 w-100">
                <div class="title">{{ $app->name }}</div>
                <div class="short">{{ $app->short }}</div>
              </div>
              <div class="action pr-2">
                <button class="btn btn-outline-primary btn-sm">Edit</button>
              </div>
            <!-- </div> -->
          </a>
        </div>

    @endforeach

    <div class="col-lg-4 col-md-6 col-12 dynamic-content d-none" v-for="app in apps">
      <a class="app mb-2 py-1 px-2" :href="'app/' + app.uid + '/edit'">
        <div class="icon">
          <img src="http://placeimg.com/100/100/tech" alt="app-icon" width="60" height="60">
        </div>
        <!-- <div class="w-100"> -->
          <div class="info pl-2 pr-0 w-100">
            <div class="title">@{{ app.name }}</div>
            <div class="short">@{{ app.short }}</div>
          </div>
          <div class="action pr-2">
            <button class="btn btn-outline-primary btn-sm">Edit</button>
          </div>
        <!-- </div> -->
      </a>
    </div>

  </div>

  <load-more
   :current="{{ $apps->currentPage() }}"
   :last="{{ $apps->lastPage() }}"
   search="{{ $search }}"
   query="{{ $query }}"
   @update="addApps"
  ></load-more>
</div>

@endsection
