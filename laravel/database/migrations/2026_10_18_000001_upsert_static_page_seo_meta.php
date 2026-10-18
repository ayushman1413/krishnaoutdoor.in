<?php

use App\Enums\Permission as PermissionEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\SeoMeta;
use App\Models\SeoSetting;
use Illuminate\Database\Migrations\Migration;

/**
 * Data migration: writes the approved SEO title/description for every
 * static page (config/seo_pages.php) into seo_meta.
 *
 * Production only ever runs `php artisan migrate --force` (deploy.sh,
 * deploy-migrate.php) and never `db:seed`, so before this migration the
 * seo_meta table was empty in production and every page fell back to the
 * bare site name with no description. Running it again is harmless: it
 * upserts by route_name.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (config('seo_pages') as $routeName => $page) {
            SeoMeta::updateOrCreate(
                ['route_name' => $routeName],
                [
                    'meta_title' => $page['title'],
                    'meta_description' => $page['description'],
                    // Titles above are already complete ("... | Krishna Outdoor"
                    // where wanted), so the "{page_title} | {site_name}" template
                    // must not be applied on top of them.
                    'skip_title_template' => true,
                ]
            );
        }

        SeoSetting::firstOrCreate([], [
            'site_name' => 'Krishna Outdoor',
            'title_template' => '{page_title} | {site_name}',
            'robots_txt' => "User-agent: *\nDisallow: /cgi-bin/\nSitemap: https://krishnaoutdoor.in/sitemap.xml\n",
        ]);

        // The SEO permissions were also only ever created by PermissionSeeder.
        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate(['name' => $permission->value, 'guard_name' => 'admin']);
        }

        $seoPermissions = ['VIEW_SEO', 'ADD_SEO', 'EDIT_SEO', 'DELETE_SEO', 'MANAGE_REDIRECTS'];
        Role::where('guard_name', 'admin')->where('name', 'Administrator')->get()
            ->each(fn (Role $role) => $role->givePermissionTo($seoPermissions));

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    public function down(): void
    {
        // Data only; nothing to roll back structurally.
    }
};
