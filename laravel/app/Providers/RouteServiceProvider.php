<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's admin route.
     *
     * Typically, admins are redirected here after authentication.
     *
     * @var string
     */
    public const USER_DASHBOARD = '/alumni/dashboard';

    /**
     * The path to your application's admin route.
     *
     * Typically, admins are redirected here after authentication.
     *
     * @var string
     */
    public const ADMIN_DASHBOARD = '/admin/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Registered before web.php: web.php's catch-all `/{slug}` route
            // (for public category pages) matches ANY single path segment,
            // including literal "admin" — since Laravel resolves routes in
            // registration order rather than by specificity, admin.php has
            // to be registered first or its own "/admin" route is never
            // reached.
            Route::middleware('web')
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
