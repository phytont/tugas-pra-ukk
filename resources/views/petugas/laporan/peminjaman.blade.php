@extends('layouts.petugas')

@section('title', 'Laporan Peminjaman')
@section('header', 'Laporan Peminjaman')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold">Laporan Peminjaman</h3>
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
            <p class="text-gray-500 text-sm">Disetujui</p>
            <p class="text-2xl font-bold text-green-600">{{ $disetujui }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Menunggu</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $menunggu }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <p class="text-gray-500 text-sm">Ditolak</p>
            <p class="text-2xl font-bold text-red-600">{{ $ditolak }}</p>
        </div>
    </div>
    
    <!-- Tabel Detail -->
    <div class="overflow-x-auto p-6">
        @if($peminjamans->count() > 0)
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left border">No</th>
                    <th class="px-4 py-3 text-left border">Peminjam</th>
                    <th class="px-4 py-3 text-left border">Alat</th>
                    <th class="px-4 py-3 text-center border">Jumlah</th>
                    <th class="px-4 py-3 text-left border">Tgl Pinjam</th>
                    <th class="px-4 py-3 text-left border">Tgl Kembali</th>
                    <th class="px-4 py-3 text-center border">Status Persetujuan</th>
                    <th class="px-4 py-3 text-left border">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamans as $index => $peminjaman)
                <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="px-4 py-3 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 border font-medium">{{ $peminjaman->user->name }}</td>
                    <td class="px-4 py-3 border">{{ $peminjaman->alat->nama_alat }}</td>
                    <td class="px-4 py-3 border text-center">{{ $peminjaman->jumlah_pinjam }}</td>
                    <td class="px-4 py-3 border">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 border">{{ $peminjaman->tanggal_kembali_rencana ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d/m/Y') : '-' }}</td>
                    <td class="px-4 py-3 border text-center">
                        <span class="px-2 py-1 text-xs rounded font-semibold
                            {{ $peminjaman->status_persetujuan == 'disetujui' ? 'bg-green-100 text-green-800' : 
                               ($peminjaman->status_persetujuan == 'ditolak' ? 'bg-red-100 text-red-800' : 
                               'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($peminjaman->status_persetujuan) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 border">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $peminjaman->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                               ($peminjaman->status == 'terlambat' ? 'bg-red-100 text-red-800' : 
                               'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-8">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Tidak ada data peminjaman untuk periode ini</p>
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
    .bg-red-100 { background-color: #fee2e2 !important; -webkit-print-color-adjust: exact; }
    .bg-blue-100 { background-color: #dbeafe !important; -webkit-print-color-adjust: exact; }
    button, a { display: none !important; }
}
</style>
@endsection
