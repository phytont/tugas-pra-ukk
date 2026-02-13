@extends('layouts.petugas')

@section('title', 'Verifikasi Pengembalian')
@section('header', 'Verifikasi Pengembalian Alat')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Pengembalian & Denda</h3>
            <div class="flex gap-2">
                <a href="{{ route('petugas.pengembalians.index') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('petugas.pengembalians.index') ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                    <i class="fas fa-inbox mr-2"></i>Menunggu Verifikasi
                </a>
                <a href="{{ route('petugas.pengembalians.verified') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('petugas.pengembalians.verified') ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                    <i class="fas fa-money-bill mr-2"></i>Manajemen Denda
                </a>
                <a href="{{ route('petugas.pengembalians.create') }}" class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>Input Manual
                </a>
            </div>
        </div>
        <p class="text-gray-600 text-sm">Daftar peminjaman yang sudah disetujui dan peminjam telah mengajukan pengembalian.</p>
    </div>
    
    @if($pengembalians->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pinjam - Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengajuan Pengembalian</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($pengembalians as $index => $peminjaman)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $pengembalians->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold">{{ $peminjaman->user->name }}</p>
                        <p class="text-gray-600 text-xs">{{ $peminjaman->user->email }}</p>
                    </td>
                    <td class="px-6 py-4">{{ $peminjaman->alat->nama_alat }}</td>
                    <td class="px-6 py-4">
                        <span class="text-lg font-bold text-blue-600">{{ $peminjaman->jumlah_pinjam }}</span> unit
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <p>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
                        <p class="text-gray-600">s/d {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d M Y') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($peminjaman->tanggal_pengajuan_pengembalian)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengajuan_pengembalian)->format('d M Y') }}
                            </span>
                        @else
                            <span class="text-gray-500 text-sm">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('petugas.pengembalians.verify', $peminjaman) }}" 
                           class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                            <i class="fas fa-check mr-1"></i>Verifikasi
                        </a>
                    </td>
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
        <i class="fas fa-check-circle text-6xl text-green-400 mb-4"></i>
        <p class="text-gray-600 text-lg">Tidak ada peminjaman yang menunggu verifikasi pengembalian</p>
    </div>
    @endif
</div>
@endsection