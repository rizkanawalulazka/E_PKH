<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>E-PKH @yield('title', $title ?? '')</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-slate-800 to-slate-900 text-white fixed inset-y-0 left-0 z-50 transform transition-transform duration-300 ease-in-out lg:translate-x-0" id="sidebar">
            <div class="flex items-center justify-center h-16 bg-slate-900">
                <div class="flex items-center">
                    <i class="fas fa-box text-2xl mr-3"></i>
                    <span class="text-xl font-bold">E-PKH</span>
                </div>
            </div>
            
            <nav class="mt-8">
                <div class="px-4 space-y-2"
                    
                    
                    @auth
                        @if(auth()->user()->role == 'admin')
                            <!-- Data Pendaftaran PKH (Admin) -->
                            <a href="{{ route('pendaftaran.pkh.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('pendaftaran.pkh.index') ? 'bg-slate-700' : '' }}">
                                <i class="fas fa-table w-5 h-5 mr-3"></i>
                                Data Pendaftaran PKH
                            </a>
                        @endif
                    @endauth
                    
                    @auth
                        @if(auth()->user()->role == 'penerima')
                            <!-- Dashboard -->
                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-slate-700' : '' }}">
                            <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                                Dashboard
                            </a>
                            <!-- Daftar PKH -->
                            <a href="/pendaftaran/create" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors">
                                <i class="fas fa-table w-5 h-5 mr-3"></i>
                                Daftar PKH
                            </a>
                            
                            <!-- Data Pendaftaran Saya -->
                            <a href="{{ route('pendaftaran.pkh.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('pendaftaran.pkh.index') ? 'bg-slate-700' : '' }}">
                                <i class="fas fa-file-alt w-5 h-5 mr-3"></i>
                                Data Pendaftaran Saya
                            </a>
                            
                            <!-- Info Pendamping -->
                            <a href="{{ route('pendamping.info') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors">
                                <i class="fas fa-user-friends w-5 h-5 mr-3"></i>
                                Info Pendamping
                            </a>
                        @endif
                    @endauth
                    
                    @auth
                        @if(auth()->user()->role == 'pendamping')
                            <!-- Dashboard Pendamping -->
                            <a href="{{ route('pendamping.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('pendamping.index') ? 'bg-slate-700' : '' }}">
                                <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                                Dashboard Pendamping
                            </a>
                            
                            <!-- Daftar Pendamping -->
                            <a href="{{ route('pendamping.penerima') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('pendamping.penerima') ? 'bg-slate-700' : '' }}">
                                <i class="fas fa-users w-5 h-5 mr-3"></i>
                                Daftar Pendamping
                            </a>
                            
                            <!-- Pemantauan PKH - TAMBAHKAN INI -->
                            <a href="{{ route('pendamping.pemantauan') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('pendamping.pemantauan') || request()->routeIs('pemantauan.show') ? 'bg-slate-700' : '' }}">
                                <i class="fas fa-clipboard-check w-5 h-5 mr-3"></i>
                                Pemantauan PKH
                            </a>
                            
                            <!-- Laporan Pendampingan -->
                            <a href="{{ route('pendamping.laporan') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('pendamping.laporan') ? 'bg-slate-700' : '' }}">
                                <i class="fas fa-clipboard-list w-5 h-5 mr-3"></i>
                                Laporan Pendampingan
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="lg:ml-64 flex-1">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button class="lg:hidden mr-4 text-gray-600 hover:text-gray-900" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <!-- Search -->
                        <div class="relative hidden md:block">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="Search...">
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="p-2 text-gray-600 hover:text-gray-900 relative">
                                <i class="fas fa-bell"></i>
                                <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                            </button>
                        </div>
                        
                        <!-- Messages -->
                        <div class="relative">
                            <button class="p-2 text-gray-600 hover:text-gray-900 relative">
                                <i class="fas fa-envelope"></i>
                                <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">7</span>
                            </button>
                        </div>
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                <img class="h-8 w-8 rounded-full mr-2" src="{{ asset('sbadmin2/img/undraw_profile.svg') }}" alt="Profile">
                                <span>{{ Auth::user()->name ?? '' }}</span>
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                <div class="py-1">
                                    <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                        <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                            {{ ucfirst(Auth::user()->role ?? '') }}
                                        </span>
                                    </div>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cogs mr-2"></i>
                                        Pengaturan
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- jQuery -->
    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    
    <!-- Chart.js -->
    <script src="{{ asset('sbadmin2/vendor/chart.js/Chart.min.js') }}"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
    
    @yield('scripts')
</body>
</html>