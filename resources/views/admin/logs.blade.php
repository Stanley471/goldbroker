@extends('layouts.admin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-white" style="font-family: 'Playfair Display';">Admin Logs</h1>
    <p class="text-[#A0A0A0] text-sm mt-1">Track all admin actions on the platform</p>
</div>

<div class="bg-[#141414] border border-[#D4AF37]/20 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[#D4AF37]/10">
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Admin</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm">Action</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden sm:table-cell">Target</th>
                    <th class="text-left py-4 px-6 text-[#A0A0A0] font-medium text-sm hidden md:table-cell">Notes</th>
                    <th class="text-right py-4 px-6 text-[#A0A0A0] font-medium text-sm">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr class="border-b border-[#D4AF37]/10 hover:bg-[#D4AF37]/5 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-[#D4AF37]/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#D4AF37] text-xs font-semibold">{{ strtoupper(substr($log->admin->first_name, 0, 1)) }}</span>
                                </div>
                                <span class="text-sm text-white">{{ $log->admin->first_name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-[#A0A0A0]">{{ $log->action }}</td>
                        <td class="py-4 px-6 text-sm text-[#666] hidden sm:table-cell">{{ $log->target_type }} #{{ $log->target_id }}</td>
                        <td class="py-4 px-6 text-sm text-[#666] hidden md:table-cell">{{ $log->notes ?? '--' }}</td>
                        <td class="py-4 px-6 text-sm text-right text-[#666]">{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-10 text-[#666]">No logs yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-[#D4AF37]/10">
        {{ $logs->links() }}
    </div>
</div>

@endsection