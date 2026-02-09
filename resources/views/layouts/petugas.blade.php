<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Petugas Panel') - Sistem Peminjaman Alat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-800 text-white flex-shrink-0">
            <div class="p-4 border-b border-indigo-700">
                <h1 class="text-xl font-bold">Panel Petugas</h1>
                <p class="text-sm text-indigo-300">Sistem Peminjaman Alat</p>
            </div>
            
            <nav class="mt-4">
                <a href="{{ route('petugas.dashboard') }}" 
                   class="block py-3 px-4 hover:bg-indigo-700 {{ request()->routeIs('petugas.dashboard') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                
                <a href="{{ route('petugas.peminjamans.index') }}" 
                   class="block py-3 px-4 hover:bg-indigo-700 {{ request()->routeIs('petugas.peminjamans.*') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-clipboard-check mr-2"></i> Persetujuan Peminjaman
                </a>
                
                <a href="{{ route('petugas.peminjamans.semua') }}" 
                   class="block py-3 px-4 hover:bg-indigo-700 {{ request()->routeIs('petugas.peminjamans.semua') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-list mr-2"></i> Semua Peminjaman
                </a>
                
                <a href="{{ route('petugas.pengembalians.index') }}" 
                   class="block py-3 px-4 hover:bg-indigo-700 {{ request()->routeIs('petugas.pengembalians.*') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-undo mr-2"></i> Pengembalian & Denda
                </a>
                
                <a href="{{ route('petugas.laporan.index') }}" 
                   class="block py-3 px-4 hover:bg-indigo-700 {{ request()->routeIs('petugas.laporan.*') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-file-alt mr-2"></i> Laporan
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">@yield('header')</h2>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">
                        <i class="fas fa-user-circle mr-1"></i>
                        {{ auth()->user()->name }} (Petugas)
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>