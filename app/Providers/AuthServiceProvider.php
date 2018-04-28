<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Permission;
use App\Log;
use Illuminate\Support\Facades\Blade;
use Auth;
use DB;
use Illuminate\Support\Facades\Schema;

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

        if (Schema::hasTable('permissions')) {
          foreach (Permission::with('roles')->get() as $perm) {
            Gate::define($perm->name, function ($user) use ($perm) {
              return $user->role->permissions->contains('name', 'administrator')
                    || $perm->roles->contains('name', $user->role->name);
            });
          }
        }

        Blade::if('can', function ($perm) {
          return Auth::check() && Gate::forUser(Auth::user())->allows($perm);
        });

    }
}
