@extends('layouts.admin')

@section('title', 'Detail Peminjaman')
@section('header', 'Detail Peminjaman')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto p-6">
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Peminjam</label>
            <p class="text-lg">{{ $peminjaman->user->name }}</p>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Alat</label>
            <p class="text-lg">{{ $peminjaman->alat->nama_alat }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Pinjam</label>
            <p class="text-lg">{{ $peminjaman->jumlah_pinjam }}</p>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <span class="px-2 py-1 text-xs rounded 
                {{ $peminjaman->status == 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 
                   ($peminjaman->status == 'dikembalikan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst($peminjaman->status) }}
            </span>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pinjam</label>
            <p class="text-lg">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</p>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali Rencana</label>
            <p class="text-lg">{{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</p>
        </div>
    </div>
    
    @if($peminjaman->tanggal_kembali_aktual)
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali Aktual</label>
        <p class="text-lg">{{ $peminjaman->tanggal_kembali_aktual->format('d/m/Y') }}</p>
    </div>
    @endif
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
        <p class="text-lg">{{ $peminjaman->keterangan ?? '-' }}</p>
    </div>
    
    @if($peminjaman->pengembalian)
    <div class="border-t pt-4 mt-4">
        <h4 class="font-bold mb-2">Data Pengembalian</h4>
        <p>Tanggal: {{ $peminjaman->pengembalian->tanggal_kembali->format('d/m/Y') }}</p>
        <p>Kondisi: {{ ucfirst($peminjaman->pengembalian->kondisi) }}</p>
        <p>Denda: Rp {{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}</p>
    </div>
    @endif
    
    <div class="flex justify-end mt-6">
        <a href="{{ route('admin.peminjamans.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Kembali</a>
    </div>
</div>
@endsection