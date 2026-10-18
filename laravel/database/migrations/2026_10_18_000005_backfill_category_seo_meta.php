<?php

use App\Models\Category;
use App\Models\SeoMeta;
use Illuminate\Database\Migrations\Migration;

/**
 * Data migration: give every existing category a SeoMeta row so it can be
 * edited in the SEO panel (new categories get one automatically, see
 * HasSeoMeta).
 */
return new class extends Migration
{
    public function up(): void
    {
        Category::query()->withTrashed()->each(function (Category $category) {
            SeoMeta::firstOrCreate([
                'seoable_type' => Category::class,
                'seoable_id' => $category->id,
            ]);
        });
    }

    public function down(): void
    {
        //
    }
};
