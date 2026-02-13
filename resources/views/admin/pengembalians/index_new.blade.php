@extends('layouts.admin')

@section('title', 'Daftar Denda')
@section('header', 'Daftar Denda')

@section('content')

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Daftar Denda yang Ditagihkan ke Peminjam</h3>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Verifikasi</th>
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
                    <td class="px-6 py-4">{{ $pengembalian->peminjaman->alat->nama_alat }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded
                            {{ $pengembalian->kondisi == 'rusak' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($pengembalian->kondisi) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-lg font-bold text-red-600">Rp {{ number_format($pengembalian->denda_final, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        {{ \Carbon\Carbon::parse($pengembalian->updated_at)->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('admin.pengembalians.show', $pengembalian) }}" 
                           class="inline-block px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                            <i class="fas fa-eye mr-1"></i>Lihat Detail
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
        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
        <p class="text-gray-600 text-lg">Tidak ada denda yang ditagihkan</p>
    </div>
    @endif
</div>
@endsection
