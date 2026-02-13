@extends('layouts.petugas')

@section('title', 'Manajemen Denda Pengembalian')
@section('header', 'Manajemen Denda - Verifikasi Pembayaran')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">Denda Pengembalian Menunggu Pembayaran</h3>
                <p class="text-gray-600 text-sm mt-1">Tandai sebagai dibayar setelah peminjam melunasi denda</p>
            </div>
            <a href="{{ route('petugas.pengembalians.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominal Denda</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
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
                    <td class="px-6 py-4">
                        <p class="font-semibold">{{ $pengembalian->peminjaman->alat->nama_alat }}</p>
                        <p class="text-gray-600 text-xs">{{ $pengembalian->jumlah_kembali }} unit</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $pengembalian->kondisi == 'baik' ? 'bg-green-100 text-green-800' : 
                               ($pengembalian->kondisi == 'rusak_ringan' ? 'bg-yellow-100 text-yellow-800' : 
                               ($pengembalian->kondisi == 'rusak_berat' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst(str_replace('_', ' ', $pengembalian->kondisi)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-lg font-bold text-red-600">Rp {{ number_format($pengembalian->denda_final, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        {{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                            <i class="fas fa-clock mr-1"></i>Belum Dibayar
                        </span>
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <form action="{{ route('petugas.pengembalians.markAsPaid', $pengembalian) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm"
                                onclick="return confirm('Tandai denda ini sebagai sudah dibayar?')">
                                <i class="fas fa-check-circle mr-1"></i>Bayar Lunas
                            </button>
                        </form>
                        <a href="{{ route('petugas.pengembalians.show', $pengembalian) }}" 
                           class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                            <i class="fas fa-eye mr-1"></i>Detail
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
        <p class="text-gray-600 text-lg">Tidak ada denda yang menunggu pembayaran</p>
        <p class="text-gray-500 text-sm mt-2">Semua denda sudah dilunasi! 🎉</p>
    </div>
    @endif
</div>
@endsection
