@extends('layouts.main')

@section('title', 'Activity Logs')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 font-heading">Activity Logs</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau riwayat aktivitas admin dan sistem.</p>
        </div>
    </div>

    <x-card>
        <form method="GET" action="{{ route('admin.logs.index') }}" class="flex flex-wrap items-center gap-3 mb-6">
            <select name="action" class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none bg-gray-50/50 cursor-pointer">
                <option value="">Semua Aksi</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}" @if(request('action') == $act) selected @endif>{{ ucfirst($act) }}</option>
                @endforeach
            </select>
            
            <input type="date" name="date" value="{{ request('date') }}" class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 outline-none bg-gray-50/50">
            
            <x-button type="submit" variant="primary" class="!py-2.5">Filter</x-button>
            
            @if(request()->hasAny(['action', 'date']))
                <a href="{{ route('admin.logs.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 underline px-2">Reset</a>
            @endif
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider rounded-tl-lg">Waktu</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Deskripsi</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider rounded-tr-lg">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-800">{{ $log->user->name ?? 'Sistem' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider rounded-lg 
                                @if($log->action == 'created') bg-green-50 text-green-600 
                                @elseif($log->action == 'updated') bg-blue-50 text-blue-600 
                                @elseif($log->action == 'deleted') bg-red-50 text-red-600 
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $log->description }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-400 font-mono text-xs">{{ $log->ip_address }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                            <x-empty-state title="Belum ada aktivitas" description="Riwayat log sistem masih kosong." icon="document" />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="mt-6 pt-4 border-t border-gray-50">
            {{ $logs->links() }}
        </div>
        @endif
    </x-card>
</div>
@endsection
