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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6DFF36',
                        secondary: '#5AE02E',
                        dark: '#1a1a1a',
                        light: '#f8fafc',
                        surface: '#ffffff',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .hover-lime:hover {
            background-color: #6DFF36;
            color: #1a1a1a;
            transition: all 0.3s ease;
        }
        .active-lime {
            background-color: #6DFF36;
            color: #1a1a1a;
        }
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        .card-shadow:hover {
            box-shadow: 0 10px 15px -3px rgba(109, 255, 54, 0.1), 0 4px 6px -2px rgba(109, 255, 54, 0.05);
        }
        .btn-primary {
            background-color: #6DFF36;
            color: #1a1a1a;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #5AE02E;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(109, 255, 54, 0.4);
        }
        .gradient-text {
            background: linear-gradient(135deg, #6DFF36 0%, #5AE02E 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 fixed h-full z-10">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
                        <i class="fas fa-layer-group text-dark text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-dark tracking-tight">Admin Panel</h1>
                        <p class="text-xs text-gray-500">Sistem Peminjaman</p>
                    </div>
                </div>
            </div>
            
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-100px)]">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'active-lime' : 'text-gray-600 hover:bg-gray-100 hover:text-dark' }}">
                    <i class="fas fa-chart-pie w-5"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'active-lime' : 'text-gray-600 hover:bg-gray-100 hover:text-dark' }}">
                    <i class="fas fa-users w-5"></i>
                    Kelola User
                </a>
                
                <a href="{{ route('admin.kategoris.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.kategoris.*') ? 'active-lime' : 'text-gray-600 hover:bg-gray-100 hover:text-dark' }}">
                    <i class="fas fa-tags w-5"></i>
                    Kelola Kategori
                </a>
                
                <a href="{{ route('admin.alats.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.alats.*') ? 'active-lime' : 'text-gray-600 hover:bg-gray-100 hover:text-dark' }}">
                    <i class="fas fa-tools w-5"></i>
                    Kelola Alat
                </a>
                
                <a href="{{ route('admin.peminjamans.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.peminjamans.*') ? 'active-lime' : 'text-gray-600 hover:bg-gray-100 hover:text-dark' }}">
                    <i class="fas fa-hand-holding w-5"></i>
                    Kelola Peminjaman
                </a>
                
                <a href="{{ route('admin.pengembalians.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.pengembalians.*') ? 'active-lime' : 'text-gray-600 hover:bg-gray-100 hover:text-dark' }}">
                    <i class="fas fa-undo w-5"></i>
                    Kelola Pengembalian
                </a>
                
                <a href="{{ route('admin.logs.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.logs.*') ? 'active-lime' : 'text-gray-600 hover:bg-gray-100 hover:text-dark' }}">
                    <i class="fas fa-history w-5"></i>
                    Log Aktivitas
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col ml-64">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center sticky top-0 z-10 glass-effect">
                <div>
                    <h2 class="text-2xl font-bold text-dark">@yield('header')</h2>
                    <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ auth()->user()->name }}</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3 bg-gray-50 px-4 py-2 rounded-full">
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-dark text-sm"></i>
                        </div>
                        <span class="text-sm font-medium text-dark">{{ auth()->user()->name }}</span>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-full bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition-all duration-200">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-8 overflow-y-auto">
                @if(session('success'))
                    <div class="mb-6 bg-primary/10 border border-primary/20 text-dark px-6 py-4 rounded-2xl flex items-center gap-3">
                        <i class="fas fa-check-circle text-primary text-xl"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>