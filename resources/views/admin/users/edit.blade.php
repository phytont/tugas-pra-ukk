@extends('layouts.admin')

@section('title', 'Edit User')
@section('header', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-dark">Form Edit User</h3>
            <p class="text-sm text-gray-500 mt-1">Perbarui data pengguna</p>
        </div>
        
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-dark mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-dark mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-dark mb-2">Password (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all @error('password') border-red-500 @enderror"
                           placeholder="Minimal 6 karakter">
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-dark mb-2">Role</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="user" class="peer sr-only" {{ old('role', $user->role) == 'user' ? 'checked' : '' }}>
                            <div class="px-4 py-3 rounded-xl border-2 border-gray-200 text-center peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                <i class="fas fa-user text-gray-400 peer-checked:text-primary mb-1"></i>
                                <p class="text-sm font-medium text-dark">User</p>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="petugas" class="peer sr-only" {{ old('role', $user->role) == 'petugas' ? 'checked' : '' }}>
                            <div class="px-4 py-3 rounded-xl border-2 border-gray-200 text-center peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                <i class="fas fa-user-tie text-gray-400 peer-checked:text-primary mb-1"></i>
                                <p class="text-sm font-medium text-dark">Petugas</p>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="admin" class="peer sr-only" {{ old('role', $user->role) == 'admin' ? 'checked' : '' }}>
                            <div class="px-4 py-3 rounded-xl border-2 border-gray-200 text-center peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                <i class="fas fa-user-shield text-gray-400 peer-checked:text-primary mb-1"></i>
                                <p class="text-sm font-medium text-dark">Admin</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-dark font-medium hover:bg-gray-50 transition-all">
                    Batal
                </a>
                <button type="submit" class="btn-primary px-6 py-3 rounded-xl">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection