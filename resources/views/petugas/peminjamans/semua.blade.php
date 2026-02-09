@extends('layouts.petugas')

@section('title', 'Semua Peminjaman')
@section('header', 'Semua Peminjaman')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold">Daftar Peminjaman Disetujui</h3>
        <a href="{{ route('petugas.peminjamans.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Kembali ke Persetujuan
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Disetujui Oleh</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($peminjamans as $index => $peminjaman)
                <tr>
                    <td class="px-6 py-4">{{ $peminjamans->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->user->name }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->alat->nama_alat }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->jumlah_pinjam }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            {{ $peminjaman->status == 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 
                               ($peminjaman->status == 'dikembalikan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $peminjaman->approvedBy->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('petugas.peminjamans.show', $peminjaman) }}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Belum ada peminjaman yang disetujui
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4">
        {{ $peminjamans->links() }}
    </div>
</div>
@endsection