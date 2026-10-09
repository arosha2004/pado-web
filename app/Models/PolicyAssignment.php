<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyAssignment extends Model
{
    protected $fillable = ['user_id', 'policy_version_id', 'deadline_at', 'status', 'reason'];

    protected $casts = ['deadline_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function policyVersion()
    {
        return $this->belongsTo(PolicyVersion::class);
    }
}
