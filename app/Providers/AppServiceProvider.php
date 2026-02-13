<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    use \Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::automaticallyEagerLoadRelationships();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        RouteServiceProvider::loadCachedRoutesUsing(fn() => $this->loadCachedRoutes());

        Gate::define('access-admin-panel', function (User $user) {
            return in_array($user->role_id, [Role::SUPER_ADM, Role::ADMIN]);
        });
    }
}
