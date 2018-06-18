<div class="container mt-4">
  <h1 class="py-2 border-bottom mb-2">Version History</h1>
  <div class="list-group list-group-flush">
    @foreach($versions as $v)
    <div v-pre class="list-group-item p-2 d-flex align-items-center justify-content-between {{ ($version->uid != $v->uid) ? 'list-group-item-muted' : '' }}">
      <span class="font-weight-bold">
        <span class="mr-2"  v-pre title="{{ $v->user->username }}" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
          <img class="rounded-circle" id="avatar-image"  v-pre src="{{ $v->user->avatar }}" width="20" height="20" alt="avatar">
        </span>
        <span v-pre>
          @if (!!$thing->published() && $v->uid == $thing->published()->uid)
          <span title="published" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
            <i class="fas fa-check mr-1 text-success"></i>
          </span>
          @elseif (!!$thing->queued() && $v->uid == $thing->queued()->uid)
          <span title="awaiting approval" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
            <i class="fas fa-spinner fa-pulse"></i>
          </span>
          @endif

          @if ($v->uid == $thing->current()->uid)
          <span title="saved" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
            <i class="fas fa-save mr-1 text-primary"></i>
          </span>
          @endif
          {{ $v->commit ?? "Unnamed commit: $v->uid" }}
        </span>
      </span>
      <a v-pre href="/{{$name}}/edit/{{$thing->uid .'/'. $v->uid}}" class="float-right btn btn-link p-0">
        <small v-pre>{{ $v->uid }}</small>
      </a>
    </div>
    @endforeach
  </div>
</div>
