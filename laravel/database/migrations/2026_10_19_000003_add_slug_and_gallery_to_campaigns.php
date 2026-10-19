<?php

use App\Models\Campaign;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Case-study pages: every campaign gets a slug (/projects/{slug}), a SEO row
 * and an optional gallery (JSON list of {path, alt}). Existing campaigns are
 * backfilled; their text and images are not touched.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('campaigns', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('campaigns', 'gallery')) {
                $table->json('gallery')->nullable()->after('image');
            }
        });

        Campaign::withTrashed()->orderBy('created_at')->get()->each(function (Campaign $campaign) {
            if (!$campaign->slug) {
                $campaign->slug = Campaign::uniqueSlug($campaign->name, $campaign->city, $campaign->id);
                $campaign->saveQuietly();
            }
            if (!$campaign->seo()->exists()) {
                $campaign->seo()->create([]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'gallery']);
        });
    }
};
