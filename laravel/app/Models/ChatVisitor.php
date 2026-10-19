<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ChatVisitor extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected $casts = [
        'profile' => 'array',
        'state' => 'array',
        'lead_saved' => 'boolean',
        'last_seen_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->orderBy('id');
    }
}
