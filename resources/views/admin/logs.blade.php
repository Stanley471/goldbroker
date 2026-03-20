@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Admin Logs</h1>

<div class="bg-white p-6 rounded shadow">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left border-b">
                <th class="pb-2">Admin</th>
                <th class="pb-2">Action</th>
                <th class="pb-2">Target</th>
                <th class="pb-2">Notes</th>
                <th class="pb-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr class="border-b">
                    <td class="py-2">{{ $log->admin->first_name }} {{ $log->admin->last_name }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->target_type }} #{{ $log->target_id }}</td>
                    <td>{{ $log->notes }}</td>
                    <td>{{ $log->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-gray-500 py-4">No logs yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>

@endsection