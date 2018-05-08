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
          $permissions = Permission::get()->map(function ($carry, $item) {
            return $carry->name;
          });

          return $user->role->permissions->contains(function($perm) use ($ability, $permissions) {
            return $permissions->contains($ability) && ($perm->name === 'administrator' || $ability);
          });
        });

        // if (Schema::hasTable('permissions')) {
        //   // dump('has table');
        //   foreach (Permission::with('roles')->get() as $perm) {
        //     Gate::define($perm->name, function ($user) use ($perm) {
        //       return $user->role->permissions->contains('name', 'administrator')
        //             || $perm->roles->contains('name', $user->role->name);
        //     });
        //   }
        // }

        // Blade::if('can', function ($perm) {
        //   return Auth::check() && Gate::forUser(Auth::user())->allows($perm);
        // });

    }
}
