<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Permission;
use App\Report;
use Illuminate\Support\Facades\Blade;
use Auth;
use DB;
use Illuminate\Support\Facades\Schema;
// use App\Policies\PermissionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
          if (!Schema::hasTable('permissions')) return false;
          return $user->role->permissions->pluck('name')->contains($ability)
              || $user->role->permissions->pluck('name')->contains("administrator");
        });

    }
}
