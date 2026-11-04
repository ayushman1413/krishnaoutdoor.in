<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('seo_meta')
            ->where('route_name', 'view.keyword.hoarding.ahmedabad')
            ->update([
                'meta_title' => 'Hoarding Advertising Ahmedabad | Outdoor Ads Since 1985',
                'meta_description' => 'Hoarding advertising in Ahmedabad on 300+ own sites, 2000+ across Gujarat. Frontlit, backlit, unipole & gantry. Get the free site list with rates.',
                'og_image' => '/assets/images/ooh/ahmedabad-hoarding-og.jpeg',
                // Empty so the og: and twitter: tags follow the title and description above.
                'og_title' => null,
                'og_description' => null,
                'twitter_title' => null,
                'twitter_description' => null,
            ]);

        DB::table('campaigns')
            ->where('slug', 'torrent-powers-outdoor-billboard-campaign')
            ->update(['image_alt' => 'Torrent Power billboard campaign in Ahmedabad by Krishna Outdoor']);
    }

    public function down(): void
    {
        DB::table('seo_meta')
            ->where('route_name', 'view.keyword.hoarding.ahmedabad')
            ->update([
                'meta_title' => 'Hoarding Advertising in Ahmedabad | 300+ Own Sites',
                'meta_description' => 'Hoarding advertising in Ahmedabad with 300+ own sites and 2000+ across Gujarat. Frontlit, backlit and unipoles on prime roads. Get the free site list.',
                'og_image' => null,
            ]);

        DB::table('campaigns')
            ->where('slug', 'torrent-powers-outdoor-billboard-campaign')
            ->update(['image_alt' => null]);
    }
};
