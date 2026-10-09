<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = ['quiz_version_id', 'question_text', 'sort_order'];

    public function options()
    {
        return $this->hasMany(QuizOption::class, 'question_id');
    }
}
