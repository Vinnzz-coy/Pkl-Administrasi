<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrasi PKL</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-gray-100">

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

    <div id="overlay"
        class="fixed inset-0 bg-black bg-opacity-40 hidden z-10"
        onclick="toggleSidebar()"></div>

    <nav class="bg-white shadow-lg fixed top-0 left-0 right-0 px-6 py-4 flex items-center justify-between z-30">

        <div class="flex items-center gap-4">

            <button onclick="toggleSidebar()" class="text-gray-700 text-2xl">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="flex items-center gap-3">
                <img src="{{ asset('public/app/asset/smk.png') }}" class="h-10 w-10">
                <h2 class="text-2xl font-bold text-gray-700">Dashboard PKL</h2>
            </div>
        </div>

        <!-- Profil + Notifikasi -->
        <div class="flex items-center gap-6">

            <!-- Notifikasi -->
            <button class="relative">
                <i class="fa-solid fa-bell text-gray-600 text-xl"></i>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                    
                </span>
            </button>

            <!-- Profil -->
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="font-semibold text-gray-700">Admin</p>
                    <p class="text-sm text-gray-500">Administrator</p>
                </div>

                <img src="https://ui-avatars.com/api/?name=Admin"
                     class="w-10 h-10 rounded-full shadow" />
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

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>

    <script>
        const ctx = document.getElementById('absensiChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Senin","Selasa","Rabu","Kamis","Jumat"],
                datasets: [
                    {
                        label: "Hadir",
                        data: [35, 40, 38, 45, 50],
                        borderColor: "#4f46e5",
                        backgroundColor: "rgba(79,70,229,0.3)",
                        borderWidth: 2,
                        tension: 0.3
                    },
                    {
                        label: "Tidak Hadir",
                        data: [5, 2, 4, 3, 1],
                        borderColor: "#ef4444",
                        backgroundColor: "rgba(239,68,68,0.3)",
                        borderWidth: 2,
                        tension: 0.3
                    }
                ]
            }
        });
    </script>

</body>
</html>
