<div class="app-banner mb-3 jumbotron-fluid">
  <img id="banner-image" src="{{!!$app->banner ? Storage::url($app->banner) : '/img/banner.png'}}" class="w-100" alt="banner">
</div>

<div class="container">
  <div class="row mb-2">

    <div class="col-md-2 col-5">
      <img id="icon-image" src="{{!!$app->icon ? Storage::url($app->icon) : '/img/icon.png'}}" alt="icon" width="100">
    </div>

    <div class="info">
      <div class="h4 font-weight-bold mb-1">{{$app->name}} </div>
      <!-- <div class="text-muted mb-2">{{$app->status}} | {{$app->updated_at->diffForHumans()}}</div> -->
      <button class="btn btn-sm btn-light mb-1 border border-dark px-4"><i class="fas fa-wrench mr-2"></i>Download</button>
      <button class="btn btn-sm btn-success mb-1 px-4"><i class="fas fa-copy mr-2"></i>Duplicate</button>
      <button class="btn btn-sm btn-primary mb-1 px-4"><i class="fas fa-arrow-alt-to-bottom mr-2"></i>Install</button>
    </div>

  </div>

  <div class="stats row">
    <div class="stat-wrapper pb-2">
      <div class="stat">
        <strong class="h3">{{ formatNum($app->downloads) }}</strong>
        <div class="text-muted">Downloads</div>
      </div>
    </div>
    <div class="stat-wrapper pb-2">
      <div class="stat">
        <strong class="h3">{{ formatNum($app->views) }}</strong>
        <div class="text-muted">Views</div>
      </div>
    </div>
    <div class="stat-wrapper pb-2">
      <div class="stat">
        <strong class="h3" id="size">{{ formatBytes($app->size) }}</strong>
        <div class="text-muted">Size</div>
      </div>
    </div>
    <div class="stat-wrapper pb-2">
      <div class="stat">
        <strong class="h3">{{ $app->version ?? "N/A" }}</strong>
        <div class="text-muted">Version</div>
      </div>
    </div>
  </div>
</div>
