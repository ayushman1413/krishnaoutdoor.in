<?php

namespace App\Models;

use App\Traits\HasSeoMeta;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, HasUuids, SoftDeletes, HasSeoMeta;

    /**
     * Each category gets its own SeoMeta row when it is created, so it shows
     * up in the SEO admin panel without manual setup.
     */
    protected static function booted(): void
    {
        static::created(function (Category $category) {
            if (!$category->seo()->exists()) {
                $category->seo()->create([]);
            }
        });
    }

    function child_categories() {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    function parent_category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    function media() {
        return $this->hasMany(CategoryMedia::class, 'category_id', 'id');
    }

}
