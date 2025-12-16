@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

</head>
    <div class="mb-6">
        <div class="greeting-card rounded-2xl shadow-lg p-6 md:p-8 bg-linear-to-r from-blue-500 to-blue-600 text-white">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">
                        Dashboard PKL
                    </h1>

                    <p class="text-blue-100 text-lg leading-relaxed">
                        Selamat datang,
                        <span class="font-semibold text-white">
                            {{ auth()->user()->name }}
                        </span>
                        Kelola data peserta PKL dengan mudah dan efisien.
                    </p>
                </div>

                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 min-w-[220px] text-center md:text-right">
                    <p class="text-sm text-blue-100">
                        Hari ini
                    </p>
                    <p class="text-2xl font-bold" id="current-date">
                        --
                    </p>
                    <p class="text-sm text-blue-100 mt-1" id="current-time">
                        --
                    </p>
                </div>

            </div>
        </div>
    </div>


    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card Siswa -->
        <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-slide-up h-full" style="animation-delay: 0.1s">
            <div class="flex justify-between items-start h-full">
                <div class="flex flex-col justify-center">
                    <h3 class="text-gray-500 text-sm font-medium">
                        Siswa PKL
                    </h3>
                    <p class="text-3xl font-bold text-dark mt-2" id="student-count">
                        {{ $siswaCount }}
                    </p>
                </div>
                <div class="bg-blue-100 p-3 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-graduate text-blue-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Card Pembimbing -->
        <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-slide-up h-full" style="animation-delay: 0.2s">
            <div class="flex justify-between items-start h-full">
                <div class="flex flex-col justify-center">
                    <h3 class="text-gray-500 text-sm font-medium">
                        Pembimbing
                    </h3>
                    <p class="text-3xl font-bold text-dark mt-2" id="mentor-count">
                        {{ $pembimbingCount }}
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-green-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Card Perusahaan -->
        <div class="bg-white rounded-2xl shadow-md p-6 card-hover animate-slide-up h-full" style="animation-delay: 0.3s">
            <div class="flex justify-between items-start h-full">
                <div class="flex flex-col justify-center">
                    <h3 class="text-gray-500 text-sm font-medium">
                        Dudi
                    </h3>
                    <p class="text-3xl font-bold text-dark mt-2" id="company-count">
                        {{ $dudiCount }}
                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-purple-500 text-2xl"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Statistik PKL -->
    <div class="bg-white rounded-2xl shadow-md p-6 mb-8 animate-fade-in">
        <h2 class="text-xl font-bold text-dark mb-6">Statistik PKL per Jurusan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($jurusanData as $jurusan => $statusData)
                @php
                    $slug = Str::slug($jurusan, '-');
                @endphp
                <div class="chart-container bg-gray-50 rounded-xl p-4 border border-gray-200 hover:shadow-lg transition-all duration-300">
                    <h3 class="font-bold text-dark mb-4 text-center">{{ $jurusan }}</h3>

                    <div class="relative h-48">
                        <canvas id="chart-{{ $slug }}"></canvas>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            Total Siswa: <span class="font-bold text-dark">{{ array_sum($statusData) }}</span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Siswa Terbaru dan Perusahaan Mitra -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Siswa Terbaru -->
            <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-in">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-dark">Siswa Terbaru</h2>
                    <a {{ route('dashboard') }} class="text-primary font-medium hover:text-secondary transition-colors duration-200 flex items-center">
                        Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            <div class="space-y-4">
                    @foreach($latestSiswa as $siswa)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <div>
                                <h3 class="font-semibold text-dark">{{ $siswa->nama }}</h3>
                                <p class="text-gray-600 text-sm">
                                    Jurusan: {{ $siswa->jurusan->jurusan ?? '-' }}
                                </p>
                                <p class="text-gray-600 text-sm">
                                    DUDI: {{ $siswa->dudi->nama ?? '-' }}
                                </p>
                                <p class="text-gray-600 text-sm">
                                    Pembimbing: {{ $siswa->pembimbing->nama ?? '-' }}
                                </p>
                                <p class="text-gray-600 text-sm">
                                    Kendaraan: {{ $siswa->kendaraan ?? '-' }}
                                </p>
                            </div>
                        <span class="text-xs font-medium px-3 py-1 rounded-full
                            {{ $siswa->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $siswa->status ?? 'Menunggu' }}
                        </span>
                    </div>
            @endforeach
        </div>
    </div>

                    <!-- Perusahaan Mitra -->
                    <div class="bg-white rounded-2xl shadow-md p-6 animate-fade-in" style="animation-delay: 0.2s">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-dark">Dudi Terbaru</h2>
                            <a {{ route('dashboard') }} class="text-primary font-medium hover:text-secondary transition-colors duration-200 flex items-center">
                                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="space-y-4">
                            @foreach($latestDudi as $dudi)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                    <div>
                                        <h3 class="font-semibold text-dark">{{ $dudi->nama }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $dudi->pimpinan }} - {{ $dudi->jabatan }}</p>
                                    </div>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">
                                        Kapasitas: {{ $dudi->daya_tampung }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            <div class="w-full space-y-6 px-0">
                <!-- Aksi Cepat -->
                <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 animate-fade-in w-full">
                    <h2 class="text-xl font-bold text-dark mb-6">Aksi Cepat</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch w-full">
                        <!-- Card Tambah Siswa -->
                        <div class="bg-linear-to-r from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-200 card-hover h-full flex flex-col justify-between">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-blue-500 p-4 rounded-lg mb-4">
                                    <i class="fas fa-user-plus text-white text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-dark mb-2">Tambah Siswa Baru</h3>
                            </div>
                            <button onclick="window.location='{{ route('siswa.index') }}'"
                                    class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mt-2 transition-all duration-300">
                                Aktif <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>

                        <!-- Card Daftar Perusahaan -->
                        <div class="bg-linear-to-r from-green-50 to-green-100 rounded-xl p-5 border border-green-200 card-hover h-full flex flex-col justify-between">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-green-500 p-4 rounded-lg mb-4">
                                    <i class="fas fa-building text-white text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-dark mb-2">Daftar Perusahaan Baru</h3>
                            </div>
                            <button onclick="window.location='{{ route('dashboard') }}'"
                                    class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg mt-2 transition-all duration-300">
                                Aktif <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>

                        <!-- Card Buat Surat Penjajakan -->
                        <div class="bg-linear-to-r from-yellow-50 to-yellow-100 rounded-xl p-5 border border-yellow-200 card-hover h-full flex flex-col justify-between">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-yellow-500 p-4 rounded-lg mb-4">
                                    <i class="fas fa-file-contract text-white text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-dark mb-2">Buat Surat Penjajakan</h3>
                            </div>
                            <button onclick="window.location='{{ route('dashboard') }}'"
                                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg mt-2 transition-all duration-300">
                                Aktif <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>

                        <!-- Card Cetak Surat Penempatan -->
                        <div class="bg-linear-to-r from-red-50 to-red-100 rounded-xl p-5 border border-red-200 card-hover h-full flex flex-col justify-between">
                            <div class="flex flex-col items-center text-center">
                                <div class="bg-red-500 p-4 rounded-lg mb-4">
                                    <i class="fas fa-print text-white text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-dark mb-2">Cetak Surat Penempatan</h3>
                            </div>
                            <button onclick="window.location='{{ route('dashboard') }}'"
                                    class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg mt-2 transition-all duration-300">
                                Aktif <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function updateDateTime() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();

            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();

            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            document.getElementById('current-date').textContent = `${dayName}, ${date} ${monthName} ${year}`;
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateDateTime, 1000);
        updateDateTime();

        document.getElementById('float-menu-btn').addEventListener('click', function() {
            document.getElementById('float-menu-content').classList.toggle('active');
        });

        document.addEventListener('click', function(event) {
            const floatMenu = document.getElementById('float-menu-content');
            const floatBtn = document.getElementById('float-menu-btn');

            if (!floatMenu.contains(event.target) && !floatBtn.contains(event.target)) {
                floatMenu.classList.remove('active');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jurusanData = @json($jurusanData);

    Object.keys(jurusanData).forEach(jurusan => {
        const slug = jurusan.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '');
        const canvas = document.getElementById('chart-' + slug);

        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const data = jurusanData[jurusan];

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Sedang', 'Menunggu', 'Selesai'],
                datasets: [{
                    data: [data.Sedang ?? 0, data.Menunggu ?? 0, data.Selesai ?? 0],
                    backgroundColor: ['#3B82F6', '#FBBF24', '#10B981'],
                    borderWidth: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: { display: false }
                },
                cutout: '60%'
            }
        });
    });
});
</script>


@endsection
