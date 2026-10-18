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
        Schema::create('seo_404_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('url');
            $table->string('referrer')->nullable();
            $table->string('user_agent')->nullable();
            $table->unsignedInteger('hit_count')->default(1);
            $table->timestamp('last_seen_at')->nullable();
            $table->boolean('resolved')->default(false);
            $table->timestamps();

            $table->unique('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_404_logs');
    }
};
