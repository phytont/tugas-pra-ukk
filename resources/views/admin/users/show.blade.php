@extends('layouts.admin')

@section('title', 'Detail User')
@section('header', 'Detail User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
        <div class="p-8 text-center border-b border-gray-100">
            <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl font-bold text-primary">{{ substr($user->name, 0, 1) }}</span>
            </div>
            <h3 class="text-2xl font-bold text-dark mb-1">{{ $user->name }}</h3>
            <span class="px-4 py-1 rounded-full text-sm font-medium {{ $user->role == 'admin' ? 'bg-red-100 text-red-700' : ($user->role == 'petugas' ? 'bg-blue-100 text-blue-700' : 'bg-primary/10 text-dark') }}">
                {{ ucfirst($user->role) }}
            </span>
        </div>
        
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <span class="text-gray-500 text-sm">Email</span>
                <span class="font-medium text-dark">{{ $user->email }}</span>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <span class="text-gray-500 text-sm">Dibuat Pada</span>
                <span class="font-medium text-dark">{{ $user->created_at->format('d M Y, H:i') }}</span>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <span class="text-gray-500 text-sm">Terakhir Diupdate</span>
                <span class="font-medium text-dark">{{ $user->updated_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
        
        <div class="p-6 border-t border-gray-100 flex justify-center">
            <a href="{{ route('admin.users.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-dark font-medium hover:bg-gray-50 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection