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
        Schema::table('category_media', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('name');
            $table->string('title_text')->nullable()->after('alt_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_media', function (Blueprint $table) {
            $table->dropColumn(['alt_text', 'title_text']);
        });
    }
};
