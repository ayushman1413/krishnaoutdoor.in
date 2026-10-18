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
