@extends('layouts.dashboard')
@section('content')

@if(!!$query)
<div class="banner home query">
    <div class="p-4 text-center w-100">
      {{ $stories->total() }} Search results for <strong>{{ $query }}</strong>
    </div>
    <div class="container mb-4">
      <h1 class="py-2 border-bottom">Stories
        <span class="float-right">
          <form action="/story/create" method="post">
            @csrf
            <button class="btn btn-primary"> Add new</button>
          </form>
        </span>
      </h1>
    </div>
</div>
@else
<div class="container mb-4">
  <h1 class="py-2 border-bottom">Stories
    <span class="float-right">
      <form action="/story/create" method="post">
        @csrf
        <button class="btn btn-primary"> Add new</button>
      </form>
    </span>
  </h1>
</div>
@endif

<div class="container mb-3">
  <form action="/dashboard/stories" method="get">
    <input type="text" name="q" value="" placeholder="Search..." class="p-3 from-control w-100">
  </form>
</div>

<div class="container">
  @if($stories->count())
  <div class="table-responsive">
    <table class="table table-hover table-light">
      <thead class="bg-dark text-white">
        <tr>
          <th>#</th>
          <th scope="col">Image</th>
          <th scope="col">Type</th>
          <th scope="col">Title</th>
          <th scope="col">Tags</th>
          <th scope="col" class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="">
        @foreach($stories as $story)
        <tr>
          <th scope="row" class="align-middle">{{$loop->iteration}}</th>
          <td class="align-middle">
            <img src="{{!!$story->avatar ? Storage::url($story->avatar) : '/img/banner.png' }}" width="75" alt="banner">
          </td>
          <td class="align-middle">{{$story->type}}</td>
          <td class="align-middle">{{$story->title}}</td>
          <td class="align-middle">{{$story->role->name}}</td>
          <td class="text-right align-middle">
            <a href="/story/edit/{{$story->uid}}" class="btn btn-primary btn-sm my-1"><i class="fas fa-pencil"></i></a>
            <a href="/story/delete/{{$story->uid}}" class="btn btn-danger btn-sm my-1"><i class="fas fa-trash-alt"></i></a>
          </td>
        </tr>
        @endforeach

        <!-- <tr v-for="(user, index) in users">
          <th scope="row" class="align-middle">@{{index + 11}}</th>
          <th class="align-middle">
            <img class="rounded-circle" id="avatar-image" :src="user.avatar" width="50" height="50" alt="avatar">
          </th>
          <td class="align-middle">@{{user.username}}</td>
          <td class="align-middle">@{{user.email}}</td>
          <td class="align-middle">@{{user.role.name}}</td>
          <td class="text-right align-middle">
            <a :href="'/user/edit/' + user.username" class="btn btn-primary btn-sm my-1"><i class="fas fa-pencil"></i></a>
            <a :href="'/user/delete/' + user.id" class="btn btn-danger btn-sm my-1"><i class="fas fa-trash-alt"></i></a>
          </td>
        </tr> -->
      </tbody>
    </table>
  </div>
  @endif
</div>

<!-- <load-more
 :current="{{ $stories->currentPage() }}"
 :last="{{ $stories->lastPage() }}"
 search="/dashboard/stories"
 array="stories"
 query="{{ $query }}"
 @update="addstories"
>Load more stories</load-more> -->

@endsection
