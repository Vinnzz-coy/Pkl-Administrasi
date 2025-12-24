@extends('layouts.app')

@section('title', 'Data Pembimbing')

@section('content')

@php
    $role = auth()->user()->role;
@endphp

{{-- ================= HEADER ================= --}}
<div class="mb-6">
    <div class="greeting-card rounded-2xl shadow-lg p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-1">
                    Data Pembimbing
                </h1>
                <p class="text-white/80 text-sm">
                    Daftar pembimbing PKL sekolah
                </p>
            </div>
        </div>
    </div>
</div>

{{-- ================= STATISTIK ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-md p-6">
        <p class="text-gray-500 text-sm">Total Pembimbing</p>
        <p class="text-3xl font-bold text-dark">
            {{ $pembimbing->total() }}
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6">
        <p class="text-gray-500 text-sm">Total Jam Mengajar</p>
        <p class="text-3xl font-bold text-dark">
            {{ $pembimbing->sum('jumlah_jam_mengajar') }}
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6">
        <p class="text-gray-500 text-sm">Rata-rata Jam</p>
        <p class="text-3xl font-bold text-dark">
            {{ round($pembimbing->avg('jumlah_jam_mengajar')) }}
        </p>
    </div>
</div>

{{-- ================= TABEL DESKTOP ================= --}}
<div class="hidden md:block bg-white rounded-2xl shadow-md p-6">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-4">

        <form method="GET" class="flex gap-2 w-full md:w-2/3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama / NIP pembimbing..."
                class="border rounded-lg px-4 py-2 w-full">
            <button class="bg-primary text-white px-4 py-2 rounded-lg">
                Cari
            </button>
        </form>

        @if(in_array($role, ['super_admin', 'admin_jurusan']))
            <a href="{{ route('pembimbing.create') }}"
                class="bg-primary text-white px-5 py-3 rounded-xl shadow hover:bg-blue-600 transition">
                + Tambah Pembimbing
            </a>
        @endif
    </div>

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
                    <th class="px-4 py-3">NIP</th>
                    <th class="px-4 py-3">Jabatan</th>
                    <th class="px-4 py-3 text-center">Jam</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($pembimbing as $item)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-3">
                        {{ $pembimbing->firstItem() + $loop->index }}
                    </td>

                    <td class="px-4 py-3 font-medium">
                        {{ $item->nama }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->nip }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->jabatan ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        {{ $item->jumlah_jam_mengajar }} jam
                    </td>

                    <td class="px-4 py-3" onclick="event.stopPropagation()">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('pembimbing.show', $item->id_pembimbing) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-xs">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('pembimbing.edit', $item->id_pembimbing) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-xs">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('pembimbing.destroy', $item->id_pembimbing) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus pembimbing ini?')">
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
                    <td colspan="6" class="text-center py-8 text-gray-500">
                        Data pembimbing belum tersedia
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pembimbing->withQueryString()->links() }}
    </div>
</div>

{{-- ================= MOBILE VIEW ================= --}}
<div class="md:hidden space-y-4">
@foreach($pembimbing as $item)
    <div class="bg-white rounded-xl shadow p-4">
        <h3 class="font-bold text-lg">{{ $item->nama }}</h3>
        <p class="text-sm text-gray-500">NIP: {{ $item->nip }}</p>
        <p class="text-sm mt-1">Jabatan: {{ $item->jabatan ?? '-' }}</p>

        <div class="flex gap-2 mt-4">
            <a href="{{ route('pembimbing.show', $item->id_pembimbing) }}"
                class="flex-1 bg-blue-500 text-white py-2 rounded-lg text-center">
                Detail
            </a>

            @if(in_array($role, ['super_admin', 'admin_jurusan']))
                <a href="{{ route('pembimbing.edit', $item->id_pembimbing) }}"
                    class="flex-1 bg-yellow-500 text-white py-2 rounded-lg text-center">
                    Edit
                </a>
            @endif
        </div>
    </div>
@endforeach
</div>

@endsection
