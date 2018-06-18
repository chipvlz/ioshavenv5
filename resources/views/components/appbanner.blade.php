<div class="mb-3 jumbotron-fluid">
  <img id="banner-image" v-pre src="{{ $version->banner }}" class="w-100" alt="banner">
</div>

<div class="container">
    <div class="d-flex align-items-start justify-content-start">
      <img class="mr-3" id="icon-image" v-pre src="{{ $version->icon }}" alt="icon" width="100">
      <div class="d-flex align-items-center flex-wrap">
        <div class="mb-2">
          <h4 v-pre>{{ $version->name }}</h4>
          @if($version->apk)
          <a v-pre href="/download/app/apk/{{$app->uid}}/{{$version->uid}}" target="_blank" class="btn btn-sm btn-light mb-1 border border-dark"><i class="fas fa-file-archive mr-2"></i>Get .apk</a>
          @endif
          @if($version->unsigned)
          <a v-pre href="/download/app/unsigned/{{$app->uid}}/{{$version->uid}}" target="_blank" class="btn btn-sm btn-light mb-1 border border-dark"><i class="fas fa-file-archive mr-2"></i>Get .ipa</a>
          @endif
          @if($version->duplicate)
          <a v-pre href="/download/app/duplicate/{{$app->uid}}/{{$version->uid}}" target="_blank" class="btn btn-sm btn-success mb-1"><i class="fas fa-copy mr-2"></i>Duplicate</a>
          @endif
          @if($version->signed)
          <a v-pre href="/download/app/signed/{{$app->uid}}/{{$version->uid}}" target="_blank" class="btn btn-sm btn-primary mb-1"><i class="fas fa-download mr-2"></i>Install</a>
          @endif
          @if(!$version->apk && !$version->unsigned && !$version->signed && !$version->duplicate)
          <span>No download options available yet.</span>
          @endif
        </div>
        <div class="w-100 d-flex flex-wrap align-items-center small">
          <div class="btn mr-2 mb-2 like small">
            <i class="fas fa-download"></i>
            <span class="ml-2" id="downloads" v-pre>{{ formatNum($app->downloads) }}</span>
          </div>
          <div class="btn mr-2 mb-2 like small">
            <i class="fas fa-eye"></i>
            <span class="ml-2" id="views" v-pre>{{ formatNum($app->views) }}</span>
          </div>
          <div class="btn mr-2 mb-2 like small">
            <i class="fas fa-file-archive"></i>
            <span class="ml-2" id="size" v-pre>{{ formatBytes($version->size) }}</span>
          </div>
          <div class="btn mr-2 mb-2 like small">
            <i class="fas fa-code-branch"></i>
            <span class="ml-2" id="version" v-pre>{{ $version->version }}</span>
          </div>
        </div>

      </div>

    </div>
  <!-- </div> -->

</div>
