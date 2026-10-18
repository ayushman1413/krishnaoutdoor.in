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
        Schema::create('seo_redirects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('old_url');
            $table->string('new_url');
            $table->string('type')->default('301');
            $table->boolean('status')->default(true);
            $table->unsignedInteger('hit_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('old_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_redirects');
    }
};
