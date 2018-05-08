<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @if(View::hasSection('meta'))
      @yield('meta')
    @else
      @component('components.meta', [
        "description" => "Get all your iPhone app needs straight from the web. Including IPAs, signed apps, Apple developer betas, and jailbreaks.",
        "image" => url('/img/' . env('APP_TYPE') . '-banner.png'),
        "title" => "Home",
        "url" => url('/'),
      ])@endcomponent
    @endif
    @include('layouts.header')
</head>
<body>
    <div id="app">
        @include('layouts.navigation-small')
        @include('layouts.navigation-big')

        <main class="pb-5">
            @yield('content')
        </main>
    </div>

    <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header align-items-center justify-content-center py-2">
            <h6 class="modal-title font-weight-bold" id="authModalLabel">Join {{strToUpper(env('APP_TYPE'))}} Haven</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body w-100 text-center">
            <div class="h2 text-danger py-3"><i class="fal fa-heart"></i></div>
            <h5 class="font-weight-bold pb-1">Join {{strToUpper(env('APP_TYPE'))}} Haven to perform this action.</h5>
            <a href="/register" class="btn btn-primary btn-fancy">Register</a>
          </div>
          <div class="modal-footer modal-footer align-items-center justify-content-center py-2">
            Have an account? <a href="/login" class="btn btn-link">Login <i class="far fa-angle-double-right small"></i></a>
          </div>
        </div>
      </div>
    </div>

    <script src="{{ url('/js/app.js') }}" charset="utf-8"></script>
</body>
</html>
