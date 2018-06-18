@extends('layouts.dashboard')
@section('content')

<div class="container mb-4">
  <h1 class="py-2 border-bottom" v-pre>{{$role->name}} Permissions</h1>
</div>

<form action="/role/edit" method="post">
  @csrf
  <input type="hidden" name="role" value="{{ $role->id }}" v-pre>
  <div class="container d-flex flex-wrap">

    <table class="table table-hover table-light">
      <thead class="bg-dark text-white">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Permission</th>
          <th scope="col">Label</th>
          <th scope="col" class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="">
        @foreach($permissions as $perm)
        <tr>
          <th scope="row" class="align-middle" v-pre>{{ $perm->id }}</th>
          <td class="align-middle" v-pre>{{$perm->name}}</td>
          <td class="align-middle" v-pre>{{ $perm->label }}</td>
          <td class="text-right align-middle">
            <label class="checkbox-label">
              @if ($role->isAllowedTo($perm->name))
                <input type="checkbox" name="ids[]" checked="checked" value="{{$perm->id}}" v-pre>
              @else
                <input type="checkbox" name="ids[]" value="{{$perm->id}}" v-pre>
              @endif
              <span class="check"><i class="fas fa-check"></i></span>
            </label>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="form-group w-100">
      <label for="name" class="h6">Role name</label>
      <input value="{{$role->name}}" type="text" class="form-control py-3 px-3" id="name" name="name" placeholder="Role name..." v-pre>
    </div>
  </div>

  <div class="fixed-bottom p-3 bottom-nav">
    <small><span class="text-muted mr-2" v-pre>
      {{ ($role->created_at == $role->updated_at) ? 'Created' : 'Saved'}}
      {{$role->updated_at->diffForHumans()}}</span></small>
    <button type="submit" class="btn btn-primary d-flex align-items-center mr-2 btn-sm" name="review" value="0"><i class="fas fa-save mr-2"></i>Save</button>
  </div>
</form>


@endsection
