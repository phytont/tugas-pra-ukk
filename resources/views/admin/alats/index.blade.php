@extends('layouts.admin')

@section('title', 'Kelola Alat')
@section('header', 'Kelola Alat')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold">Daftar Alat</h3>
        <a href="{{ route('admin.alats.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Tambah Alat
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Alat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($alats as $index => $alat)
                <tr>
                    <td class="px-6 py-4">{{ $alats->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $alat->nama_alat }}</td>
                    <td class="px-6 py-4">{{ $alat->kategori->nama_kategori }}</td>
                    <td class="px-6 py-4">{{ $alat->jumlah_tersedia }}/{{ $alat->jumlah_total }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded 
                            {{ $alat->status == 'tersedia' ? 'bg-green-100 text-green-800' : 
                               ($alat->status == 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 
                               ($alat->status == 'rusak' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst($alat->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('admin.alats.show', $alat) }}" class="text-blue-600 hover:text-blue-900">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.alats.edit', $alat) }}" class="text-yellow-600 hover:text-yellow-900">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.alats.destroy', $alat) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-4">
        {{ $alats->links() }}
    </div>
</div>
@endsection