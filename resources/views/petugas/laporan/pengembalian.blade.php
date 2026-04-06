@extends('layouts.petugas')

@section('title', 'Laporan Pengembalian')
@section('header', 'Laporan Pengembalian')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold">Laporan Pengembalian</h3>
            <p class="text-sm text-gray-500">Periode: {{ \Carbon\Carbon::parse($request->dari_tanggal)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($request->sampai_tanggal)->format('d/m/Y') }}</p>
        </div>
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
    <div class="grid grid-cols-4 gap-4 p-6 bg-gray-50">
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Total</p>
            <p class="text-2xl font-bold text-blue-600">{{ $total }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Tepat Waktu</p>
            <p class="text-2xl font-bold text-green-600">{{ $tepatWaktu }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Terlambat</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $terlambat }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Total Denda</p>
            <p class="text-2xl font-bold text-red-600">Rp. {{ number_format($totalDenda, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <!-- Tabel Detail -->
    <div class="overflow-x-auto p-6">
        @if($pengembalians->count() > 0)
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left border">No</th>
                    <th class="px-4 py-3 text-left border">Peminjam</th>
                    <th class="px-4 py-3 text-left border">Alat</th>
                    <th class="px-4 py-3 text-center border">Jumlah</th>
                    <th class="px-4 py-3 text-left border">Kondisi</th>
                    <th class="px-4 py-3 text-left border">Tgl Kembali</th>
                    <th class="px-4 py-3 text-center border">Denda</th>
                    <th class="px-4 py-3 text-center border">Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengembalians as $index => $pengembalian)
                <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="px-4 py-3 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 border font-medium">{{ $pengembalian->peminjaman->user->name }}</td>
                    <td class="px-4 py-3 border">{{ $pengembalian->peminjaman->alat->nama_alat }}</td>
                    <td class="px-4 py-3 border text-center">{{ $pengembalian->jumlah_kembali }}</td>
                    <td class="px-4 py-3 border">
                        <span class="px-2 py-1 text-xs rounded font-semibold
                            {{ $pengembalian->kondisi == 'baik' ? 'bg-green-100 text-green-800' : 
                               ($pengembalian->kondisi == 'rusak_ringan' ? 'bg-yellow-100 text-yellow-800' : 
                               ($pengembalian->kondisi == 'rusak_berat' ? 'bg-orange-100 text-orange-800' : 
                               'bg-red-100 text-red-800')) }}">
                            {{ ucfirst(str_replace('_', ' ', $pengembalian->kondisi)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 border">{{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 border text-center font-semibold">
                        {{ $pengembalian->denda > 0 ? 'Rp. ' . number_format($pengembalian->denda, 0, ',', '.') : '-' }}
                    </td>
                    <td class="px-4 py-3 border text-center">
                        <span class="px-2 py-1 text-xs rounded font-semibold
                            {{ $pengembalian->status_pembayaran == 'sudah_bayar' ? 'bg-green-100 text-green-800' : 
                               'bg-yellow-100 text-yellow-800' }}">
                            {{ $pengembalian->status_pembayaran == 'sudah_bayar' ? 'Sudah Bayar' : 'Belum Bayar' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-100 font-bold">
                <tr>
                    <td colspan="5" class="px-4 py-3 border text-right">TOTAL</td>
                    <td class="px-4 py-3 border text-right">
                        {{ $pengembalians->sum('jumlah_kembali') }} unit
                    </td>
                    <td class="px-4 py-3 border text-center text-red-600">
                        Rp. {{ number_format($totalDenda, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 border"></td>
                </tr>
            </tfoot>
        </table>
        @else
        <div class="text-center py-8">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Tidak ada data pengembalian untuk periode ini</p>
        </div>
        @endif
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
    .bg-orange-100 { background-color: #fed7aa !important; -webkit-print-color-adjust: exact; }
    .bg-red-100 { background-color: #fee2e2 !important; -webkit-print-color-adjust: exact; }
    button, a { display: none !important; }
}
</style>
@endsection
