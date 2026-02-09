@extends('layouts.admin')

@section('title', 'Log Aktivitas')
@section('header', 'Log Aktivitas')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Riwayat Aktivitas Sistem</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Model</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perubahan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr>
                    <td class="px-6 py-4 text-sm">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td class="px-6 py-4 text-sm">{{ $log->user?->name ?? 'System' }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 text-xs rounded 
                            {{ $log->action == 'created' ? 'bg-green-100 text-green-800' : 
                               ($log->action == 'updated' ? 'bg-yellow-100 text-yellow-800' : 
                               ($log->action == 'deleted' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst($log->action) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ class_basename($log->model_type) }} #{{ $log->model_id }}</td>
                    <td class="px-6 py-4 text-sm">{{ $log->description }}</td>
                    <td class="px-6 py-4 text-sm">
                        @if($log->old_data || $log->new_data)
                            <details>
                                <summary class="cursor-pointer text-blue-600 hover:text-blue-800">Lihat Detail</summary>
                                <div class="mt-2 text-xs bg-gray-100 p-2 rounded max-w-xs">
                                    @if($log->old_data)
                                        <p class="font-semibold text-red-600">Data Lama:</p>
                                        <pre class="whitespace-pre-wrap">{{ json_encode($log->old_data, JSON_PRETTY_PRINT) }}</pre>
                                    @endif
                                    @if($log->new_data)
                                        <p class="font-semibold text-green-600 mt-2">Data Baru:</p>
                                        <pre class="whitespace-pre-wrap">{{ json_encode($log->new_data, JSON_PRETTY_PRINT) }}</pre>
                                    @endif
                                </div>
                            </details>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada aktivitas tercatat</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4">
        {{ $logs->links() }}
    </div>
</div>
@endsection