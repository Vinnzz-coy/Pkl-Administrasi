<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PKL Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#1e40af',
                        accent: '#10b981',
                        dark: '#1f2937',
                        light: '#f9fafb',
                        'card-bg': '#ffffff'
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
                        'bounce-slow': 'bounce 2s infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'slide-in-right': 'slideInRight 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        slideInRight: {
                            '0%': { transform: 'translateX(100%)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            transition: all 0.3s ease;
        }

        .main-content {
            transition: all 0.3s ease;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.15);
        }

        .active-menu {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            color: #1e40af;
            font-weight: 600;
        }

        .greeting-card {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        /* Mobile floating menu */
        .mobile-float-menu {
            position: fixed;
            bottom: 30px;
            right: 20px;
            z-index: 100;
            display: none;
        }

        .mobile-float-menu.active {
            display: block;
            animation: slideInRight 0.3s ease-out;
        }

        .float-menu-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.5);
            cursor: pointer;
        }

        .float-menu-content {
            position: absolute;
            bottom: 70px;
            right: 0;
            background: white;
            border-radius: 15px;
            padding: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            display: none;
        }

        .float-menu-content.active {
            display: block;
            animation: slideInRight 0.3s ease-out;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -100%;
                z-index: 50;
                height: 100vh;
                overflow-y: auto;
                width: 280px;
            }

            .sidebar.active {
                left: 0;
                box-shadow: 5px 0 25px rgba(0, 0, 0, 0.1);
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }

            .overlay.active {
                display: block;
            }

            .mobile-float-menu {
                display: block;
            }

            /* Perbaikan untuk menu mobile agar tidak gelap */
            nav a {
                color: #4b5563;
            }

            nav a:hover, nav a.active-menu {
                color: #1e40af;
                background-color: #eff6ff;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <!-- Overlay untuk mobile -->
        <div class="overlay" id="overlay"></div>

        <!-- Sidebar -->
        <aside class="sidebar w-64 bg-white shadow-xl flex flex-col z-30">
            <!-- Logo Sekolah -->
            <div class="p-6 border-b">
                <div class="flex items-center">
                    <!-- Logo sekolah tanpa background -->
                    <div class="w-12 h-12 rounded-lg overflow-hidden flex items-center justify-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/2784/2784449.png" alt="Logo Sekolah" class="w-full h-full object-contain">
                    </div>
                    <div class="ml-4">
                        <h1 class="text-xl font-bold text-dark">SMK Negri 1 Wonosobo</h1>
                        <p class="text-gray-500 text-sm">Sistem Pengelolaan PKL</p>
                    </div>
                </div>
            </div>

            <!-- Profile Admin -->
            <div class="p-6 border-b">
                <div class="flex items-center cursor-pointer" id="profile-toggle">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center overflow-hidden border-2 border-white shadow">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Admin" class="w-full h-full object-cover">
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-dark">Budi Santoso, S.Pd</h3>
                        <p class="text-gray-500 text-sm">Admin PKL</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 ml-auto transition-transform duration-300" id="profile-chevron"></i>
                </div>

                <!-- Menu Profile (hidden by default) -->
                <div class="mt-4 hidden animate-slide-down" id="profile-menu">
                    <a href="#" class="block py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 transition-colors duration-200">
                        <i class="fas fa-user-circle mr-3 text-primary"></i> Profil Saya
                    </a>
                    <a href="#" class="block py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 transition-colors duration-200">
                        <i class="fas fa-cog mr-3 text-primary"></i> Pengaturan Akun
                    </a>
                    <a href="#" class="block py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt mr-3 text-primary"></i> Keluar
                    </a>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex items-center py-3 px-4 rounded-lg active-menu transition-all duration-200">
                            <i class="fas fa-tachometer-alt text-primary mr-3"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200">
                            <i class="fas fa-user-graduate text-blue-500 mr-3"></i>
                            <span>Data Siswa PKL</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200">
                            <i class="fas fa-chalkboard-teacher text-green-500 mr-3"></i>
                            <span>Data Pembimbing</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200">
                            <i class="fas fa-building text-purple-500 mr-3"></i>
                            <span>Data Perusahaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200">
                            <i class="fas fa-file-contract text-yellow-500 mr-3"></i>
                            <span>Buat Surat Penjajakan</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200">
                            <i class="fas fa-print text-red-500 mr-3"></i>
                            <span>Cetak Surat Penempatan</span>
                        </a>
                    </li>
                    <li class="pt-6">
                        <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200">
                            <i class="fas fa-cog text-gray-500 mr-3"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Tombol Toggle Sidebar untuk Mobile -->
            <div class="p-4 border-t lg:hidden">
                <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-4 rounded-lg transition-colors duration-200" id="close-sidebar">
                    <i class="fas fa-times mr-2"></i> Tutup Menu
                </button>
            </div>

            <!-- Footer Sidebar -->
            <div class="p-4 border-t text-center text-gray-500 text-sm">
                <p>© 2025 SMK Negri 1 Wonosobo</p>
                <p class="text-xs mt-1">Sistem PKL v1.0</p>
            </div>
        </aside>

        <!-- Mobile Floating Menu -->
        <div class="mobile-float-menu" id="mobile-float-menu">
            <div class="float-menu-content" id="float-menu-content">
                <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-tachometer-alt text-primary mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-user-graduate text-blue-500 mr-3"></i>
                    <span>Data Siswa</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-chalkboard-teacher text-green-500 mr-3"></i>
                    <span>Pembimbing</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-building text-purple-500 mr-3"></i>
                    <span>Perusahaan</span>
                </a>
            </div>
            <div class="float-menu-btn" id="float-menu-btn">
                <i class="fas fa-bars text-white text-2xl"></i>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-1 flex flex-col overflow-hidden">
            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-50">
                <!-- Welcome Section dengan Tanggal -->
                <div class="mb-6 animate-fade-in">
                    <div class="greeting-card rounded-2xl shadow-lg p-6 md:p-8 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="mb-4 md:mb-0">
                                <h1 class="text-3xl md:text-4xl font-bold mb-2">Dashboard PKL</h1>
                                <p class="text-blue-100 text-lg">Selamat datang, <span class="font-semibold">Budi Santoso, S.Pd</span>! Kelola data peserta PKL dengan mudah dan efisien.</p>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center md:text-right animate-float">
                                <p class="text-sm text-blue-100">Hari ini</p>
                                <p class="text-2xl font-bold" id="current-date">Selasa, 17 Oktober 2023</p>
                                <p class="text-sm text-blue-100 mt-1" id="current-time">09:42:15</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pencarian dan Filter (dengan shadow) -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 animate-slide-up">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                        <!-- Search Bar -->
                        <div class="flex-1">
                            <div class="relative">
                                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input
                                    type="text"
                                    placeholder="Cari data siswa, pembimbing, perusahaan..."
                                    class="w-full pl-12 pr-4 py-3 bg-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition-all duration-300 border border-gray-200"
                                    id="search-input"
                                >
                            </div>
                        </div>

                        <!-- Filter Options -->
                        <div class="flex flex-wrap gap-3">
                            <select class="bg-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 border border-gray-300 shadow-sm">
                                <option>Semua Status</option>
                                <option>Aktif</option>
                                <option>Selesai</option>
                                <option>Menunggu</option>
                            </select>
                            <select class="bg-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 border border-gray-300 shadow-sm">
                                <option>Semua Jurusan</option>
                                <option>TKJ</option>
                                <option>RPL</option>
                                <option>MM</option>
                                <option>AKL</option>
                                <option>TKR</option>
                                <option>TSM</option>
                                <option>APHP</option>
                            </select>
                            <select class="bg-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary transition-all duration-300 border border-gray-300 shadow-sm">
                                <option>Semua Tahun</option>
                                <option>2023</option>
                                <option>2022</option>
                                <option>2021</option>
                            </select>
                            <button class="bg-primary hover:bg-secondary text-white px-5 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center shadow-md hover:shadow-lg">
                                <i class="fas fa-filter mr-2"></i> Terapkan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistik Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Card Siswa -->
                    <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-slide-up" style="animation-delay: 0.1s">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-500 text-sm font-medium">Siswa PKL</h3>
                                <p class="text-3xl font-bold text-dark mt-2" id="student-count">148</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-green-500 text-sm font-medium flex items-center">
                                        <i class="fas fa-arrow-up mr-1"></i> 12%
                                    </span>
                                    <span class="text-gray-500 text-sm ml-2">dari bulan lalu</span>
                                </div>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-xl animate-pulse-slow">
                                <i class="fas fa-user-graduate text-blue-500 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Card Pembimbing -->
                    <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-slide-up" style="animation-delay: 0.2s">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-500 text-sm font-medium">Pembimbing</h3>
                                <p class="text-3xl font-bold text-dark mt-2" id="mentor-count">24</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-green-500 text-sm font-medium flex items-center">
                                        <i class="fas fa-arrow-up mr-1"></i> 5%
                                    </span>
                                    <span class="text-gray-500 text-sm ml-2">dari bulan lalu</span>
                                </div>
                            </div>
                            <div class="bg-green-100 p-3 rounded-xl animate-pulse-slow" style="animation-delay: 0.5s">
                                <i class="fas fa-chalkboard-teacher text-green-500 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Card Perusahaan -->
                    <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-slide-up" style="animation-delay: 0.3s">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-500 text-sm font-medium">Perusahaan</h3>
                                <p class="text-3xl font-bold text-dark mt-2" id="company-count">42</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-green-500 text-sm font-medium flex items-center">
                                        <i class="fas fa-arrow-up mr-1"></i> 8%
                                    </span>
                                    <span class="text-gray-500 text-sm ml-2">dari bulan lalu</span>
                                </div>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-xl animate-pulse-slow" style="animation-delay: 1s">
                                <i class="fas fa-building text-purple-500 text-2xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Card Surat -->
                    <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-slide-up" style="animation-delay: 0.4s">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-500 text-sm font-medium">Surat Tercetak</h3>
                                <p class="text-3xl font-bold text-dark mt-2" id="letter-count">89</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-green-500 text-sm font-medium flex items-center">
                                        <i class="fas fa-arrow-up mr-1"></i> 15%
                                    </span>
                                    <span class="text-gray-500 text-sm ml-2">dari bulan lalu</span>
                                </div>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-xl animate-pulse-slow" style="animation-delay: 1.5s">
                                <i class="fas fa-file-contract text-yellow-500 text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Statistik PKL per Jurusan (8 jurusan) -->
                <div class="bg-white rounded-2xl shadow-md p-6 mb-8 animate-fade-in">
                    <h2 class="text-xl font-bold text-dark mb-6">Statistik PKL per Jurusan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Chart TKJ -->
                        <div class="chart-container bg-gray-50 rounded-xl p-4 border border-gray-200 card-hover">
                            <h3 class="font-bold text-dark mb-4 text-center">Teknik Komputer Jaringan (TKJ)</h3>
                            <div class="relative h-48">
                                <canvas id="chart-tkj"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">Total Siswa: <span class="font-bold text-dark">52</span></p>
                                <p class="text-xs text-green-500 mt-1"><i class="fas fa-arrow-up mr-1"></i> 8% dari tahun lalu</p>
                            </div>
                        </div>

                        <!-- Chart RPL -->
                        <div class="chart-container bg-gray-50 rounded-xl p-4 border border-gray-200 card-hover">
                            <h3 class="font-bold text-dark mb-4 text-center">Rekayasa Perangkat Lunak (RPL)</h3>
                            <div class="relative h-48">
                                <canvas id="chart-rpl"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">Total Siswa: <span class="font-bold text-dark">48</span></p>
                                <p class="text-xs text-green-500 mt-1"><i class="fas fa-arrow-up mr-1"></i> 12% dari tahun lalu</p>
                            </div>
                        </div>

                        <!-- Chart MM -->
                        <div class="chart-container bg-gray-50 rounded-xl p-4 border border-gray-200 card-hover">
                            <h3 class="font-bold text-dark mb-4 text-center">Multimedia (MM)</h3>
                            <div class="relative h-48">
                                <canvas id="chart-mm"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">Total Siswa: <span class="font-bold text-dark">32</span></p>
                                <p class="text-xs text-green-500 mt-1"><i class="fas fa-arrow-up mr-1"></i> 5% dari tahun lalu</p>
                            </div>
                        </div>

                        <!-- Chart AKL -->
                        <div class="chart-container bg-gray-50 rounded-xl p-4 border border-gray-200 card-hover">
                            <h3 class="font-bold text-dark mb-4 text-center">Akuntansi (AKL)</h3>
                            <div class="relative h-48">
                                <canvas id="chart-akl"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">Total Siswa: <span class="font-bold text-dark">28</span></p>
                                <p class="text-xs text-green-500 mt-1"><i class="fas fa-arrow-up mr-1"></i> 3% dari tahun lalu</p>
                            </div>
                        </div>

                        <!-- Chart TKR -->
                        <div class="chart-container bg-gray-50 rounded-xl p-4 border border-gray-200 card-hover">
                            <h3 class="font-bold text-dark mb-4 text-center">Teknik Kendaraan Ringan (TKR)</h3>
                            <div class="relative h-48">
                                <canvas id="chart-tkr"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">Total Siswa: <span class="font-bold text-dark">38</span></p>
                                <p class="text-xs text-green-500 mt-1"><i class="fas fa-arrow-up mr-1"></i> 6% dari tahun lalu</p>
                            </div>
                        </div>

                        <!-- Chart TSM -->
                        <div class="chart-container bg-gray-50 rounded-xl p-4 border border-gray-200 card-hover">
                            <h3 class="font-bold text-dark mb-4 text-center">Teknik Sepeda Motor (TSM)</h3>
                            <div class="relative h-48">
                                <canvas id="chart-tsm"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">Total Siswa: <span class="font-bold text-dark">34</span></p>
                                <p class="text-xs text-green-500 mt-1"><i class="fas fa-arrow-up mr-1"></i> 4% dari tahun lalu</p>
                            </div>
                        </div>

                        <!-- Chart APHP -->
                        <div class="chart-container bg-gray-50 rounded-xl p-4 border border-gray-200 card-hover">
                            <h3 class="font-bold text-dark mb-4 text-center">Agribisnis Pengolahan Hasil Pertanian (APHP)</h3>
                            <div class="relative h-48">
                                <canvas id="chart-aphp"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">Total Siswa: <span class="font-bold text-dark">26</span></p>
                                <p class="text-xs text-green-500 mt-1"><i class="fas fa-arrow-up mr-1"></i> 2% dari tahun lalu</p>
                            </div>
                        </div>

                        <!-- Chart TO -->
                        <div class="chart-container bg-gray-50 rounded-xl p-4 border border-gray-200 card-hover">
                            <h3 class="font-bold text-dark mb-4 text-center">Teknik Otomasi (TO)</h3>
                            <div class="relative h-48">
                                <canvas id="chart-to"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">Total Siswa: <span class="font-bold text-dark">22</span></p>
                                <p class="text-xs text-green-500 mt-1"><i class="fas fa-arrow-up mr-1"></i> 7% dari tahun lalu</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Siswa Terbaru dan Perusahaan Mitra -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Siswa Terbaru -->
                    <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-in">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-dark">Siswa Terbaru</h2>
                            <a href="#" class="text-primary font-medium hover:text-secondary transition-colors duration-200 flex items-center">
                                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div>
                                    <h3 class="font-semibold text-dark">Ahmad Fauzan</h3>
                                    <p class="text-gray-600 text-sm">Teknik Komputer - PT. Teknologi</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Aktif</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div>
                                    <h3 class="font-semibold text-dark">Siti Nurhaliza</h3>
                                    <p class="text-gray-600 text-sm">Akuntansi - CV. Sejahtera</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Aktif</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div>
                                    <h3 class="font-semibold text-dark">Budi Santoso</h3>
                                    <p class="text-gray-600 text-sm">Teknik Mesin - PT. Industri</p>
                                </div>
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-3 py-1 rounded-full">Menunggu</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div>
                                    <h3 class="font-semibold text-dark">Rina Wijaya</h3>
                                    <p class="text-gray-600 text-sm">Multimedia - PT. Digital Kreatif</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Aktif</span>
                            </div>
                        </div>
                    </div>

                    <!-- Perusahaan Mitra -->
                    <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-in" style="animation-delay: 0.2s">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-dark">Perusahaan Mitra</h2>
                            <a href="#" class="text-primary font-medium hover:text-secondary transition-colors duration-200 flex items-center">
                                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div>
                                    <h3 class="font-semibold text-dark">PT. Teknologi Indonesia</h3>
                                    <p class="text-gray-600 text-sm">Teknologi & Inovasi</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Aktif</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div>
                                    <h3 class="font-semibold text-dark">CV. Sejahtera Mandiri</h3>
                                    <p class="text-gray-600 text-sm">Akuntansi & Keuangan</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Aktif</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div>
                                    <h3 class="font-semibold text-dark">PT. Industri Berkat</h3>
                                    <p class="text-gray-600 text-sm">Manufaktur</p>
                                </div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">Baru</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <div>
                                    <h3 class="font-semibold text-dark">PT. Digital Kreatif</h3>
                                    <p class="text-gray-600 text-sm">Digital Marketing</p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-3 py-1 rounded-full">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aksi Cepat (seperti di gambar) -->
                <div class="bg-white rounded-2xl shadow-md p-6 mb-8 animate-fade-in">
                    <h2 class="text-xl font-bold text-dark mb-6">Aksi Cepat</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-200 card-hover">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-blue-500 p-4 rounded-lg mb-4">
                                    <i class="fas fa-user-plus text-white text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-dark mb-2">Tambah Siswa Baru</h3>
                                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-all duration-300 mt-2">
                                    Aktif <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-5 border border-green-200 card-hover">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-green-500 p-4 rounded-lg mb-4">
                                    <i class="fas fa-building text-white text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-dark mb-2">Daftar Perusahaan Baru</h3>
                                <button class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-all duration-300 mt-2">
                                    Aktif <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-xl p-5 border border-yellow-200 card-hover">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-yellow-500 p-4 rounded-lg mb-4">
                                    <i class="fas fa-file-contract text-white text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-dark mb-2">Buat Surat Penjajakan</h3>
                                <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition-all duration-300 mt-2">
                                    Aktif <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-5 border border-red-200 card-hover">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-red-500 p-4 rounded-lg mb-4">
                                    <i class="fas fa-print text-white text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-dark mb-2">Cetak Surat Penempatan</h3>
                                <button class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-all duration-300 mt-2">
                                    Aktif <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas Terbaru (seperti di gambar) -->
                <div class="bg-white rounded-2xl shadow-md p-6 mb-8 animate-fade-in" style="animation-delay: 0.2s">
                    <h2 class="text-xl font-bold text-dark mb-6">Aktivitas Terbaru</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <div class="flex items-start mb-3">
                                <div class="bg-blue-100 p-3 rounded-lg mr-3">
                                    <i class="fas fa-user-plus text-blue-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Siswa baru ditambahkan</p>
                                    <p class="text-gray-500 text-xs">Andi Pratama (TKJ)</p>
                                </div>
                            </div>
                            <button class="w-full bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium px-3 py-2 rounded-lg transition-colors duration-200">
                                Detail <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <div class="flex items-start mb-3">
                                <div class="bg-green-100 p-3 rounded-lg mr-3">
                                    <i class="fas fa-file-signature text-green-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Surat penempatan dicetak</p>
                                    <p class="text-gray-500 text-xs">Untuk PT. Teknologi Maju</p>
                                </div>
                            </div>
                            <button class="w-full bg-green-100 hover:bg-green-200 text-green-700 text-sm font-medium px-3 py-2 rounded-lg transition-colors duration-200">
                                Detail <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <div class="flex items-start mb-3">
                                <div class="bg-purple-100 p-3 rounded-lg mr-3">
                                    <i class="fas fa-building text-purple-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Perusahaan baru ditambahkan</p>
                                    <p class="text-gray-500 text-xs">PT. Digital Kreatif</p>
                                </div>
                            </div>
                            <button class="w-full bg-purple-100 hover:bg-purple-200 text-purple-700 text-sm font-medium px-3 py-2 rounded-lg transition-colors duration-200">
                                Detail <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <div class="flex items-start mb-3">
                                <div class="bg-yellow-100 p-3 rounded-lg mr-3">
                                    <i class="fas fa-user-check text-yellow-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Pembimbing ditugaskan</p>
                                    <p class="text-gray-500 text-xs">Bapak Ahmad untuk 5 siswa</p>
                                </div>
                            </div>
                            <button class="w-full bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-sm font-medium px-3 py-2 rounded-lg transition-colors duration-200">
                                Detail <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t p-4 text-center text-gray-500 text-sm animate-fade-in">
                <p>© 2025 Sistem Pengelolaan Peserta PKL SMK Negri 1 Wonosobo. <span class="text-primary font-medium">Versi 1.0</span></p>
            </footer>
        </div>
    </div>

    <script>
        function updateDateTime() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();

            // Format waktu
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();

            // Tambahkan nol di depan jika perlu
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Update elemen HTML
            document.getElementById('current-date').textContent = `${dayName}, ${date} ${monthName} ${year}`;
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Update waktu setiap detik
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Jalankan sekali saat halaman dimuat

        // Toggle Floating Menu untuk Mobile
        document.getElementById('float-menu-btn').addEventListener('click', function() {
            document.getElementById('float-menu-content').classList.toggle('active');
        });

        // Tutup floating menu saat klik di luar
        document.addEventListener('click', function(event) {
            const floatMenu = document.getElementById('float-menu-content');
            const floatBtn = document.getElementById('float-menu-btn');

            if (!floatMenu.contains(event.target) && !floatBtn.contains(event.target)) {
                floatMenu.classList.remove('active');
            }
        });

        // Toggle Sidebar untuk Mobile (jika masih ingin ada toggle di pojok kiri atas)
        // Tombol ini disembunyikan karena kita pakai floating menu
        // Tapi kita tetap pertahankan kode untuk kompatibilitas

        // Toggle Profile Menu dengan animasi chevron
        document.getElementById('profile-toggle').addEventListener('click', function() {
            const profileMenu = document.getElementById('profile-menu');
            const chevron = document.getElementById('profile-chevron');

            profileMenu.classList.toggle('hidden');

            if (profileMenu.classList.contains('hidden')) {
                chevron.style.transform = 'rotate(0deg)';
            } else {
                chevron.style.transform = 'rotate(180deg)';
            }
        });

        // Animasi untuk counter statistik
        function animateCounter(elementId, targetValue) {
            const element = document.getElementById(elementId);
            let currentValue = 0;
            const increment = targetValue / 50;
            const timer = setInterval(() => {
                currentValue += increment;
                if (currentValue >= targetValue) {
                    element.textContent = targetValue;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(currentValue);
                }
            }, 30);
        }

        // Inisialisasi Chart.js untuk grafik per jurusan (8 jurusan)
        function initCharts() {
            // Chart untuk TKJ
            const ctxTkj = document.getElementById('chart-tkj').getContext('2d');
            new Chart(ctxTkj, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Sedang PKL', 'Menunggu'],
                    datasets: [{
                        data: [30, 18, 4],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#f59e0b'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });

            // Chart untuk RPL
            const ctxRpl = document.getElementById('chart-rpl').getContext('2d');
            new Chart(ctxRpl, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Sedang PKL', 'Menunggu'],
                    datasets: [{
                        data: [25, 20, 3],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#f59e0b'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });

            // Chart untuk MM
            const ctxMm = document.getElementById('chart-mm').getContext('2d');
            new Chart(ctxMm, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Sedang PKL', 'Menunggu'],
                    datasets: [{
                        data: [20, 10, 2],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#f59e0b'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });

            // Chart untuk AKL
            const ctxAkl = document.getElementById('chart-akl').getContext('2d');
            new Chart(ctxAkl, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Sedang PKL', 'Menunggu'],
                    datasets: [{
                        data: [18, 8, 2],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#f59e0b'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });

            // Chart untuk TKR
            const ctxTkr = document.getElementById('chart-tkr').getContext('2d');
            new Chart(ctxTkr, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Sedang PKL', 'Menunggu'],
                    datasets: [{
                        data: [22, 14, 2],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#f59e0b'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });

            // Chart untuk TSM
            const ctxTsm = document.getElementById('chart-tsm').getContext('2d');
            new Chart(ctxTsm, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Sedang PKL', 'Menunggu'],
                    datasets: [{
                        data: [20, 12, 2],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#f59e0b'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });

            // Chart untuk APHP
            const ctxAphp = document.getElementById('chart-aphp').getContext('2d');
            new Chart(ctxAphp, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Sedang PKL', 'Menunggu'],
                    datasets: [{
                        data: [16, 8, 2],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#f59e0b'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });

            // Chart untuk TO
            const ctxTo = document.getElementById('chart-to').getContext('2d');
            new Chart(ctxTo, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Sedang PKL', 'Menunggu'],
                    datasets: [{
                        data: [14, 6, 2],
                        backgroundColor: [
                            '#10b981',
                            '#3b82f6',
                            '#f59e0b'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });
        }

        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Simulasi data dari server
            animateCounter('student-count', 148);
            animateCounter('mentor-count', 24);
            animateCounter('company-count', 42);
            animateCounter('letter-count', 89);

            // Inisialisasi grafik
            initCharts();

            // Efek pencarian
            const searchInput = document.getElementById('search-input');
            searchInput.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-primary');
            });

            searchInput.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-primary');
            });

            // Efek hover untuk semua card dengan animasi
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.01)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Simulasi klik menu
            const menuItems = document.querySelectorAll('nav a');
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Hapus active class dari semua menu
                    menuItems.forEach(i => i.classList.remove('active-menu'));

                    // Tambahkan active class ke menu yang diklik
                    this.classList.add('active-menu');
                });
            });

            // Animasi untuk tombol
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('mousedown', function() {
                    this.style.transform = 'scale(0.95)';
                });

                button.addEventListener('mouseup', function() {
                    this.style.transform = 'scale(1)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });

        // Responsif: Sembunyikan floating menu di desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.getElementById('float-menu-content').classList.remove('active');
            }
        });
    </script>
</body>
</html>
