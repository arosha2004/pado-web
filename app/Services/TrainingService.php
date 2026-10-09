<?php

namespace App\Services;

use App\Models\TrainingAssignment;
use App\Models\TrainingProgress;
use Illuminate\Support\Facades\DB;

class TrainingService
{
    public function markSectionComplete(int $assignmentId, int $sectionId): TrainingProgress
    {
        return DB::transaction(function () use ($assignmentId, $sectionId) {
            $progress = TrainingProgress::firstOrCreate([
                'assignment_id' => $assignmentId,
                'section_id' => $sectionId,
            ], [
                'completed_at' => now(),
            ]);

            $assignment = TrainingAssignment::findOrFail($assignmentId);
            $assignment->status = 'in_progress';
            $assignment->save();

            return $progress;
        });
    }
}
