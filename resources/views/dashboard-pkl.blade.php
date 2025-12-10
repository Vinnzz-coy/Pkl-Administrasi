<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrasi PKL</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .profile-dropdown {
            z-index: 40;
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- SIDEBAR -->
    <div id="sidebar"
        class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg transform -translate-x-full transition-transform duration-300 z-20">

        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-indigo-600">Admin PKL</h1>
            <p class="text-sm text-gray-500">SMK Negeri 1 Wonosobo</p>
        </div>

        <nav class="p-4 space-y-1">
            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-100">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-100">
                <i class="fa-solid fa-users"></i> Data Siswa PKL
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-100">
                <i class="fa-solid fa-user-tie"></i> Data Pembimbing
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-100">
                <i class="fa-solid fa-building"></i> Data Perusahaan
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-100">
                <i class="fa-solid fa-calendar-check"></i> Absensi PKL
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-100">
                <i class="fa-solid fa-file-lines"></i> Laporan PKL
            </a>

            <a href="{{ route('cetak.surat.penjajakan') }}" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-100">
                <i class="fa-solid fa-plus-circle"></i> Buat Surat Penjajakan
            </a>

            <a href="{{ route('cetak.surat.penempatan') }}" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-100">
                <i class="fa-solid fa-envelope"></i> Cetak Surat Penempatan
            </a>

            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-indigo-100">
                <i class="fa-solid fa-gear"></i> Pengaturan
            </a>
        </nav>
    </div>

    <!-- OVERLAY -->
    <div id="overlay"
        class="fixed inset-0 bg-black bg-opacity-40 hidden z-10"></div>

    <!-- NAVBAR -->
    <nav class="bg-white shadow-lg fixed top-0 left-0 right-0 px-6 py-4 flex items-center justify-between z-30">

        <div class="flex items-center gap-4">

            <button id="btnSidebar" class="text-gray-700 text-2xl">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="flex items-center gap-3">
                <img src="{{ asset('logo-smk.webp') }}" alt="Logo SMK" class="logo-img" style="width:40px; height:40px;">
                <h2 class="text-2xl font-bold text-gray-700">Dashboard PKL</h2>
            </div>
        </div>

        <div class="flex items-center gap-6">

            <button class="relative">
                <i class="fa-solid fa-bell text-gray-600 text-xl"></i>
            </button>

            <div class="relative">
                <button id="profileButton"
                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 transition duration-150">

                    <div class="text-right hidden sm:block">
                        <p class="font-semibold text-gray-700 text-sm">Admin</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>

                    <img src="https://ui-avatars.com/api/?name=Admin"
                        class="w-10 h-10 rounded-full shadow" />
                </button>

                <div id="profileDropdownMenu"
                    class="profile-dropdown absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 hidden">

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                        <i class="fa-solid fa-user"></i> My Profile
                    </a>

                    <div class="border-t border-gray-100 my-1"></div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <main class="p-6 pt-28">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="p-6 bg-white rounded-xl shadow hover:shadow-xl transition">
                <p class="text-gray-500">Total Siswa PKL</p>
                <h3 class="text-3xl font-bold text-indigo-600">120</h3>
            </div>

            <div class="p-6 bg-white rounded-xl shadow hover:shadow-xl transition">
                <p class="text-gray-500">Pembimbing</p>
                <h3 class="text-3xl font-bold text-green-600">15</h3>
            </div>

            <div class="p-6 bg-white rounded-xl shadow hover:shadow-xl transition">
                <p class="text-gray-500">Perusahaan Mitra</p>
                <h3 class="text-3xl font-bold text-yellow-600">18</h3>
            </div>

            <div class="p-6 bg-white rounded-xl shadow hover:shadow-xl transition">
                <p class="text-gray-500">Laporan Masuk</p>
                <h3 class="text-3xl font-bold text-red-600">33</h3>
            </div>

        </div>

        <div class="bg-white p-6 rounded-xl shadow mt-10">
            <h3 class="text-xl font-semibold mb-4">Grafik Kehadiran PKL</h3>
            <canvas id="absensiChart"></canvas>
        </div>

    </main>

</body>
</html>
