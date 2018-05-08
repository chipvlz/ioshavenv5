@extends('layouts.dashboard')
@section('content')

@if(!!$query)
<div class="banner home query">
    <div class="p-4 text-center w-100">
      {{ $logs->total() }} Search results for <strong>{{ $query }}</strong>
    </div>
    <div class="container mb-4">
      <h1 class="py-2 border-bottom">Logs</h1>
    </div>
</div>
@else
<div class="container mb-4">
  <h1 class="py-2 border-bottom">Logs</h1>
</div>
@endif

<div class="container mb-3">
  <form action="/dashboard/logs" method="get">
    <input type="text" name="q" value="" placeholder="Search..." class="p-3 from-control w-100">
  </form>
</div>

<div class="container">
  <div class="table-responsive">
    <table class="table table-hover table-light">
      <thead class="bg-dark text-white">
        <tr>
          <th scope="col">#</th>
          <th scope="col">User</th>
          <th scope="col">Message</th>
          <th scope="col">Time</th>
          <th scope="col" class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody class="">
        @foreach($logs as $log)
          @if($log->level === 'danger' || $log->level === 'warning')
            <tr class="table-{{$log->level}}">
          @elseif($log->level === 'success')
            <tr class="text-{{$log->level}}">
          @endif
            <th scope="row" class="align-middle text-dark">{{$loop->iteration}}</th>
            <td class="align-middle py-1" width="40" title="{{ $log->user->username }}" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
              <img class="rounded-circle" width="25" height="25" id="avatar-image" src="{{!!$log->user->avatar ? Storage::url($log->user->avatar) : 'https://api.adorable.io/avatars/200/'.$log->user->username }}"  alt="avatar">
            </td>
            <td class="align-middle py-1">{{$log->message}}</td>
            <td class="align-middle py-1 text-dark">{{$log->created_at->diffForHumans()}}</td>
            <td class="text-right align-middle py-1">
              <button type="button" class="btn btn-dark btn-sm my-1" data-toggle="modal" data-target="#logModal" data-message="{{$log->message}}" data-method="{{$log->method}}" data-data="{{$log->data}}" data-level="{{$log->level}}"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
        @endforeach

        <tr :class="getLogClass(log.level)" v-for="(log, index) in logs">
          <th scope="row" class="align-middle text-dark">@{{index + 11}}</th>
          <td class="align-middle py-1" width="40" :title="log.user.username" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
            <img class="rounded-circle" width="25" height="25" :src="log.user.avatar" alt="avatar">
          </td>
          <td class="align-middle py-1">@{{log.message}}</td>
          <td class="align-middle py-1 text-dark">@{{log.time}}</td>
          <td class="text-right align-middle py-1">
            <button type="button" class="btn btn-dark btn-sm my-1" data-toggle="modal" data-target="#logModal" :data-message="log.message" :data-method="log.method" :data-data="log.data" :data-level="log.level"><i class="fas fa-eye"></i></a>
          </td>
        </tr>

      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logModalLabel">Log info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
           <strong>Level:</strong>
           <code class="level"></code>
        </div>
        <div>
           <strong>Message:</strong>
           <code class="message"></code>
        </div>
        <div>
           <strong>Method:</strong>
           <code class="method"></code>
        </div>
        <div>
           <strong>Data:</strong>
           <pre class="data pre-scrollable" style="background: #f5f5f5"></pre>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<load-more
 :current="{{ $logs->currentPage() }}"
 :last="{{ $logs->lastPage() }}"
 search="/dashboard/logs"
 array="logs"
 query="{{ $query }}"
 @update="addLogs"
>Load more logs</load-more>

@endsection
