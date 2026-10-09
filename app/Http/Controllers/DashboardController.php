<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\PolicyAssignment;
use App\Models\TrainingAssignment;
use App\Services\ComplianceService;

class DashboardController extends Controller
{
    public function index(ComplianceService $service)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $stats = $service->dashboard();
            $unread = Notification::where('recipient_id', $user->id)->whereNull('read_at')->count();

            return view('dashboard.index', compact('stats', 'unread'));
        }

        $policies = PolicyAssignment::with('policyVersion.policy')->where('user_id', $user->id)->latest()->limit(5)->get();
        $trainings = TrainingAssignment::where('user_id', $user->id)->latest()->limit(5)->get();

        return view('dashboard.index', [
            'policies' => $policies,
            'trainings' => $trainings,
            'compliance' => $service->myCompliance($user->id),
        ]);
    }
}
