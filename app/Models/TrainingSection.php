<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSection extends Model
{
    protected $fillable = ['training_version_id', 'order', 'title', 'content', 'key_reminders', 'resource_url'];

    public function version()
    {
        return $this->belongsTo(TrainingVersion::class, 'training_version_id');
    }
}
