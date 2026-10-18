<?php

namespace App\Traits;

use App\Models\SeoMeta;

trait HasSeoMeta
{
    function seo()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
