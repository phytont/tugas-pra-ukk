@extends('layouts.peminjam')

@section('title', 'Lihat Denda')
@section('header', 'Daftar Denda Saya')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Informasi Denda</h3>
    </div>
    
    <!-- Ringkasan -->
    <div class="grid grid-cols-3 gap-4 p-6 bg-gray-50">
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Total Denda</p>
            <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Sudah Dibayar</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($sudahDibayar, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Belum Dibayar</p>
            <p class="text-2xl font-bold text-yellow-600">Rp {{ number_format($belumDibayar, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <!-- Detail Denda -->
    <div class="overflow-x-auto p-6">
        <h4 class="font-semibold mb-4">Detail Denda per Peminjaman</h4>
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left border">No</th>
                    <th class="px-4 py-3 text-left border">Alat</th>
                    <th class="px-4 py-3 text-left border">Tgl Kembali</th>
                    <th class="px-4 py-3 text-left border">Kondisi</th>
                    <th class="px-4 py-3 text-right border">Denda</th>
                    <th class="px-4 py-3 text-center border">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengembalians as $index => $p)
                <tr>
                    <td class="px-4 py-3 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 border">{{ $p->peminjaman->alat->nama_alat }}</td>
                    <td class="px-4 py-3 border">{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 border">
                        <span class="px-2 py-1 text-xs rounded 
                            {{ $p->kondisi == 'baik' ? 'bg-green-100 text-green-800' : 
                               ($p->kondisi == 'rusak_ringan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $p->kondisi)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 border text-right font-bold text-red-600">
                        Rp {{ number_format($p->denda, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 border text-center">
                        <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">
                            Belum Lunas
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                        <i class="fas fa-check-circle text-green-500 text-4xl mb-2"></i>
                        <p>Anda tidak memiliki denda. Terima kasih telah mengembalikan alat tepat waktu!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection