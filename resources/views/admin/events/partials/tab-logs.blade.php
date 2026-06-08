{{-- Logs Tab Content --}}
<div class="space-y-6">
    <div>
        <h3 class="text-lg font-semibold font-heading text-gray-800">Riwayat Aktivitas Event</h3>
        <p class="text-sm text-gray-500 mt-1">Audit log aktivitas fasilitator dan admin pada event ini.</p>
    </div>

    <div class="bg-white border border-gray-150 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider rounded-tl-lg">Waktu</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider rounded-tr-lg">Detail Perubahan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($eventLogs as $log)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">{{ $log->user->name ?? 'Sistem' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize text-gray-600">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 border border-gray-200">
                                {{ $log->role_user ?? ($log->user->role ?? '-') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider rounded-lg 
                                @if($log->action == 'created') bg-green-50 text-green-600 
                                @elseif($log->action == 'updated') bg-blue-50 text-blue-600 
                                @elseif($log->action == 'deleted') bg-red-50 text-red-600 
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $log->description }}</td>
                        <td class="px-6 py-4 text-xs">
                            @if($log->old_values || $log->new_values)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 max-h-48 overflow-y-auto font-mono text-[11px] space-y-2">
                                    @if($log->old_values)
                                        <div>
                                            <span class="text-red-600 font-semibold">Sebelum:</span>
                                            <pre class="whitespace-pre-wrap">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        </div>
                                    @endif
                                    @if($log->new_values)
                                        <div class="border-t border-gray-200/60 pt-2">
                                            <span class="text-green-600 font-semibold">Sesudah:</span>
                                            <pre class="whitespace-pre-wrap">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400 font-italic">Tidak ada data detail</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <x-empty-state title="Belum ada aktivitas" description="Aktivitas audit log event ini masih kosong." icon="document" />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
