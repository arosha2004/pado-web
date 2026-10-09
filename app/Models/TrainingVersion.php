<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingVersion extends Model
{
    protected $fillable = ['module_id', 'title', 'topic', 'objective', 'job_group_target', 'duration_minutes', 'linked_policy_version_id', 'state', 'published_at'];

    public function module()
    {
        return $this->belongsTo(TrainingModule::class, 'module_id');
    }

    public function sections()
    {
        return $this->hasMany(TrainingSection::class);
    }

    public function quiz()
    {
        return $this->hasOne(QuizVersion::class);
    }
}
