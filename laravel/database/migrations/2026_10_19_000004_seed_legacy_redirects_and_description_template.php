<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * SEO settings gain a description template for pages without a meta description.
 */
return new class extends Migration
{
    public function up(): void
    {
        // No redirects are seeded: add /about-us, /contact-us, /gallery etc. in
        // Admin > Redirects only when they show up in the 404 log or Search Console.

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
