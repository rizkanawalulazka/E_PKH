<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-PKH</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500 font-['Poppins'] flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
    
    <!-- Login Card -->
    <div class="relative w-full max-w-md">
        <!-- Glass Card -->
        <div class="backdrop-blur-lg bg-white/20 border border-white/30 rounded-2xl shadow-2xl p-6 md:p-8 relative">
            <!-- Close Button -->
            <button onclick="window.location.href='/'" 
                    class="absolute top-4 right-4 w-8 h-8 bg-gray-900/80 hover:bg-gray-900 text-white rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110">
                <i class="bi bi-x-lg text-sm"></i>
            </button>

            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="bi bi-shield-lock text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">E-PKH</h1>
                <p class="text-gray-700 font-medium">Masuk ke akun Anda</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100/80 border border-red-300 rounded-xl">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-triangle text-red-600 mr-2"></i>
                        <span class="text-red-700 font-medium">Terjadi kesalahan:</span>
                    </div>
                    <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ url('login') }}" method="post" class="space-y-6">
                @csrf
                
                <!-- Role Selection -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-800">Masuk sebagai</label>
                    <div class="relative">
                        <select name="role" id="role" required 
                                class="w-full px-4 py-3 bg-white/70 border border-white/50 rounded-xl text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 appearance-none cursor-pointer hover:bg-white/80">
                            <option value="">Pilih peran Anda</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pendamping" {{ old('role') === 'pendamping' ? 'selected' : '' }}>Pendamping</option>
                            <option value="penerima" {{ old('role') === 'penerima' ? 'selected' : '' }}>Penerima Bansos</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="bi bi-chevron-down text-gray-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Identifier Input -->
                <div class="space-y-2">
                    <label for="identifier" class="block text-sm font-medium text-gray-700 mb-2">
                        <span id="identifier-label">NIK/NIP</span>
                    </label>
                    <input type="text" name="identifier" id="identifier" required
                           value="{{ old('identifier') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Masukkan NIK/NIP">
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Masukkan password">
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" 
                               class="w-4 h-4 text-blue-600 bg-white/70 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                        <span class="text-sm font-medium text-gray-800">Ingatkan saya</span>
                    </label>
                    <a href="{{ url('password/reset') }}" 
                       class="text-sm font-medium text-blue-700 hover:text-blue-800 transition-colors duration-300">
                        Lupa kata sandi?
                    </a>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Masuk
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            <div class="mt-8 text-center">
                <p class="text-gray-800 font-medium">
                    Belum memiliki akun? 
                    <a href="{{ url('register') }}" 
                       class="text-blue-700 hover:text-blue-800 font-semibold transition-colors duration-300 hover:underline">
                        Daftar sekarang
                    </a>
                </p>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute -top-4 -left-4 w-8 h-8 bg-yellow-400 rounded-full opacity-60 animate-pulse"></div>
            <div class="absolute -bottom-4 -right-4 w-6 h-6 bg-pink-400 rounded-full opacity-60 animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <!-- Bottom Decorative Card -->
        <div class="absolute -bottom-2 left-2 right-2 h-4 bg-white/10 rounded-xl blur-sm"></div>
        <div class="absolute -bottom-4 left-4 right-4 h-4 bg-white/5 rounded-xl blur-sm"></div>
    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById('role').addEventListener('change', function() {
            const label = document.getElementById('identifier-label');
            const input = document.getElementById('identifier');
            
            if (this.value === 'penerima') {
                label.textContent = 'NIK';
                input.placeholder = 'Masukkan NIK (16 digit)';
            } else if (this.value === 'admin' || this.value === 'pendamping') {
                label.textContent = 'NIP';
                input.placeholder = 'Masukkan NIP';
            } else {
                label.textContent = 'NIK/NIP';
                input.placeholder = 'Masukkan NIK/NIP';
            }
        });
    </script>
</body>
</html>