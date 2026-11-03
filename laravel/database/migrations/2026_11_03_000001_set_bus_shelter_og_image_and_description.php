<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('seo_meta')
            ->where('route_name', 'view.keyword.bus.shelter.ahmedabad')
            ->update([
                'og_image' => '/assets/images/ooh/ahmedabad-bus-shelter-og.jpeg',
                'meta_description' => 'Bus shelter advertising in Ahmedabad on 400+ backlit shelters at eye level. Longer viewing time, day and night. Get the free location list with rates.',
            ]);
    }

    public function down(): void
    {
        DB::table('seo_meta')
            ->where('route_name', 'view.keyword.bus.shelter.ahmedabad')
            ->update([
                'og_image' => null,
                'meta_description' => 'Bus shelter advertising in Ahmedabad on 400+ backlit shelters. Eye-level visibility where commuters wait. Check locations and availability today.',
            ]);
    }
};
