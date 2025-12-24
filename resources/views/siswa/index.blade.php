@extends('layouts.app')

@section('title', 'Data Siswa PKL')

@section('content')

<div class="greeting-card rounded-2xl shadow-lg p-6 md:p-8 bg-linear-to-r from-blue-500 to-blue-600 text-white mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        <!-- JUDUL + TOTAL -->
        <div>
            <h1 class="text-3xl md:text-4xl font-bold">
                Data Siswa PKL
            </h1>

            <p class="mt-2 text-sm md:text-base text-white/80">
                Total Siswa:
                <span class="font-semibold text-white">
                    {{ $total ?? 0 }}
                </span>
            </p>
        </div>

        <!-- TOMBOL -->
        <div>
            <a href="{{ route('siswa.create') }}"
            class="inline-flex items-center justify-center bg-white text-blue-600 px-5 py-3 rounded-xl font-semibold shadow hover:bg-blue-50 transition whitespace-nowrap">
                + Tambah Siswa
            </a>
        </div>

    </div>
</div>


<!-- ================= CONTENT ================= -->

    <!-- ============ FILTERS ============ -->
    <form method="GET" class="bg-white p-5 rounded-xl shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-sm font-medium">Cari Siswa</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full mt-1 px-3 py-2 border rounded-lg"
                    placeholder="Nama, NIS, atau Perusahaan...">
            </div>
            <div>
                <label class="text-sm font-medium">Jurusan</label>
                <select name="jurusan" class="w-full mt-1 px-3 py-2 border rounded-lg">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusan as $j)
                        <option value="{{ $j->id_jurusan }}"
                            @selected(request('jurusan') == $j->id_jurusan)>
                            {{ $j->jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-3">
    <!-- FILTER -->
    <button type="submit"
        class="flex items-center justify-center gap-2 w-full bg-blue-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow hover:bg-blue-700 transition">
        <!-- Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 12.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-4.586L3.293 6.707A1 1 0 013 6V4z"/>
        </svg>
        Filter
    </button>

    <!-- REFRESH -->
    <a href="{{ route('siswa.index') }}"
       class="flex items-center justify-center gap-2 w-full bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-gray-300 transition">
        <!-- Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4v6h6M20 20v-6h-6M5 19a9 9 0 0014-7M19 5a9 9 0 00-14 7"/>
        </svg>
        Reset
    </a>
</div>

        </div>
    </form>

    {{-- ================= TABEL SISWA ================= --}}
    <div class="hidden md:block bg-white rounded-2xl shadow-md p-6">

        {{-- FLASH MESSAGE --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">JK</th>
                        <th class="px-4 py-3">Jurusan</th>
                        <th class="px-4 py-3">Pembimbing</th>
                        <th class="px-4 py-3">DUDI</th>
                        <th class="px-4 py-3 text-center">Kelas</th>
                        <th class="px-4 py-3 text-center">Kendaraan</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($siswa as $row)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-4 py-3">
                            {{ $siswa->firstItem() + $loop->index }}
                        </td>

                        <td class="px-4 py-3 font-medium">
                            {{ $row->nama }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $row->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $row->jurusan->jurusan ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $row->pembimbing->nama ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $row->dudi->nama ?? '-' }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $row->kelas }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $row->kendaraan === 'pribadi' ? 'Pribadi' : 'Umum' }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">

                                {{-- EDIT --}}
                                <a href="{{ route('siswa.edit', $row->id_siswa) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-xs">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('siswa.destroy', $row->id_siswa) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-xs">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-500">
                            Data siswa belum tersedia
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $siswa->withQueryString()->links() }}
        </div>
    </div>

</div>
@endsection
