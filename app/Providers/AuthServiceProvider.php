<?php

namespace App\Providers;

use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Solicitacao;
use App\User;
use App\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // \App\Solicitacao::class => \App\Policies\SolicitacaoPolicy::class,

    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */

    public function boot()
    {
        $this->registerPolicies();

        $permissions = Permission::with('roles')->get();

        foreach ($permissions as $permission) {
            /** @var \App\Permission $permission */
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }

        Gate::before(function (User $user, $ability) {
            if ($user->hasAnyRoles('SUPER ADM')) return true;
        });
    }
}
