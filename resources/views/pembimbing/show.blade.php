@extends('layouts.app')

@section('title', 'Detail Pembimbing')

@section('content')

@php
    $role = auth()->user()->role;
@endphp

{{-- ================= HEADER ================= --}}
<div class="mb-6">
    <div class="greeting-card rounded-2xl shadow-lg p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-3xl md:text-4xl font-bold">
                    {{ $pembimbing->nama }}
                </h1>
                <p class="text-white/80 mt-1">
                    NIP: {{ $pembimbing->nip }}
                </p>
            </div>

            <div class="flex gap-3">
                @if(in_array($role, ['super_admin', 'admin_jurusan']))
                    <a href="{{ route('pembimbing.edit', $pembimbing->id_pembimbing) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded-xl shadow transition">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                @endif

                <a href="{{ route('pembimbing.index') }}"
                    class="bg-white text-primary px-5 py-3 rounded-xl shadow hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

        </div>
    </div>
</div>

{{-- ================= INFORMASI PEMBIMBING ================= --}}
<div class="bg-white rounded-2xl shadow p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">
        Informasi Pembimbing
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <p><strong>Pangkat:</strong> {{ $pembimbing->pangkat ?? '-' }}</p>
        <p><strong>Golongan:</strong> {{ $pembimbing->golongan ?? '-' }}</p>
        <p><strong>Jabatan:</strong> {{ $pembimbing->jabatan ?? '-' }}</p>
        <p><strong>No HP:</strong> {{ $pembimbing->no_hp ?? '-' }}</p>
        <p><strong>Jurusan:</strong> {{ optional($pembimbing->jurusan)->jurusan ?? '-' }}</p>
        <p><strong>Total Jam Ajar:</strong> {{ $pembimbing->jumlah_jam_mengajar }} Jam</p>
    </div>
</div>

{{-- ================= DUDI YANG DIBIMBING ================= --}}
<div class="bg-white rounded-2xl shadow p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">
        DUDI yang Dibimbing
    </h2>

    @if ($pembimbing->dudis->count())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($pembimbing->dudis as $dudi)
                <div class="border rounded-xl p-4 hover:shadow transition">
                    <h3 class="font-semibold text-lg mb-1">
                        {{ $dudi->nama }}
                    </h3>
                    <p class="text-sm text-gray-600 mb-1">
                        {{ $dudi->alamat }}
                    </p>
                    <p class="text-sm">
                        <strong>Pimpinan:</strong> {{ $dudi->pimpinan ?? '-' }}
                    </p>
                    <p class="text-sm">
                        <strong>Kuota:</strong>
                        {{ $dudi->siswas->count() }} / {{ $dudi->daya_tampung }}
                    </p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 italic">
            Belum terhubung dengan DUDI manapun
        </p>
    @endif
</div>

{{-- ================= DAFTAR SISWA ================= --}}
<div class="bg-white rounded-2xl shadow p-6">
    <h2 class="text-xl font-bold mb-4">
        Daftar Siswa Bimbingan
    </h2>

    @if ($pembimbing->siswas->count())
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama Siswa</th>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-left">DUDI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembimbing->siswas as $index => $siswa)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $siswa->nama }}</td>
                            <td class="px-4 py-3">{{ $siswa->kelas }}</td>
                            <td class="px-4 py-3">
                                {{ optional($siswa->dudi)->nama ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500 italic">
            Belum ada siswa bimbingan
        </p>
    @endif
</div>

@endsection
