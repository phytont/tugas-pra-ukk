@extends('layouts.admin')

@section('title', 'Detail User')
@section('header', 'Detail User')

@section('content')
<div class="bg-white rounded-lg shadow max-w-2xl mx-auto p-6">
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
        <p class="text-lg">{{ $user->name }}</p>
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <p class="text-lg">{{ $user->email }}</p>
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
        <span class="px-2 py-1 text-xs rounded {{ $user->role == 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
            {{ ucfirst($user->role) }}
        </span>
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Dibuat Pada</label>
        <p class="text-lg">{{ $user->created_at->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="flex justify-end">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100">Kembali</a>
    </div>
</div>
@endsection