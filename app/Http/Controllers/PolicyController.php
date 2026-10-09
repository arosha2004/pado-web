<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\PolicyVersion;
use App\Services\PolicyService;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'employee') {
            $assignedPolicyVersionIds = \App\Models\PolicyAssignment::where('user_id', $user->id)->pluck('policy_version_id');
            $policies = Policy::whereHas('versions', function ($q) use ($assignedPolicyVersionIds) {
                $q->whereIn('id', $assignedPolicyVersionIds);
            })->with(['versions' => function ($q) use ($assignedPolicyVersionIds) {
                $q->whereIn('id', $assignedPolicyVersionIds);
            }])->latest()->get();
        } else {
            $policies = Policy::with('versions')->latest()->get();
        }

        return view('policies.index', compact('policies'));
    }

    public function show(Policy $policy)
    {
        $version = $policy->versions()->latest()->first();

        return view('policies.show', compact('policy', 'version'));
    }

    public function acknowledge(PolicyService $policyService, \App\Services\AuditService $auditService, PolicyVersion $policyVersion)
    {
        $policyService->acknowledge(auth()->id(), $policyVersion->id);
        $auditService->record('policy.acknowledge', 'success', 'PolicyVersion', $policyVersion->id);

        return redirect()->back()->with('success', 'Policy acknowledged.');
    }

    public function create()
    {
        return view('policies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $policy = Policy::create([
            'title' => $request->title,
            'category' => $request->category,
            'owner_id' => auth()->id(),
            'status' => 'active',
        ]);

        $policy->versions()->create([
            'version_label' => '1.0',
            'purpose' => 'Policy publication',
            'scope' => 'Organization',
            'content' => strip_tags($request->content),
            'effective_date' => now()->toDateString(),
            'review_date' => now()->addDays(30)->toDateString(),
            'state' => 'published',
            'published_by' => auth()->id(),
            'published_at' => now(),
        ]);

        return redirect()->route('policies.index')->with('success', 'Policy created.');
    }

    public function archive(Policy $policy)
    {
        $user = auth()->user();
        if ($user->role === 'employee') {
            abort(403);
        }
        
        $policy->update(['status' => 'archived']);
        $policy->versions()->update(['state' => 'archived']);
        
        return redirect()->route('policies.index')->with('success', 'Policy archived.');
    }
}
