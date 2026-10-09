<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = ['assignment_id', 'quiz_version_id', 'ordinal', 'submission_key', 'score', 'passed', 'submitted_at'];

    protected $casts = ['submitted_at' => 'datetime', 'passed' => 'boolean'];
}
