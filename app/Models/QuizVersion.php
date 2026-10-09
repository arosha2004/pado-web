<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizVersion extends Model
{
    protected $fillable = ['training_version_id', 'title', 'pass_threshold', 'max_attempts', 'state', 'published_at'];

    protected $casts = ['published_at' => 'datetime'];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }
}
