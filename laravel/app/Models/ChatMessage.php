<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    public const UPDATED_AT = null;

    protected $guarded = [];

    protected $casts = ['meta' => 'array'];

    protected $table = 'chat_messages';

    protected $foreignKey = 'chat_visitor_id';
}
