<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** A heading or paragraph of a public page that an editor changed. See App\Services\Cms\Cms. */
class CmsElement extends Model
{
    protected $guarded = [];

    public function seoMeta()
    {
        return $this->belongsTo(SeoMeta::class);
    }
}
