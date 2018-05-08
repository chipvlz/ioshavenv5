<div class="fixed-bottom p-3">
  @if(Auth::guest())
  <div class="float-right" title="Like!" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
    <button class="btn float-right like" data-toggle="modal" data-target="#authModal">
      <i class="fas fa-heart"></i>
      <span class="ml-2 likes">{{formatNum($thing->likeCount())}}</span>
    </button>
  </div>
  @elseif($thing->isLiked())
    <button class="btn float-right like liked" data-uid="{{ $thing->uid }}" data-like="{{$table}}" title="Like!" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
      <i class="fas fa-heart"></i>
      <span class="ml-2 likes">{{formatNum($thing->likeCount())}}</span>
    </button>
  @else
    <button class="btn float-right like" data-uid="{{ $thing->uid }}" data-like="{{$table}}" title="Undo like" data-toggle="tooltip" data-placement="bottom" data-delay='{ "show": 1000, "hide": 100 }'>
      <i class="fas fa-heart"></i>
      <span class="ml-2 likes">{{formatNum($thing->likeCount())}}</span>
    </button>
  @endif
</div>
