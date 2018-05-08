<?php

namespace App\Listeners;

use Report;

// use App\Events\Event;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Contracts\Queue\ShouldQueue;

class UserEventSubscriber
{
    public function onUserLogin($event) {
      Report::info([
        "message" => "user logged in",
        "data" => [
          "user" => $event->user,
        ]
      ]);
    }

    public function onUserLogout($event) {
      Report::info([
        "message" => "user left",
        "data" => [
          "user" => $event->user,
        ]
      ]);
    }

    public function subscribe($events) {
      $events->listen(
        'Illuminate\Auth\Events\Login',
        'App\Listeners\UserEventSubscriber@onUserLogin'
      );

      $events->listen(
        'Illuminate\Auth\Events\Logout',
        'App\Listeners\UserEventSubscriber@onUserLogout'
      );
    }
}
