@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman')
@section('header', 'Riwayat Peminjaman Saya')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Daftar Peminjaman</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($peminjamans as $index => $peminjaman)
                <tr>
                    <td class="px-6 py-4">{{ $peminjamans->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->alat->nama_alat }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->jumlah_pinjam }} unit</td>
                    <td class="px-6 py-4">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->tanggal_kembali_rencana->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        @if($peminjaman->status_persetujuan == 'menunggu')
                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">
                                Menunggu Persetujuan
                            </span>
                        @elseif($peminjaman->status_persetujuan == 'ditolak')
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">
                                Ditolak
                            </span>
                        @elseif($peminjaman->status == 'dipinjam')
                            <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                                Sedang Dipinjam
                            </span>
                        @elseif($peminjaman->status == 'dikembalikan')
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">
                                Selesai
                            </span>
                        @elseif($peminjaman->status == 'terlambat')
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">
                                Terlambat
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('peminjam.peminjamans.show', $peminjaman) }}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Belum ada riwayat peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4">
        {{ $peminjamans->links() }}
    </div>
</div>
@endsection