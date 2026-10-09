<?php

namespace App\Services;

use App\Models\Acknowledgement;
use App\Models\PolicyAssignment;
use App\Models\TrainingAssignment;
use App\Models\User;

class ComplianceService
{
    public function dashboard(): array
    {
        $activeUsers = User::where('status', 'active')->count();
        $policies = PolicyAssignment::where('status', 'acknowledged')->count();
        $training = TrainingAssignment::where('status', 'completed')->count();

        return [
            'active_users' => $activeUsers,
            'policy_acknowledgements' => $policies,
            'training_completions' => $training,
            'policy_rate' => $activeUsers > 0 ? round(($policies / max(1, $activeUsers)) * 100, 2) : 0,
        ];
    }

    public function myCompliance(int $userId): array
    {
        $acknowledged = Acknowledgement::where('user_id', $userId)->count();
        $assignments = PolicyAssignment::where('user_id', $userId)->count();

        return [
            'acknowledged' => $acknowledged,
            'assignments' => $assignments,
            'rate' => $assignments > 0 ? round(($acknowledged / $assignments) * 100, 2) : 0,
        ];
    }
}
