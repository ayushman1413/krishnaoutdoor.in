<?php

use App\Models\SeoRedirect;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Old-site URLs that directories and social profiles may still link to get a
 * permanent redirect (editable in Admin > Redirects), and SEO settings gain
 * a description template for pages without a meta description.
 */
return new class extends Migration
{
    private const LEGACY = [
        '/about-us' => '/about',
        '/contact-us' => '/contact',
        '/gallery' => '/projects',
    ];

    public function up(): void
    {
        foreach (self::LEGACY as $old => $new) {
            if (!SeoRedirect::where('old_url', $old)->exists()) {
                SeoRedirect::create(['old_url' => $old, 'new_url' => $new, 'type' => '301', 'status' => true]);
            }
        }

        if (!Schema::hasColumn('seo_settings', 'description_template')) {
            Schema::table('seo_settings', function (Blueprint $table) {
                $table->string('description_template', 300)->nullable();
            });
        }
    }

    public function down(): void
    {
        //
    }
};
