@extends('layouts.dashboard')
@section('content')

<div class="container mb-4">
  <h1 class="py-2 border-bottom">Roles
    <span class="float-right">
      <form action="/role/create" method="post">
        @csrf
        <button class="btn btn-primary"> Add new</button>
      </form>
    </span>
  </h1>
</div>

<div class="container">
  <div class="table-responsive">
    <table class="table table-hover table-light">
      <thead class="bg-dark text-white">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Role</th>
          <th scope="col">Permissions</th>
          <th scope="col" class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="">
        @foreach($roles as $role)
        <tr>
          <th scope="row" class="align-middle" v-pre>{{ $role->id }}</th>
          <td class="align-middle" v-pre>{{$role->name}}</td>
          <td class="align-middle">
            @foreach($role->permissions as $perm)
              @if ($role->isAllowedTo("administrator"))
              <span class="badge badge-danger badge-pill">administrator</span>
              @break
              @else
              <span class="badge badge-dark badge-pill" v-pre>{{$perm->name}}</span>
              @endif
            @endforeach
            @if (!$role->permissions->count())
            <span class="badge badge-light badge-pill">no permissions</span>
            @endif
          </td>
          <td class="text-right align-middle">
            <a href="/role/edit/{{$role->id}}" class="btn btn-primary btn-sm my-1" v-pre><i class="fas fa-pencil"></i></a>
            <a href="/role/delete/{{$role->id}}" class="btn btn-danger btn-sm my-1" v-pre><i class="fas fa-trash-alt"></i></a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
