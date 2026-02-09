@extends('layouts.admin')

@section('title', 'Detail Pengembalian')
@section('header', 'Detail Pengembalian')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto p-6">
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Peminjam</label>
            <p class="text-lg">{{ $pengembalian->peminjaman->user->name }}</p>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Alat</label>
            <p class="text-lg">{{ $pengembalian->peminjaman->alat->nama_alat }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali</label>
            <p class="text-lg">{{ $pengembalian->tanggal_kembali->format('d/m/Y') }}</p>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Kembali</label>
            <p class="text-lg">{{ $pengembalian->jumlah_kembali }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi</label>
            <span class="px-2 py-1 text-xs rounded 
                {{ $pengembalian->kondisi == 'baik' ? 'bg-green-100 text-green-800' : 
                   ($pengembalian->kondisi == 'rusak_ringan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst(str_replace('_', ' ', $pengembalian->kondisi)) }}
            </span>
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2">Denda</label>
            <p class="text-lg font-bold text-red-600">Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
        <p class="text-lg">{{ $pengembalian->keterangan ?? '-' }}</p>
    </div>
    
    <div class="flex justify-end">
        <a href="{{ route('admin.pengembalians.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Kembali</a>
    </div>
</div>
@endsection