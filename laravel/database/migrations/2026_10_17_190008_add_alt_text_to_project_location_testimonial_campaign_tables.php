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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('thumbnail_image_alt')->nullable()->after('thumbnail_image');
            $table->string('cover_image_alt')->nullable()->after('cover_image');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->string('image_alt')->nullable()->after('image');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('company_logo_alt')->nullable()->after('company_logo');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('image_alt')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['thumbnail_image_alt', 'cover_image_alt']);
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('image_alt');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('company_logo_alt');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('image_alt');
        });
    }
};
