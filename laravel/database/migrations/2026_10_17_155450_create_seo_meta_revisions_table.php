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
        Schema::create('seo_meta_revisions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('seo_meta_id')->references('id')->on('seo_meta')->cascadeOnDelete();
            $table->foreignUuid('admin_id')->nullable()->references('id')->on('admins')->nullOnDelete();
            $table->longText('snapshot_json');
            $table->timestamps();

            $table->index('seo_meta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_meta_revisions');
    }
};
