<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acknowledgement extends Model
{
    protected $fillable = ['user_id', 'policy_version_id', 'acknowledged_at'];

    protected $casts = ['acknowledged_at' => 'datetime'];
}
