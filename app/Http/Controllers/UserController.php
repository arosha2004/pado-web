<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('branch')->latest()->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::all();

        return view('users.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'job_group' => 'nullable|string',
            'branch_id' => 'nullable|exists:branches,id',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'job_group' => $request->job_group,
            'branch_id' => $request->branch_id,
            'status' => 'active',
            'session_version' => 1,
        ]);

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        $branches = Branch::all();

        return view('users.edit', compact('user', 'branches'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'job_group' => 'nullable|string',
            'branch_id' => 'nullable|exists:branches,id',
            'status' => 'required|string',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function deactivate(Request $request, User $user)
    {
        $request->validate(['reason' => 'required|string|max:255']);
        $user->update([
            'status' => 'inactive',
            'deactivation_reason' => $request->reason,
            'session_version' => $user->session_version + 1,
        ]);

        return back()->with('success', 'User deactivated.');
    }

    public function reactivate(User $user)
    {
        $user->update([
            'status' => 'active',
            'deactivation_reason' => null,
        ]);

        return back()->with('success', 'User reactivated.');
    }
}
