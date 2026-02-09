@extends('layouts.petugas')

@section('title', 'Laporan Stok Alat')
@section('header', 'Laporan Stok Alat')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold">Stok Alat Saat Ini</h3>
        <div class="space-x-2">
            <a href="{{ route('petugas.laporan.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-print mr-2"></i>Cetak
            </button>
        </div>
    </div>
    
    <!-- Ringkasan -->
    <div class="grid grid-cols-3 gap-4 p-6 bg-gray-50">
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Total Alat</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalAlat }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Tersedia</p>
            <p class="text-2xl font-bold text-green-600">{{ $totalTersedia }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Dipinjam</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $totalDipinjam }}</p>
        </div>
    </div>
    
    <!-- Tabel Detail -->
    <div class="overflow-x-auto p-6">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left border">No</th>
                    <th class="px-4 py-3 text-left border">Nama Alat</th>
                    <th class="px-4 py-3 text-left border">Kategori</th>
                    <th class="px-4 py-3 text-center border">Total</th>
                    <th class="px-4 py-3 text-center border">Tersedia</th>
                    <th class="px-4 py-3 text-center border">Dipinjam</th>
                    <th class="px-4 py-3 text-center border">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alats as $index => $alat)
                <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="px-4 py-3 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 border font-medium">{{ $alat->nama_alat }}</td>
                    <td class="px-4 py-3 border">{{ $alat->kategori->nama_kategori }}</td>
                    <td class="px-4 py-3 border text-center">{{ $alat->jumlah_total }}</td>
                    <td class="px-4 py-3 border text-center text-green-600 font-semibold">{{ $alat->jumlah_tersedia }}</td>
                    <td class="px-4 py-3 border text-center text-yellow-600 font-semibold">
                        {{ $alat->jumlah_total - $alat->jumlah_tersedia }}
                    </td>
                    <td class="px-4 py-3 border text-center">
                        <span class="px-2 py-1 text-xs rounded 
                            {{ $alat->status == 'tersedia' ? 'bg-green-100 text-green-800' : 
                               ($alat->status == 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 
                               ($alat->status == 'rusak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst($alat->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-100 font-bold">
                <tr>
                    <td colspan="3" class="px-4 py-3 border text-right">TOTAL</td>
                    <td class="px-4 py-3 border text-center">{{ $totalAlat }}</td>
                    <td class="px-4 py-3 border text-center text-green-600">{{ $totalTersedia }}</td>
                    <td class="px-4 py-3 border text-center text-yellow-600">{{ $totalDipinjam }}</td>
                    <td class="px-4 py-3 border"></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <!-- Footer -->
    <div class="p-6 border-t text-sm text-gray-500">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Oleh: {{ auth()->user()->name }}</p>
    </div>
</div>

<style>
@media print {
    .bg-gray-50 { background-color: #f9fafb !important; -webkit-print-color-adjust: exact; }
    .bg-gray-100 { background-color: #f3f4f6 !important; -webkit-print-color-adjust: exact; }
    .bg-green-100 { background-color: #d1fae5 !important; -webkit-print-color-adjust: exact; }
    .bg-yellow-100 { background-color: #fef3c7 !important; -webkit-print-color-adjust: exact; }
    .bg-red-100 { background-color: #fee2e2 !important; -webkit-print-color-adjust: exact; }
    button, a { display: none !important; }
}
</style>
@endsection 