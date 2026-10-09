<?php

namespace App\Services;

use App\Models\Acknowledgement;
use App\Models\PolicyAssignment;
use App\Models\PolicyVersion;
use Illuminate\Support\Facades\DB;

class PolicyService
{
    public function acknowledge(int $userId, int $policyVersionId): Acknowledgement
    {
        return DB::transaction(function () use ($userId, $policyVersionId) {
            $existing = Acknowledgement::firstOrNew([
                'user_id' => $userId,
                'policy_version_id' => $policyVersionId,
            ]);

            if (! $existing->exists) {
                $existing->acknowledged_at = now();
                $existing->save();
            }

            PolicyAssignment::updateOrCreate([
                'user_id' => $userId,
                'policy_version_id' => $policyVersionId,
            ], [
                'status' => 'acknowledged',
                'deadline_at' => now()->addDays(30),
            ]);

            return $existing;
        });
    }

    public function policyVersionForUser(int $userId, int $versionId): ?PolicyVersion
    {
        return PolicyVersion::whereKey($versionId)
            ->where(function ($query) use ($userId) {
                $query->where('state', 'published')
                    ->orWhereHas('policy', function ($policyQuery) use ($userId) {
                        $policyQuery->where('owner_id', $userId);
                    });
            })
            ->first();
    }
}
