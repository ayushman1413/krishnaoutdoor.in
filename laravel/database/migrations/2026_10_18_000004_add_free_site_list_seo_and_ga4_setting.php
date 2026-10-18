<?php

use App\Models\SeoMeta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Data migration: SEO row for /free-site-list (noindex) and the GA4
 * measurement ID that used to be hard-coded in the layout, so tracking now
 * comes from SEO settings without changing what is measured.
 */
return new class extends Migration
{
    public function up(): void
    {
        $page = config('seo_pages')['view.free.site.list'];

        SeoMeta::updateOrCreate(
            ['route_name' => 'view.free.site.list'],
            [
                'meta_title' => $page['title'],
                'meta_description' => $page['description'],
                'skip_title_template' => true,
                'robots_index' => false,
                'robots_follow' => true,
                'exclude_from_sitemap' => true,
            ]
        );

        DB::table('seo_settings')
            ->where(fn ($query) => $query->whereNull('ga4_id')->orWhere('ga4_id', ''))
            ->update(['ga4_id' => 'G-H76CYYJE3S']);
    }

    public function down(): void
    {
        //
    }
};
