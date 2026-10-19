<?php

use App\Models\SeoMeta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Location pages may only be indexed when they carry real inventory (see
 * App\Services\LocationPageGate): this adds the two fields the gate needs
 * (a per-site size and ~300 words of unique page copy) and takes the
 * Bhavnagar test page out of the index and the sitemap, removing its test
 * data. Idempotent, so it is safe to re-run.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('locations', 'size')) {
            Schema::table('locations', function (Blueprint $table) {
                $table->string('size')->nullable()->after('area');
            });
        }

        if (!Schema::hasColumn('seo_meta', 'page_copy')) {
            Schema::table('seo_meta', function (Blueprint $table) {
                $table->text('page_copy')->nullable();
            });
        }

        $bhavnagar = fn () => DB::table('locations')->whereRaw('LOWER(city) = ?', ['bhavnagar']);

        // Test listing: soft-deleted, so it can be restored from the database.
        $bhavnagar()->whereNull('deleted_at')
            ->whereRaw('LOWER(name) LIKE ?', ['%zappdeal%'])
            ->update(['deleted_at' => now()]);

        // Placeholder values typed in while testing the admin form.
        $bhavnagar()->whereRaw('LOWER(TRIM(area)) = ?', ['w'])->update(['area' => null]);
        $bhavnagar()->where('image', 'like', '%bot-icon%')->update(['image' => null]);

        SeoMeta::updateOrCreate(
            ['route_name' => 'view.locations.city.bhavnagar'],
            [
                'meta_title' => 'Bhavnagar Locations',
                'meta_description' => 'Outdoor and transit advertising in Bhavnagar from Krishna Outdoor. Site details will be listed here once available.',
                'robots_index' => false,
                'robots_follow' => true,
                'exclude_from_sitemap' => true,
            ]
        );
    }

    public function down(): void
    {
        //
    }
};
