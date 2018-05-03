<div class="container mt-4">
  <h1 class="py-2 border-bottom mb-2">Version History</h1>
  <div class="list-group list-group-flush">
    @foreach($versions as $v)
    <div class="list-group-item p-2 d-flex align-items-center justify-content-between {{ ($version->uid != $v->uid) ? 'list-group-item-muted' : '' }}">
      <span class="font-weight-bold">
        <span class="mr-2" data-toggle="tooltip" data-placement="bottom" title="{{ $v->user->username }}">
          <img class="rounded-circle" id="avatar-image" src="{{!!$v->user->avatar ? Storage::url($v->user->avatar) : 'https://api.adorable.io/avatars/200/'.$v->user->username }}" width="20" height="20" alt="avatar">
        </span>
        <span>
          @if (!!$thing->published() && $v->uid == $thing->published()->uid)
          <span data-toggle="tooltip" data-placement="right" title="published">
            <i class="fas fa-check mr-1 text-success"></i>
          </span>
          @elseif (!!$thing->queued() && $v->uid == $thing->queued()->uid)
          <span data-toggle="tooltip" data-placement="right" title="awaiting approval">
            <i class="fas fa-spinner fa-pulse"></i>
          </span>
          @endif

          @if ($v->uid == $thing->current()->uid)
          <span data-toggle="tooltip" data-placement="right" title="saved">
            <i class="fas fa-save mr-1 text-primary"></i>
          </span>
          @endif
          {{ $v->commit ?? "Unnamed commit: $v->uid" }}
        </span>
      </span>
      <a href="/{{$name}}/edit/{{$thing->uid .'/'. $v->uid}}" class="float-right btn btn-link p-0">
        <small>{{ $v->uid }}</small>
      </a>
    </div>
    @endforeach
  </div>
</div>
