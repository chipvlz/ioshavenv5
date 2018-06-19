@extends('layouts.app')
@section('content')


@if($query === "game")
  <div class="container mb-4 pt-4">
    <h1 class="py-2 border-bottom">Games</h1>
  </div>
@elseif(!!$query)
  <div class="banner home query" v-pre>
      <div class="p-4 text-center w-100" v-pre>
        {{ $apps->total() }} Search results for <strong v-pre>{{ $query }}</strong>
      </div>
      @if($apps->count())
      <div class="container mb-4 pt-4">
        <h1 class="py-2 border-bottom">Apps</h1>
      </div>
      @endif
  </div>
@else
  <div class="container mb-4 pt-4">
    <h1 class="py-2 border-bottom">Apps</h1>
  </div>
@endif

<div class="container">

  <div class="row">
    @foreach($apps as $app)

        <div class="col-lg-4 col-md-6 col-12">
          <div class="app mb-2 py-1 px-2 linkable" v-pre url="/app/{{ $app->uid }}">
            <div class="icon">
              <img v-pre src="{{ $app->current()->icon }}" alt="app-icon" width="60" height="60">
            </div>
            <!-- <div class="w-100"> -->
              <div class="info pl-2 pr-0 w-100">
                <div class="title" v-pre>{{ $app->name }}</div>
                <div class="short" v-pre>{{ $app->short }}</div>
              </div>
              <div class="action pr-2">
                @if($app->current()->signed)
                  <a href="/download/app/signed/{{$app->uid}}" v-pre target="_blank" class="btn btn-outline-primary btn-sm">Get</a>
                @elseif($app->current()->apk)
                  <a href="/download/app/apk/{{$app->uid}}" v-pre target="_blank" class="btn btn-outline-primary btn-sm">Get</a>
                @else
                  <button class="btn btn-outline-primary btn-sm">View</button>
                @endif
              </div>
            <!-- </div> -->
          </div>
        </div>

    @endforeach


    <div class="col-lg-4 col-md-6 col-12 dynamic-content d-none" v-for="app in apps">
      <div class="app mb-2 py-1 px-2 linkable" :url="'/app/' + app.uid">
        <div class="icon">
          <img :src="app.icon" alt="app-icon" width="60" height="60">
        </div>
          <div class="info pl-2 pr-0 w-100">
            <div class="title">@{{ app.name }}</div>
            <div class="short">@{{ app.short }}</div>
          </div>
          <div class="action pr-2">
              <a :href="'/download/app/signed/' + app.uid" v-if="app.signed" target="_blank" class="btn btn-outline-primary btn-sm">Get</a>
              <a :href="'/download/app/apk/' + app.uid" v-else-if="app.apk" target="_blank" class="btn btn-outline-primary btn-sm">Get</a>
              <button v-else="" class="btn btn-outline-primary btn-sm">View</button>
          </div>
      </div>
    </div>

  </div>

  <load-more
   :current="{{ $apps->currentPage() }}"
   :last="{{ $apps->lastPage() }}"
   array="apps"
   search="{{ $search }}"
   query="{{ $query }}"
   @update="addApps"
  ></load-more>

</div>


@endsection
