<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Data migration: H1 overrides saved in the SEO panel must not end in a full
 * stop or carry stray "*" emphasis markers. Re-running changes nothing.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('seo_meta')->whereNotNull('h1_override')->get(['id', 'h1_override'])->each(function ($row) {
            $clean = rtrim(trim(str_replace('*', '', $row->h1_override)), ". \t");
            if ($clean !== $row->h1_override) {
                DB::table('seo_meta')->where('id', $row->id)->update(['h1_override' => $clean !== '' ? $clean : null]);
            }
        });
    }

    public function down(): void
    {
        //
    }
};
