<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.header')
</head>
<body>
    <div id="app" class="has-nav">
        @include('layouts.navigation-small')
        <div class="dashboard {{ isset($hasBottomNav) ? 'has-bottom-nav' : ''}}">
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
                <a href="/dashboard">
                  <span class="icon"><i class="fal fa-chart-line"></i></span>
                  <span class="label pl-2">Stats</span>
                </a>
              </li>

              <li>
                <a href="/dashboard/profile">
                  <div class="user-icon">
                    <span class="icon"><i class="fal fa-user"></i></span>
                    <span class="label pl-2">Profile</span>
                  </div>
                  <div class="user py-2 px-2 border-top border-bottom border-light">
                    <img src="{{ Auth::user()->avatar }}" alt="avatar" class="rounded-circle avatar" width="50" height="50">
                    <div class="info">
                      <div class="username">{{ Auth::user()->username }}</div>
                      <div>{{ Auth::user()->email }}</div>
                    </div>
                  </div>
                </a>
              </li>

              @can('upload apps')
              <li>
                <a href="/dashboard/apps">
                  <span class="icon"><i class="fal fa-th-large"></i></span>
                  <span class="label pl-2">Apps</span>
                </a>
              </li>
              @endcan

              @can('view logs')
              <li>
                <a href="/dashboard/logs">
                  <span class="icon"><i class="fal fa-info"></i></span>
                  <span class="label pl-2">Logs</span>
                </a>
              </li>
              @endcan

              @can('create stories')
              <li>
                <a href="/dashboard/stories">
                  <span class="icon"><i class="fal fa-newspaper"></i></span>
                  <span class="label pl-2">News</span>
                </a>
              </li>
              @endcan

              @can('manage roles')
              <li>
                <a href="/dashboard/roles">
                  <span class="icon"><i class="fal fa-gavel"></i></span>
                  <span class="label pl-2">Roles</span>
                </a>
              </li>
              @endcan

              @can('manage users')
              <li>
                <a href="/dashboard/users">
                  <span class="icon"><i class="fal fa-users"></i></span>
                  <span class="label pl-2">Users</span>
                </a>
              </li>
              @endcan



            </ul>

            <ul>
              <li>
                <a href="/">
                  <span class="icon"><i class="fal fa-home"></i></span>
                  <span class="label pl-2">Home</span>
                </a>
              </li>
              <li class="bg-danger">
                <a href="#" class="logout">
                  <span class="icon"><i class="fal fa-sign-out-alt"></i></span>
                  <span class="label pl-2">Logout</span>
                </a>
              </li>
            </ul>
          </div>
          <main class="pb-4" id="dashboard-content">
              @include('layouts.alerts')
              @yield('content')
          </main>
        </div>
    </div>

    <!-- Include the Quill library -->
    @yield('footer')
    <script src="/js/app.js" charset="utf-8"></script>
</body>
</html>
