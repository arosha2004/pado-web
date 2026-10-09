<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'severity', 'status', 'assigned_manager_id', 'resolved_at', 'resolution_note'];

    protected $casts = ['resolved_at' => 'datetime'];
}
