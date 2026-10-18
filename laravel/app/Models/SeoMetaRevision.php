<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoMetaRevision extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'seo_meta_revisions';

    protected $guarded = [];

    protected $casts = [
        'snapshot_json' => 'array',
    ];

    function seoMeta()
    {
        return $this->belongsTo(SeoMeta::class, 'seo_meta_id');
    }

    function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
