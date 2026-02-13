@extends('layouts.admin')

@section('title', 'Kelola User')
@section('header', 'Kelola User')

@section('content')
<div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-dark">Daftar User</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola data pengguna sistem</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary px-6 py-3 rounded-xl flex items-center gap-2">
            <i class="fas fa-plus"></i>
            <span>Tambah User</span>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $index => $user)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $users->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="font-semibold text-primary">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <span class="font-medium text-dark">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $user->role == 'admin' ? 'bg-red-100 text-red-700' : ($user->role == 'petugas' ? 'bg-blue-100 text-blue-700' : 'bg-primary/10 text-dark') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="w-9 h-9 rounded-lg bg-blue-50 text-blue-500 hover:bg-blue-100 flex items-center justify-center transition-all" title="Detail">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="w-9 h-9 rounded-lg bg-yellow-50 text-yellow-500 hover:bg-yellow-100 flex items-center justify-center transition-all" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition-all" title="Hapus">
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
        {{ $users->links() }}
    </div>
</div>
@endsection  <!-- ⬅️ INI YANG HILANG, TAMBAHKAN! -->