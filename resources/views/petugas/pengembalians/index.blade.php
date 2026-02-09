@extends('layouts.petugas')

@section('title', 'Pengembalian')
@section('header', 'Daftar Pengembalian')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold">Riwayat Pengembalian</h3>
        <a href="{{ route('petugas.pengembalians.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i>Input Pengembalian
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kondisi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Denda</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pengembalians as $index => $pengembalian)
                <tr>
                    <td class="px-6 py-4">{{ $pengembalians->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $pengembalian->peminjaman->user->name }}</td>
                    <td class="px-6 py-4">{{ $pengembalian->peminjaman->alat->nama_alat }}</td>
                    <td class="px-6 py-4">{{ $pengembalian->tanggal_kembali->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            {{ $pengembalian->kondisi == 'baik' ? 'bg-green-100 text-green-800' : 
                               ($pengembalian->kondisi == 'rusak_ringan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $pengembalian->kondisi)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold {{ $pengembalian->denda > 0 ? 'text-red-600' : 'text-green-600' }}">
                        Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('petugas.pengembalians.show', $pengembalian) }}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('petugas.pengembalians.edit', $pengembalian) }}" class="text-yellow-600 hover:text-yellow-900">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Belum ada data pengembalian
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4">
        {{ $pengembalians->links() }}
    </div>
</div>
@endsection