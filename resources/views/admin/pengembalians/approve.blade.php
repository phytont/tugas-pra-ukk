@extends('layouts.admin')

@section('title', 'Pengembalian Divalidasi')
@section('header', 'Pengembalian Divalidasi')

@section('content')
<div class="mb-4">
    <div class="flex gap-2">
        <a href="{{ route('admin.pengembalians.index') }}" class="px-4 py-2 rounded-lg hover:bg-blue-100 
            {{ request()->routeIs('admin.pengembalians.index') ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
            <i class="fas fa-clock mr-2"></i>Menunggu Validasi
        </a>
        <a href="{{ route('admin.pengembalians.approved') }}" class="px-4 py-2 rounded-lg hover:bg-blue-100
            {{ request()->routeIs('admin.pengembalians.approved') ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
            <i class="fas fa-check-circle mr-2"></i>Sudah Divalidasi
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Pengembalian Sudah Divalidasi</h3>
    </div>
    
    @if($pengembalians->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kondisi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Denda</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diverifikasi Oleh</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Verifikasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($pengembalians as $index => $pengembalian)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $pengembalians->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold">{{ $pengembalian->peminjaman->user->name }}</p>
                        <p class="text-gray-600 text-xs">{{ $pengembalian->peminjaman->user->email }}</p>
                    </td>
                    <td class="px-6 py-4">{{ $pengembalian->peminjaman->alat->nama_alat }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $pengembalian->kondisi == 'rusak' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($pengembalian->kondisi) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-lg font-bold text-red-600">Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $pengembalian->status_denda == 'disetujui' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($pengembalian->status_denda) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $pengembalian->verifiedByAdmin->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $pengembalian->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-6">
        {{ $pengembalians->links() }}
    </div>
    @else
    <div class="p-12 text-center">
        <i class="fas fa-check-circle text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-600 text-lg">Belum ada pengembalian yang divalidasi</p>
    </div>
    @endif
</div>
@endsection