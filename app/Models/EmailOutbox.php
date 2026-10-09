<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailOutbox extends Model
{
    protected $table = 'email_outboxes';

    protected $fillable = ['notification_id', 'recipient_email', 'subject', 'body', 'status', 'attempts', 'error_category', 'next_attempt_at', 'dedup_key'];

    protected $casts = ['next_attempt_at' => 'datetime'];
}
