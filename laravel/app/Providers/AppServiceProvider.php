<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Location;
use App\Models\SeoMeta;
use App\Services\SitemapService;
use Illuminate\Pagination\Paginator;
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

        // Regenerate sitemap.xml whenever a page, category or location changes.
        foreach ([SeoMeta::class, Category::class, Location::class] as $model) {
            $model::saved(fn () => SitemapService::flush());
            $model::deleted(fn () => SitemapService::flush());
        }
    }
}
