
<div class="container">
  @if ($errors->any())
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show" role="alert" v-pre>
      {{ $error }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endforeach
  @endif

  @foreach(Session::all() as $status => $message)
  @if(in_array($status, ["success", "primary", "danger", "warning", "info", "secondary", "light", "dark", "white"]))
  <div class="alert alert-{{$status}} alert-dismissible fade show" role="alert" v-pre>
    {{ $message }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @endforeach
</div>
