<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingAssignment extends Model
{
    protected $fillable = ['user_id', 'training_version_id', 'assigned_at', 'deadline_at', 'started_at', 'last_section_id', 'lesson_completed_at', 'status', 'reason', 'actor_id'];

    protected $casts = ['assigned_at' => 'datetime', 'deadline_at' => 'datetime', 'started_at' => 'datetime', 'lesson_completed_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
