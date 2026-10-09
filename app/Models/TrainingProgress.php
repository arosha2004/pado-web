<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingProgress extends Model
{
    protected $fillable = ['assignment_id', 'section_id', 'completed_at'];

    protected $casts = ['completed_at' => 'datetime'];
}
