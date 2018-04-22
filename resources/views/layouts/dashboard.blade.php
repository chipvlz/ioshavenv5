<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.header')
</head>
<body>
    <div id="app" class="has-nav">
        @include('layouts.navigation-small')
        <div class="dashboard">
          <div :class="['sidebar', {show: showdashboard} ]">
            <ul>
              <li @click="toggleDashboard(true)" v-if="!showdashboard">
                <span class="icon"><i class="fal fa-bars"></i></span>
              </li>
              <li @click="toggleDashboard(false)" v-if="showdashboard">
                  <span class="icon"><i class="fal fa-times"></i></span>
                  <span class="label pl-2">Close</span>
              </li>
              <li>
                <a href="/dashboard/profile">
                  <div class="user-icon">
                    <span class="icon"><i class="fal fa-user"></i></span>
                    <span class="label pl-2">Profile</span>
                  </div>
                  <div class="user py-2 px-2">
                    <img src="http://placeimg.com/250/250/people" alt="avatar" class="rounded-circle avatar" width="50" height="50">
                    <div class="info">
                      <div class="username">{{ Auth::user()->username }}</div>
                      <div>{{ Auth::user()->email }}</div>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="/dashboard/logs">
                  <span class="icon"><i class="fal fa-info"></i></span>
                  <span class="label pl-2">Logs</span>
                </a>
              </li>
              <li>
                <a href="/dashboard/users">
                  <span class="icon"><i class="fal fa-users"></i></span>
                  <span class="label pl-2">Users</span>
                </a>
              </li>
              <li>
                <a href="/dashboard/apps">
                  <span class="icon"><i class="fal fa-th-large"></i></span>
                  <span class="label pl-2">Apps</span>
                </a>
              </li>
            </ul>
          </div>
          <main class="py-4">
              @yield('content')
          </main>
        </div>
    </div>

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="/js/app.js" charset="utf-8"></script>
    <script src="/fa/svg-with-js/js/fontawesome-all.min.js" charset="utf-8"></script>
</body>
</html>
