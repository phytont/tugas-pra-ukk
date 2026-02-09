@extends('layouts.petugas')

@section('title', 'Detail Peminjaman')
@section('header', 'Detail Peminjaman')

@section('content')
<div class="bg-white rounded-lg shadow max-w-3xl mx-auto p-6">
    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-gray-500 text-sm mb-1">Nama Peminjam</label>
            <p class="text-lg font-semibold">{{ $peminjaman->user->name }}</p>
            <p class="text-gray-500">{{ $peminjaman->user->email }}</p>
        </div>
        <div>
            <label class="block text-gray-500 text-sm mb-1">Status Persetujuan</label>
            <span class="px-3 py-1 rounded-full text-sm 
                {{ $peminjaman->status_persetujuan == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                   ($peminjaman->status_persetujuan == 'disetujui' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst($peminjaman->status_persetujuan) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-gray-500 text-sm mb-1">Nama Alat</label>
            <p class="text-lg">{{ $peminjaman->alat->nama_alat }}</p>
            <p class="text-gray-500">Kategori: {{ $peminjaman->alat->kategori->nama_kategori }}</p>
        </div>
        <div>
            <label class="block text-gray-500 text-sm mb-1">Jumlah Pinjam</label>
            <p class="text-lg">{{ $peminjaman->jumlah_pinjam }} unit</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-gray-500 text-sm mb-1">Tanggal Pinjam</label>
            <p class="text-lg">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</p>
        </div>
        <div>
            <label class="block text-gray-500 text-sm mb-1">Tanggal Kembali Rencana</label>
            <p class="text-lg">{{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</p>
        </div>
    </div>

    @if($peminjaman->approvedBy)
    <div class="grid grid-cols-2 gap-6 mb-6 bg-gray-50 p-4 rounded">
        <div>
            <label class="block text-gray-500 text-sm mb-1">Disetujui/Ditolak Oleh</label>
            <p class="text-lg">{{ $peminjaman->approvedBy->name }}</p>
        </div>
        <div>
            <label class="block text-gray-500 text-sm mb-1">Waktu Persetujuan</label>
            <p class="text-lg">{{ $peminjaman->approved_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    @endif

    @if($peminjaman->keterangan)
    <div class="mb-6">
        <label class="block text-gray-500 text-sm mb-1">Keterangan/Alasan</label>
        <p class="text-lg bg-gray-50 p-3 rounded">{{ $peminjaman->keterangan }}</p>
    </div>
    @endif

    <div class="flex justify-between">
        <a href="{{ url()->previous() }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
        
        @if($peminjaman->status_persetujuan == 'menunggu')
        <div class="space-x-3">
            <form action="{{ route('petugas.peminjamans.tolak', $peminjaman) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    <i class="fas fa-times mr-2"></i>Tolak
                </button>
            </form>
            
            <form action="{{ route('petugas.peminjamans.setuju', $peminjaman) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menyetujui?')">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-check mr-2"></i>Setujui
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection