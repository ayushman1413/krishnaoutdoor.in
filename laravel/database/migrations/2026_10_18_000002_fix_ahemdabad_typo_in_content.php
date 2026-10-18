<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Data migration: "Ahemdabad" -> "Ahmedabad" in admin-managed content
 * (e.g. the Torrent Power campaign card text and image alt on /projects).
 * The typo does not exist anywhere in the code, only in these tables.
 *
 * Values that are file paths are skipped so stored image URLs keep working.
 */
return new class extends Migration
{
    private const TABLES = [
        'campaigns', 'projects', 'categories', 'category_media',
        'locations', 'testimonials', 'seo_meta', 'careers',
    ];

    private const REPLACEMENTS = [
        'Ahemdabad' => 'Ahmedabad',
        'AHEMDABAD' => 'AHMEDABAD',
        'ahemdabad' => 'ahmedabad',
    ];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'id')) {
                continue;
            }

            $columns = array_diff(Schema::getColumnListing($table), ['id', 'created_at', 'updated_at', 'deleted_at']);

            foreach ($columns as $column) {
                DB::table($table)
                    ->where($column, 'like', '%hemdabad%')
                    ->get(['id', $column])
                    ->each(function ($row) use ($table, $column) {
                        $value = (string) $row->{$column};
                        if (preg_match('/\.(webp|png|jpe?g|gif|svg|mp4|webm|pdf)$/i', $value)) {
                            return;
                        }
                        DB::table($table)->where('id', $row->id)->update([
                            $column => strtr($value, self::REPLACEMENTS),
                        ]);
                    });
            }
        }
    }

    public function down(): void
    {
        // Typo fix; not reversible on purpose.
    }
};
