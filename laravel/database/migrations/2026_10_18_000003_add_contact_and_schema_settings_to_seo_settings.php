<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo_settings', function (Blueprint $table) {
            // Header/chat WhatsApp link; hidden while empty.
            $table->string('whatsapp_number', 20)->nullable()->after('favicon');
            // Optional overrides for the automatic LocalBusiness schema built
            // from config/business.php. Empty = use the automatic version.
            $table->longText('local_business_ahmedabad_json')->nullable()->after('organization_schema_json');
            $table->longText('local_business_mumbai_json')->nullable()->after('local_business_ahmedabad_json');
        });

        // Site-wide default share image (generated from the home hero poster)
        // when none has been uploaded in SEO settings yet.
        DB::table('seo_settings')
            ->whereNull('default_og_image')
            ->update(['default_og_image' => '/assets/images/og/og-default.jpg']);
    }

    public function down(): void
    {
        Schema::table('seo_settings', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_number', 'local_business_ahmedabad_json', 'local_business_mumbai_json']);
        });
    }
};
