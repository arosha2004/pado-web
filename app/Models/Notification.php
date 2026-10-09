<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['recipient_id', 'type', 'title', 'message', 'action_url', 'read_at', 'dedup_key'];

    protected $casts = ['read_at' => 'datetime'];
}
