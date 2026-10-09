<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingModule extends Model
{
    protected $fillable = ['title', 'topic', 'objective', 'job_group_target', 'duration_minutes', 'linked_policy_version_id', 'state', 'published_at'];

    public function versions()
    {
        return $this->hasMany(TrainingVersion::class, 'module_id');
    }
}
