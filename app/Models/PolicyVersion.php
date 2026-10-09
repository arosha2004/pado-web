<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyVersion extends Model
{
    protected $fillable = [
        'policy_id',
        'version_label',
        'purpose',
        'scope',
        'content',
        'effective_date',
        'review_date',
        'change_summary',
        'state',
        'published_by',
        'published_at',
        'locked',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'review_date' => 'date',
        'published_at' => 'datetime',
        'locked' => 'boolean',
    ];

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }
}
