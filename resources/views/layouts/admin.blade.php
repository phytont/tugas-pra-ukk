<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Sistem Peminjaman Alat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0">
            <div class="p-4 border-b border-gray-700">
                <h1 class="text-xl font-bold">Admin Panel</h1>
                <p class="text-sm text-gray-400">Sistem Peminjaman Alat</p>
            </div>
            
            <nav class="mt-4">
                <a href="{{ route('admin.dashboard') }}" 
                   class="block py-3 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="block py-3 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-users mr-2"></i> Kelola User
                </a>
                
                <a href="{{ route('admin.kategoris.index') }}" 
                   class="block py-3 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.kategoris.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tags mr-2"></i> Kelola Kategori
                </a>
                
                <a href="{{ route('admin.alats.index') }}" 
                   class="block py-3 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.alats.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tools mr-2"></i> Kelola Alat
                </a>
                
                <a href="{{ route('admin.peminjamans.index') }}" 
                   class="block py-3 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.peminjamans.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-hand-holding mr-2"></i> Kelola Peminjaman
                </a>
                
                <a href="{{ route('admin.pengembalians.index') }}" 
                   class="block py-3 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.pengembalians.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-undo mr-2"></i> Kelola Pengembalian
                </a>
                
                <a href="{{ route('admin.logs.index') }}" 
                   class="block py-3 px-4 hover:bg-gray-700 {{ request()->routeIs('admin.logs.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-history mr-2"></i> Log Aktivitas
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white shadow-sm border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">@yield('header')</h2>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

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