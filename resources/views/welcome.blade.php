
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PKH - Program Keluarga Harapan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Poppins']">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md shadow-lg transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img src="image/logo dinsos.png" alt="Logo PKH" class="h-10 w-10 object-contain">
                    <span class="text-2xl font-bold text-blue-600">E-PKH</span>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:block">
                    <ul class="flex items-center space-x-8">
                        <li><a href="#hero" class="text-blue-600 font-medium hover:text-blue-700 transition-colors">Beranda</a></li>
                        <li><a href="#tentang" class="text-gray-700 hover:text-blue-600 transition-colors">Tentang PKH</a></li>
                        <li><a href="#manfaat" class="text-gray-700 hover:text-blue-600 transition-colors">Manfaat</a></li>
                        <li><a href="#kontak" class="text-gray-700 hover:text-blue-600 transition-colors">Kontak</a></li>
                        <li>
                            <a href="{{ url('login') }}" 
                               class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full font-medium hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                                Login
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700 hover:text-blue-600" id="mobile-menu-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <nav class="md:hidden hidden" id="mobile-menu">
                <ul class="pb-4 space-y-2">
                    <li><a href="#hero" class="block py-2 text-blue-600 font-medium">Beranda</a></li>
                    <li><a href="#tentang" class="block py-2 text-gray-700 hover:text-blue-600">Tentang PKH</a></li>
                    <li><a href="#manfaat" class="block py-2 text-gray-700 hover:text-blue-600">Manfaat</a></li>
                    <li><a href="#kontak" class="block py-2 text-gray-700 hover:text-blue-600">Kontak</a></li>
                    <li class="pt-2">
                        <a href="{{ url('login') }}" 
                           class="block text-center bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full font-medium">
                            Login
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="pt-20">
        <!-- Hero Section -->
        <section id="hero" class="min-h-screen flex items-center bg-gradient-to-br from-blue-50 via-white to-purple-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                            Program 
                            <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Keluarga Harapan
                            </span>
                            (PKH)
                        </h1>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            Memberikan harapan dan dukungan bagi keluarga Indonesia untuk masa depan yang lebih baik melalui bantuan sosial yang tepat sasaran.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ url('login') }}"  
                               class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-full font-semibold text-lg hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl">
                                Daftar PKH Sekarang
                            </a>
                            <a href="#tentang" 
                               class="border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-blue-600 hover:text-white transition-all duration-300">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                    
                    <!-- Hero Image/Illustration -->
                    <div class="hidden lg:block">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 rounded-3xl transform rotate-6 opacity-20"></div>
                            <div class="relative bg-white rounded-3xl shadow-2xl p-8">
                                <div class="text-center">
                                    <div class="w-32 h-32 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mx-auto mb-6 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Bantuan Terpercaya</h3>
                                    <p class="text-gray-600">Proses pendaftaran mudah dan transparan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tentang PKH -->
        <section id="tentang" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Tentang Program Keluarga Harapan
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        PKH adalah program bantuan sosial bersyarat yang memberikan bantuan tunai kepada Rumah Tangga Sangat Miskin (RTSM)
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Bantuan Keluarga</h3>
                        <p class="text-gray-600">Dukungan finansial untuk keluarga kurang mampu dalam memenuhi kebutuhan dasar.</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-purple-500 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Pendidikan</h3>
                        <p class="text-gray-600">Bantuan untuk memastikan anak-anak dapat mengakses pendidikan yang layak.</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-green-500 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Kesehatan</h3>
                        <p class="text-gray-600">Akses layanan kesehatan untuk ibu hamil, balita, dan lansia.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Manfaat Section -->
        <section id="manfaat" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Manfaat Program PKH
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Berbagai keuntungan yang diperoleh dari Program Keluarga Harapan
                    </p>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <!-- Benefit 1 -->
                        <div class="flex items-start space-x-4 group">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Bantuan Tunai Reguler</h3>
                                <p class="text-gray-600">Bantuan finansial rutin setiap bulan untuk memenuhi kebutuhan dasar keluarga.</p>
                            </div>
                        </div>

                        <!-- Benefit 2 -->
                        <div class="flex items-start space-x-4 group">
                            <div class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Bantuan Pendidikan</h3>
                                <p class="text-gray-600">Biaya sekolah, seragam, dan perlengkapan belajar untuk anak-anak.</p>
                            </div>
                        </div>

                        <!-- Benefit 3 -->
                        <div class="flex items-start space-x-4 group">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Layanan Kesehatan</h3>
                                <p class="text-gray-600">Akses gratis ke puskesmas dan layanan kesehatan dasar.</p>
                            </div>
                        </div>

                        <!-- Benefit 4 -->
                        <div class="flex items-start space-x-4 group">
                            <div class="flex-shrink-0 w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Pendampingan Sosial</h3>
                                <p class="text-gray-600">Bimbingan dan konsultasi dari pendamping sosial profesional.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits Image -->
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 rounded-3xl transform -rotate-6 opacity-20"></div>
                        <div class="relative bg-white rounded-3xl shadow-2xl p-8">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-blue-600 mb-2">50K+</div>
                                    <div class="text-gray-600">Keluarga Terbantu</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-purple-600 mb-2">100%</div>
                                    <div class="text-gray-600">Transparansi</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-green-600 mb-2">24/7</div>
                                    <div class="text-gray-600">Layanan Online</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-orange-600 mb-2">95%</div>
                                    <div class="text-gray-600">Kepuasan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="kontak" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Hubungi Kami
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Butuh bantuan atau informasi lebih lanjut? Tim kami siap membantu Anda
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Contact Card 1 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
                        <p class="text-gray-600">info@pkh.go.id</p>
                    </div>

                    <!-- Contact Card 2 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Telepon</h3>
                        <p class="text-gray-600">021-1234-5678</p>
                    </div>

                    <!-- Contact Card 3 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat</h3>
                        <p class="text-gray-600">Jakarta, Indonesia</p>
                    </div>

                    <!-- Contact Card 4 -->
                    <div class="text-center group">
                        <div class="w-16 h-16 bg-orange-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Jam Operasional</h3>
                        <p class="text-gray-600">08:00 - 16:00 WIB</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="image/logo dinsos.png" alt="Logo PKH" class="h-8 w-8 object-contain">
                        <span class="text-xl font-bold">E-PKH</span>
                    </div>
                    <p class="text-gray-400">
                        Platform digital untuk Program Keluarga Harapan yang memudahkan akses bantuan sosial.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Program</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Bantuan Keluarga</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Bantuan Pendidikan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Bantuan Kesehatan</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Layanan</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Pendaftaran Online</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cek Status</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Bantuan</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: info@pkh.go.id</li>
                        <li>Telepon: 021-1234-5678</li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 E-PKH. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu -->
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>