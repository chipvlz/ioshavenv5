<div class="fixed-bottom p-3">
  @if (isset($info))
  <div class="collapse" id="collapseExample">
    <div class="w-100 d-flex flex-wrap align-items-center justify-content-end">
      @foreach($info as $i)
      <div class="btn ml-2 mb-2 like">
        <i v-pre class="fas fa-{{$i['icon']}}"></i>
        <span v-pre class="ml-2">{{$i['value']}}</span>
      </div>
      @endforeach
    </div>
  </div>
  <button class="btn float-right ml-2 like" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    <i class="fas fa-question"></i>
  </button>
  @endif
  @if(Auth::guest())
  <div class="float-right" title="Like!" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
    <button class="btn float-right like" data-toggle="modal" data-target="#authModal">
      <i class="fas fa-heart"></i>
      <span v-pre class="ml-2 likes">{{formatNum($thing->likeCount())}}</span>
    </button>
  </div>
  @elseif($thing->isLiked())
    <button class="btn float-right like liked" v-pre data-uid="{{ $thing->uid }}" data-like="{{$table}}" title="Like!" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
      <i class="fas fa-heart"></i>
      <span v-pre class="ml-2 likes">{{formatNum($thing->likeCount())}}</span>
    </button>
  @else
    <button v-pre class="btn float-right like" data-uid="{{ $thing->uid }}" data-like="{{$table}}" title="Undo like" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
      <i class="fas fa-heart"></i>
      <span v-pre class="ml-2 likes">{{formatNum($thing->likeCount())}}</span>
    </button>
  @endif



</div>
