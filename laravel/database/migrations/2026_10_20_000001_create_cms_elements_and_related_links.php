<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Page-content CMS storage.
 *
 *  - cms_elements: per-page overrides for headings (H1-H6 level and text) and
 *    paragraphs found in the page body. Rows exist only for elements an editor
 *    actually changed; everything else keeps the text written in the template.
 *  - seo_meta.related_links: editable "related pages" internal links per page.
 *    (The editable body text of a page is the existing seo_meta.page_copy.)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_elements', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('seo_meta_id')->references('id')->on('seo_meta')->cascadeOnDelete();
            $table->string('element_key', 40);
            // New heading level (h2-h6) when the editor changed it, else null.
            $table->string('tag', 2)->nullable();
            // New inner HTML (sanitised) when the editor changed the text, else null.
            $table->text('content')->nullable();
            // Text of the element as the template had it when the override was saved.
            $table->text('original')->nullable();
            $table->timestamps();

            $table->unique(['seo_meta_id', 'element_key']);
        });

        if (!Schema::hasColumn('seo_meta', 'related_links')) {
            Schema::table('seo_meta', function (Blueprint $table) {
                $table->text('related_links')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_elements');

        if (Schema::hasColumn('seo_meta', 'related_links')) {
            Schema::table('seo_meta', function (Blueprint $table) {
                $table->dropColumn('related_links');
            });
        }
    }
};
