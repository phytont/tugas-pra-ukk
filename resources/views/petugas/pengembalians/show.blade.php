@extends('layouts.petugas')

@section('title', 'Detail Pengembalian')
@section('header', 'Detail Pengembalian')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto p-6">
    <div class="grid grid-cols-2 gap-6 mb-4">
        <div>
            <label class="block text-gray-500 text-sm mb-1">Nama Peminjam</label>
            <p class="text-lg font-semibold">{{ $pengembalian->peminjaman->user->name }}</p>
        </div>
        <div>
            <label class="block text-gray-500 text-sm mb-1">Nama Alat</label>
            <p class="text-lg">{{ $pengembalian->peminjaman->alat->nama_alat }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-4">
        <div>
            <label class="block text-gray-500 text-sm mb-1">Tanggal Kembali</label>
            <p class="text-lg">{{ $pengembalian->tanggal_kembali->format('d/m/Y') }}</p>
        </div>
        <div>
            <label class="block text-gray-500 text-sm mb-1">Jumlah Kembali</label>
            <p class="text-lg">{{ $pengembalian->jumlah_kembali }} unit</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-4">
        <div>
            <label class="block text-gray-500 text-sm mb-1">Kondisi</label>
            <span class="px-3 py-1 rounded-full text-sm 
                {{ $pengembalian->kondisi == 'baik' ? 'bg-green-100 text-green-800' : 
                   ($pengembalian->kondisi == 'rusak_ringan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst(str_replace('_', ' ', $pengembalian->kondisi)) }}
            </span>
        </div>
        <div>
            <label class="block text-gray-500 text-sm mb-1">Total Denda</label>
            <p class="text-2xl font-bold {{ $pengembalian->denda > 0 ? 'text-red-600' : 'text-green-600' }}">
                Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}
            </p>
        </div>
    </div>

    @if($pengembalian->keterangan)
    <div class="mb-6">
        <label class="block text-gray-500 text-sm mb-1">Keterangan</label>
        <p class="text-lg bg-gray-50 p-3 rounded">{{ $pengembalian->keterangan }}</p>
    </div>
    @endif

    <div class="flex justify-between">
        <a href="{{ route('petugas.pengembalians.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
        <a href="{{ route('petugas.pengembalians.edit', $pengembalian) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
            <i class="fas fa-edit mr-2"></i>Edit Denda
        </a>
    </div>
</div>
@endsection