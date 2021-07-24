<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-administrator', function ($user) {
            return $user->hasAnyRole('Administrator');
        });

        Gate::define('is-author', function ($user) {
            return $user->hasAnyRole('Author');
        });

        Gate::define('is-editor', function ($user) {
            return $user->hasAnyRole('Editor');
        });

        Gate::define('is-author-administrator', function ($user) {
            return $user->hasAnyRoles(['author', 'administrator']);
        });

        Gate::define('is-author-editor', function ($user) {
            return $user->hasAnyRoles(['author', 'editor']);
        });
    }
}
