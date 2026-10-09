<?php

namespace App\Services;

use App\Models\AuditEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuditService
{
    public function record(string $action, string $outcome = 'success', ?string $targetType = null, mixed $targetId = null, array $metadata = [], ?string $requestId = null): void
    {
        DB::transaction(function () use ($action, $outcome, $targetType, $targetId, $metadata, $requestId) {
            $previous = AuditEvent::query()->latest('id')->first();
            $requestId ??= (string) Str::uuid();
            $payload = json_encode([
                'actor_user_id' => auth()->id(),
                'action' => $action,
                'target_type' => $targetType,
                'target_id' => $targetId,
                'outcome' => $outcome,
                'metadata' => $metadata,
                'request_id' => $requestId,
                'ip' => request()->ip(),
                'created_at' => now()->toDateTimeString(),
            ], JSON_THROW_ON_ERROR);

            $hash = hash('sha256', ($previous?->hash ?? '') . $payload);

            AuditEvent::create([
                'actor_user_id' => auth()->id(),
                'action' => $action,
                'target_type' => $targetType,
                'target_id' => $targetId,
                'outcome' => $outcome,
                'metadata' => $metadata,
                'request_id' => $requestId,
                'ip' => request()->ip(),
                'prev_hash' => $previous?->hash,
                'hash' => $hash,
                'created_at' => now(),
            ]);
        });
    }
}
