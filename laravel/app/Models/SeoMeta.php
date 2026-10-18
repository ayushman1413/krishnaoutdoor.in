<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'seo_meta';

    protected $guarded = [];

    function seoable()
    {
        return $this->morphTo();
    }
}
