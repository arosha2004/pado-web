@extends('layouts.app')

@section('title', 'Create Policy')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 max-w-3xl mx-auto">
    <form action="{{ route('policies.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input type="text" name="title" class="w-full rounded border border-slate-300 px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Category</label>
            <input type="text" name="category" class="w-full rounded border border-slate-300 px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Content</label>
            <textarea name="content" rows="8" class="w-full rounded border border-slate-300 px-3 py-2" required></textarea>
        </div>
        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">Save Policy</button>
    </form>
</div>
@endsection
