@extends('layouts.dashboard')
@section('content')

@if(!!$query)
<div class="banner home query">
    <div class="p-4 text-center w-100">
      {{ $users->total() }} Search results for <strong>{{ $query }}</strong>
    </div>
    <div class="container mb-4">
      <h1 class="py-2 border-bottom">Users</h1>
    </div>
</div>
@else
<div class="container mb-4">
  <h1 class="py-2 border-bottom">Users</h1>
</div>
@endif

<div class="container mb-3">
  <form action="/dashboard/users" method="get">
    <input type="text" name="q" value="" placeholder="Search..." class="p-3 from-control w-100">
  </form>
</div>

<div class="container">
  <div class="table-responsive">
    <table class="table table-hover table-light">
      <thead class="bg-dark text-white">
        <tr>
          <th>#</th>
          <th scope="col">Avatar</th>
          <th scope="col">Username</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col" class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="">
        @foreach($users as $user)
        <tr class="{{ $user->trashed() ? 'table-danger text-danger' : '' }}">
          <th scope="row" class="align-middle">{{$loop->iteration}}</th>
          <td class="align-middle">
            <img class="rounded-circle" id="avatar-image" src="{{!!$user->avatar ? Storage::url($user->avatar) : 'https://api.adorable.io/avatars/200/'.$user->username }}" width="50" height="50" alt="avatar">
          </td>
          <td class="align-middle">{{$user->username}}</td>
          <td class="align-middle">{{$user->email}}</td>
          <td class="align-middle">{{$user->role->name}}</td>
          <td class="text-right align-middle">
            @if($user->trashed())
            <button type="button" class="btn btn-dark btn-sm my-1" data-toggle="popover" title="Ban reason" data-content="{{ $user->ban_reason ?? 'N/A'}}">
              <i class="fas fa-question"></i>
            </button>
            @endif
            <a href="/user/edit/{{$user->username}}" class="btn btn-primary btn-sm my-1"><i class="fas fa-pencil"></i></a>
          </td>
        </tr>
        @endforeach

        <tr v-for="(user, index) in users">
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
        </tr>
      </tbody>
    </table>
  </div>
</div>

<load-more
 :current="{{ $users->currentPage() }}"
 :last="{{ $users->lastPage() }}"
 search="/dashboard/users"
 array="users"
 query="{{ $query }}"
 @update="addUsers"
>Load more users</load-more>

@endsection
