<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditEvent extends Model
{
    public $timestamps = false;

    protected $fillable = ['actor_user_id', 'action', 'target_type', 'target_id', 'outcome', 'metadata', 'request_id', 'ip', 'prev_hash', 'hash', 'created_at'];

    protected $casts = ['metadata' => 'array', 'created_at' => 'datetime'];
}
