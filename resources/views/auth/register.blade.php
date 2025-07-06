<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | E-PKH</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500 font-['Poppins'] flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
    
    <!-- Register Card -->
    <div class="relative w-full max-w-lg">
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
                    <i class="bi bi-person-plus text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">E-PKH</h1>
                <p class="text-gray-700 font-medium">Daftar sebagai Penerima PKH</p>
                <p class="text-sm text-gray-600 mt-1">Buat akun untuk mengajukan bantuan sosial</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100/80 border border-green-300 rounded-xl">
                    <div class="flex items-center">
                        <i class="bi bi-check-circle text-green-600 mr-2"></i>
                        <span class="text-green-700 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100/80 border border-red-300 rounded-xl">
                    <div class="flex items-center mb-2">
                        <i class="bi bi-exclamation-triangle text-red-600 mr-2"></i>
                        <span class="text-red-700 font-medium">Terjadi kesalahan:</span>
                    </div>
                    <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Register Form -->
            <form action="{{ url('/register') }}" method="post" class="space-y-5">
                @csrf

                <!-- Info Banner -->
                <div class="bg-blue-50/80 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex items-center">
                        <i class="bi bi-info-circle text-blue-600 mr-2"></i>
                        <span class="text-blue-800 text-sm font-medium">
                            Akun akan didaftarkan sebagai Penerima PKH
                        </span>
                    </div>
                </div>

                <!-- Full Name Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-800">Nama Lengkap</label>
                    <div class="relative">
                        <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap sesuai KTP" required
                               class="w-full px-4 py-3 pl-12 bg-white/70 border border-white/50 rounded-xl text-gray-900 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:bg-white/80"
                               value="{{ old('nama_lengkap') }}">
                        <div class="absolute inset-y-0 left-0 flex items-center px-4">
                            <i class="bi bi-person text-gray-600"></i>
                        </div>
                    </div>
                </div>

                <!-- NIK Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-800">NIK (Nomor Induk Kependudukan)</label>
                    <div class="relative">
                        <input type="text" name="nik" placeholder="Masukkan NIK (16 digit)" required
                               class="w-full px-4 py-3 pl-12 bg-white/70 border border-white/50 rounded-xl text-gray-900 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:bg-white/80"
                               value="{{ old('nik') }}" maxlength="16" pattern="[0-9]{16}">
                        <div class="absolute inset-y-0 left-0 flex items-center px-4">
                            <i class="bi bi-person-badge text-gray-600"></i>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">
                        <i class="bi bi-exclamation-circle mr-1"></i>
                        NIK harus 16 digit angka sesuai KTP
                    </p>
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-800">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="Masukkan kata sandi" required id="passwordInput"
                               class="w-full px-4 py-3 pl-12 pr-12 bg-white/70 border border-white/50 rounded-xl text-gray-900 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:bg-white/80"
                               minlength="6">
                        <div class="absolute inset-y-0 left-0 flex items-center px-4">
                            <i class="bi bi-lock text-gray-600"></i>
                        </div>
                        <button type="button" onclick="togglePassword('passwordInput', 'toggleIcon1')" 
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600 hover:text-gray-800 transition-colors duration-300">
                            <i class="bi bi-eye-slash" id="toggleIcon1"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">Minimal 6 karakter</p>
                </div>

                <!-- Confirm Password Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-800">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required id="confirmPasswordInput"
                               class="w-full px-4 py-3 pl-12 pr-12 bg-white/70 border border-white/50 rounded-xl text-gray-900 placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:bg-white/80"
                               minlength="6">
                        <div class="absolute inset-y-0 left-0 flex items-center px-4">
                            <i class="bi bi-lock-fill text-gray-600"></i>
                        </div>
                        <button type="button" onclick="togglePassword('confirmPasswordInput', 'toggleIcon2')" 
                                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600 hover:text-gray-800 transition-colors duration-300">
                            <i class="bi bi-eye-slash" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start space-x-3">
                    <input type="checkbox" id="terms" required 
                           class="w-4 h-4 mt-1 text-blue-600 bg-white/70 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="terms" class="text-sm text-gray-800 leading-relaxed">
                        Saya menyetujui 
                        <a href="#" class="text-blue-700 hover:text-blue-800 font-medium hover:underline">Syarat dan Ketentuan</a> 
                        serta 
                        <a href="#" class="text-blue-700 hover:text-blue-800 font-medium hover:underline">Kebijakan Privasi</a>
                        Program Keluarga Harapan (PKH)
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-xl font-semibold text-lg hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="bi bi-person-plus mr-2"></i>Daftar Sekarang
                    </button>
                    <button type="button" onclick="window.location.href='/'" 
                            class="flex-1 bg-white/80 text-gray-900 py-3 px-6 rounded-xl font-semibold text-lg border border-gray-300 hover:bg-white hover:shadow-md transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="bi bi-x-circle mr-2"></i>Batal
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="mt-8 text-center">
                <p class="text-gray-800 font-medium">
                    Sudah memiliki akun? 
                    <a href="{{ url('login') }}" 
                       class="text-blue-700 hover:text-blue-800 font-semibold transition-colors duration-300 hover:underline">
                        Masuk sekarang
                    </a>
                </p>
            </div>

            <!-- Info Footer -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-600">
                    <i class="bi bi-shield-check mr-1"></i>
                    Data Anda akan digunakan untuk verifikasi kelayakan penerima PKH
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
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        }

        // Password confirmation validation
        document.getElementById('confirmPasswordInput').addEventListener('input', function() {
            const password = document.getElementById('passwordInput').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.classList.add('border-red-500');
                this.classList.remove('border-white/50');
            } else {
                this.classList.remove('border-red-500');
                this.classList.add('border-white/50');
            }
        });

        // NIK validation
        document.querySelector('input[name="nik"]').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 16) {
                this.value = this.value.slice(0, 16);
            }
        });

        // Add smooth animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.backdrop-blur-lg');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });

        // Form validation feedback
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('passwordInput').value;
            const confirmPassword = document.getElementById('confirmPasswordInput').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Kata sandi dan konfirmasi kata sandi tidak cocok!');
                return;
            }
            
            const submitBtn = document.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise animate-spin mr-2"></i>Mendaftarkan...';
            submitBtn.disabled = true;
        });

        // Real-time form validation
        document.querySelectorAll('input[required]').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-white/50');
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-white/50');
                }
            });
        });
    </script>
</body>
</html>