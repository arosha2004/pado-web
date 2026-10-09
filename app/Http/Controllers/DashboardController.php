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

    public function export(ComplianceService $service)
    {
        $user = auth()->user();
        if ($user->role !== 'admin' && $user->role !== 'manager') {
            abort(403);
        }

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=compliance_report.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $users = \App\Models\User::with(['policyAssignments', 'policyAssignments.policyVersion'])->get();
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['User Name', 'Email', 'Role', 'Status', 'Policies Assigned', 'Policies Acknowledged']);
            
            foreach ($users as $u) {
                $assigned = $u->policyAssignments->count();
                $acknowledged = $u->policyAssignments->where('status', 'acknowledged')->count();
                fputcsv($file, [$u->name, $u->email, $u->role, $u->status, $assigned, $acknowledged]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
