<?php

namespace App\Providers;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Location;
use App\Models\SeoMeta;
use App\Services\SitemapService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        Paginator::useBootstrap();

        // Behind Hostinger's proxy requests can reach PHP as plain http, which
        // previously leaked http:// URLs into canonicals, og:image and the
        // sitemap. Generate every URL from APP_URL over https in production.
        if ($this->app->environment('production')) {
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        }

        // Regenerate sitemap.xml whenever a page, category or location changes.
        foreach ([SeoMeta::class, Category::class, Location::class, Campaign::class] as $model) {
            $model::saved(fn () => SitemapService::flush());
            $model::deleted(fn () => SitemapService::flush());
        }
    }
}
