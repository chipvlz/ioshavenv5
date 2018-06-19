@extends('layouts.dashboard')

@section('content')

@if(!!$query)
<div class="banner home query">
    <div class="p-4 text-center w-100" v-pre>
      {{ $apps->total() }} Search results for <strong v-pre>{{ $query }}</strong>
    </div>
    <div class="container mb-4">
      <h1 class="py-2 border-bottom">My apps
        <span class="float-right">
          <form action="/app/create" method="post">
            @csrf
            <button class="btn btn-primary btn-sm">Add new</button>
          </form>
        </span>
      </h1>
    </div>
</div>
@else
<div class="container mb-4">
  <h1 class="py-2 border-bottom">My apps
    <span class="float-right">
      <form action="/app/create" method="post">
        @csrf
        <button class="btn btn-primary"> Add new</button>
      </form>
    </span>
  </h1>
</div>
@endif

<div class="container mb-3">
  <form action="/dashboard/apps" method="get">
    <input type="text" name="q" value="" placeholder="Search..." class="p-3 from-control w-100">
  </form>
</div>

<div class="container">

  <div class="row">
    @foreach($apps as $app)

        <div class="col-lg-4 col-md-6 col-12">
          <a class="app mb-2 py-1 px-2" href="/app/edit/{{ $app->uid }}" v-pre>
            <div class="icon">
              <img src="{{ $app->current()->icon }}" alt="app-icon" width="60" height="60" v-pre>
            </div>
            <!-- <div class="w-100"> -->
              <div class="info pl-2 pr-0 w-100">
                <div class="title" v-pre>{{ $app->current()->name }}</div>
                <div class="short" v-pre>{{ $app->current()->short }}</div>
              </div>
              <div class="action pr-2">
                <button class="btn btn-outline-primary btn-sm">Edit</button>
              </div>
            <!-- </div> -->
          </a>
        </div>

    @endforeach

    <div class="col-lg-4 col-md-6 col-12 dynamic-content d-none" v-for="app in apps">
      <a class="app mb-2 py-1 px-2" :href="'/app/edit/' + app.uid">
        <div class="icon">
          <img :src="app.icon" alt="app-icon" width="60" height="60">
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
   array="apps"
   search="{{ $search }}"
   query="{{ $query }}"
   @update="addApps"
   ></load-more>
</div>

@endsection
