@extends('layouts.dashboard')
@section('content')

<div class="container mb-4">
  <h1 class="py-2 border-bottom d-flex align-items-end justify-content-between">{{ $user->username }}
    <span>
      <img class="rounded-circle" id="avatar-image" src="{{!!$user->avatar ? Storage::url($user->avatar) : 'https://api.adorable.io/avatars/200/'.$user->username }}" width="75" height="75" alt="avatar">
    </span>
  </h1>
</div>

<form action="/user/edit" method="post">
  @csrf
  <input type="hidden" name="id" value="{{$user->id}}">
  <div class="container d-flex flex-wrap">

    @if(!$isAuth)
    <div class="form-group w-100">
      <label for="role">Select Role</label>
      <select class="form-control" id="role" name="role">
        <option selected="selected" disabled="disabled">{{ $user->role->name }}</option>
        @foreach($roles as $role)
        <option value="{{$role->id}}">{{$role->name}}</option>
        @endforeach
      </select>
    </div>
    @endif

    <div class="form-group w-100">
      <label for="username" class="h6">Username</label>
      <input autocomplete="dashboard-profile-{{$user->username}}" value="{{$user->username}}" type="text" class="form-control py-3 px-3" id="username" name="username" placeholder="Username...">
    </div>

    <div class="form-group w-100">
      <label for="email" class="h6">Email</label>
      <input autocomplete="dashboard-email-{{$user->username}}" value="{{$user->email}}" type="email" class="form-control py-3 px-3" id="email" name="email" placeholder="Email...">
    </div>

    <div class="form-group w-100">
      <label for="avatar" class="h6">Avatar</label>
      <file-upload id="avatar" name="avatar" @success="avatarSuccess" class="mb-3" action="/upload/avatar" :data="[{
        name: 'id',
        value: '{{ $user->id }}'
        }]">
        <i class="fas fa-image mr-2"></i>Upload Avatar
      </file-upload>
    </div>

    <div class="card text-white bg-danger mb-3 w-100">
      <div class="card-header"><i class="fas fa-exclamation-triangle mr-2"></i>DANGER<i class="fas fa-exclamation-triangle ml-2"></i></div>
      <div class="card-body bg-light text-dark">
        @if($isAuth)
        <div class="form-group w-100">
          <label for="old-password" class="h6">Old password</label>
          <input autocomplete="dashboard-old-password-{{$user->username}}" type="password" class="form-control py-3 px-3" id="old-password" name="old_password" placeholder="Old password...">
        </div>

        <div class="form-group w-100">
          <label for="password" class="h6">New password</label>
          <input autocomplete="dashboard-new-password-{{$user->username}}" type="password" class="form-control py-3 px-3" id="password" name="password" placeholder="New password...">
        </div>

        <div class="form-group w-100">
          <label for="password-confirm" class="h6">Confirm Password</label>
          <input autocomplete="dashboard-new-password-{{$user->username}}" type="password" class="form-control py-3 px-3" id="password-confirm" name="password_confirmation" placeholder="Confirm password...">
        </div>
        @else
          @can('manage users')
            @if ($user->trashed())
              <h5 class="card-title">Would you like to restore this user?</h5>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#restoreModal">
                <i class="fal fa-check mr-2"></i>Restore
              </button>
            @else
              <h5 class="card-title">Would you like to ban this user?</h5>
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                <i class="fal fa-trash-alt mr-2"></i>Ban
              </button>
            @endif
          @endcan
        @endif

      </div>
    </div>
  </div>

  @can('manage users')
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Ban User?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Please enter the reason for banning <strong>{{$user->username}}</strong> to confirm the process. Once this action is performed, it cannot be undone!
          <textarea type="text" name="ban_reason" placeholder="Ban reason..." class="form-control py-3 px-3 mt-2"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" name="ban" value="1">Ban</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="restoreModalLabel">Restore User?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Please click the restore button to restore the previous status of <strong>{{$user->username}}</strong>.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" name="restore" value="1">Restore</button>
        </div>
      </div>
    </div>
  </div>
  @endcan

  <div class="fixed-bottom p-3 bottom-nav">
    @if ($user->created_at != $user->updated_at)
    <small><span class="text-muted mr-2">Updated {{$user->updated_at->diffForHumans()}} </span></small>
    @endif
    <button type="submit" class="btn btn-primary d-flex align-items-center mr-2 btn-sm" name="review" value="0"><i class="fas fa-save mr-2"></i>Save</button>
  </div>
</form>

@endsection
