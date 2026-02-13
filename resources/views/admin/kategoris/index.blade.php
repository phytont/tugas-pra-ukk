@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('header', 'Kelola Kategori')

@section('content')
<div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-dark">Daftar Kategori</h3>
            <p class="text-sm text-gray-500 mt-1">Kelompokkan alat berdasarkan kategori</p>
        </div>
        <a href="{{ route('admin.kategoris.create') }}" class="btn-primary px-6 py-3 rounded-xl flex items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>Tambah Kategori</span>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Alat</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($kategoris as $index => $kategori)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $kategoris->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                                <i class="fas fa-tag text-purple-500"></i>
                            </div>
                            <span class="font-medium text-dark">{{ $kategori->nama_kategori }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                            {{ $kategori->alats_count }} alat
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.kategoris.show', $kategori) }}" class="w-9 h-9 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 flex items-center justify-center transition-all">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('admin.kategoris.edit', $kategori) }}" class="w-9 h-9 rounded-lg bg-yellow-50 text-yellow-500 hover:bg-yellow-100 flex items-center justify-center transition-all">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('admin.kategoris.destroy', $kategori) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition-all">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-6 border-t border-gray-100">
        {{ $kategoris->links() }}
    </div>
</div>
@endsection