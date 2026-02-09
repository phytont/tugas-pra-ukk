<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Peminjam') - Sistem Peminjaman Alat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-green-800 text-white flex-shrink-0">
            <div class="p-4 border-b border-green-700">
                <h1 class="text-xl font-bold">Panel Peminjam</h1>
                <p class="text-sm text-green-300">Sistem Peminjaman Alat</p>
            </div>
            
            <nav class="mt-4">
                <a href="{{ route('peminjam.dashboard') }}" 
                   class="block py-3 px-4 hover:bg-green-700 {{ request()->routeIs('peminjam.dashboard') ? 'bg-green-700' : '' }}">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                
                <a href="{{ route('peminjam.alats.index') }}" 
                   class="block py-3 px-4 hover:bg-green-700 {{ request()->routeIs('peminjam.alats.*') ? 'bg-green-700' : '' }}">
                    <i class="fas fa-tools mr-2"></i> Lihat Daftar Alat
                </a>
                
                <a href="{{ route('peminjam.peminjamans.create') }}" 
                   class="block py-3 px-4 hover:bg-green-700 {{ request()->routeIs('peminjam.peminjamans.create') ? 'bg-green-700' : '' }}">
                    <i class="fas fa-plus-circle mr-2"></i> Ajukan Peminjaman
                </a>
                
                <a href="{{ route('peminjam.peminjamans.index') }}" 
                   class="block py-3 px-4 hover:bg-green-700 {{ request()->routeIs('peminjam.peminjamans.index') ? 'bg-green-700' : '' }}">
                    <i class="fas fa-list mr-2"></i> Riwayat Peminjaman
                </a>
                
                <a href="{{ route('peminjam.pengembalians.create') }}" 
                   class="block py-3 px-4 hover:bg-green-700 {{ request()->routeIs('peminjam.pengembalians.create') ? 'bg-green-700' : '' }}">
                    <i class="fas fa-undo mr-2"></i> Kembalikan Alat
                </a>
                
                <a href="{{ route('peminjam.denda.index') }}" 
                   class="block py-3 px-4 hover:bg-green-700 {{ request()->routeIs('peminjam.denda.*') ? 'bg-green-700' : '' }}">
                    <i class="fas fa-money-bill-wave mr-2"></i> Lihat Denda
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
                        <i class="fas fa-user mr-1"></i>
                        {{ auth()->user()->name }}
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