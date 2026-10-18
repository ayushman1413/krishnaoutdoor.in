<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('site_name')->default('Krishna Outdoor');
            $table->string('title_template')->default('{page_title} | {site_name}');
            $table->string('default_og_image')->nullable();
            $table->string('favicon')->nullable();

            $table->text('gsc_verification_code')->nullable();
            $table->string('ga4_id')->nullable();
            $table->string('gtm_id')->nullable();
            $table->longText('fb_pixel_code')->nullable();

            $table->longText('head_custom_code')->nullable();
            $table->longText('body_custom_code')->nullable();

            $table->longText('organization_schema_json')->nullable();
            $table->longText('robots_txt')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
};
