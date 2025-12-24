@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="mb-6 animate-slide-down">
    <div class="greeting-card rounded-2xl shadow-lg p-6 md:p-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-1">
                    Tambah Siswa PKL
                </h1>
                <p class="text-white/80 text-sm">
                    Lengkapi data siswa peserta PKL
                </p>
            </div>

            <a href="{{ route('siswa.index') }}"
               class="px-6 py-3 rounded-xl bg-white text-primary font-semibold
                      hover:bg-gray-100 transition">
                ← Kembali
            </a>
        </div>
    </div>
</div>

{{-- ================= FORM ================= --}}
<div class="container mx-auto">
    <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 animate-scale-fade">

        <form action="{{ route('siswa.store') }}"
              method="POST"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block font-semibold mb-1">Nama</label>
                <input type="text"
                       name="nama"
                       value="{{ old('nama') }}"
                       required
                       class="form-input"
                       placeholder="Nama lengkap siswa">
            </div>

            {{-- Kelas --}}
            <div>
                <label class="block font-semibold mb-1">Kelas</label>
                <input type="text"
                       name="kelas"
                       value="{{ old('kelas') }}"
                       required
                       class="form-input"
                       placeholder="Contoh: XII">
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block font-semibold mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin"
                        required
                        class="form-input">
                    <option value="">-- Pilih --</option>
                    <option value="L" @selected(old('jenis_kelamin') == 'L')>Laki-laki</option>
                    <option value="P" @selected(old('jenis_kelamin') == 'P')>Perempuan</option>
                </select>
            </div>

            {{-- Kendaraan --}}
            <div>
                <label class="block font-semibold mb-1">Kendaraan</label>
                <select name="kendaraan"
                        required
                        class="form-input">
                    <option value="">-- Pilih --</option>
                    <option value="pribadi" @selected(old('kendaraan') == 'pribadi')>
                        Kendaraan Pribadi
                    </option>
                    <option value="umum" @selected(old('kendaraan') == 'umum')>
                        Kendaraan Umum
                    </option>
                </select>
            </div>

            {{-- Jurusan --}}
            <div>
                <label class="block font-semibold mb-1">Jurusan</label>
                <select name="id_jurusan"
                        class="form-input"
                        {{ auth()->user()->role === 'admin_jurusan' ? 'disabled' : '' }}>
                    <option value="">-- Pilih --</option>
                    @foreach($jurusan as $j)
                        <option value="{{ $j->id_jurusan }}"
                            @selected(old('id_jurusan') == $j->id_jurusan)>
                            {{ $j->jurusan }}
                        </option>
                    @endforeach
                </select>

                @if(auth()->user()->role === 'admin_jurusan')
                    <input type="hidden"
                           name="id_jurusan"
                           value="{{ auth()->user()->jurusan_id }}">
                @endif
            </div>

            {{-- Pembimbing --}}
            <div>
                <label class="block font-semibold mb-1">Pembimbing Sekolah</label>
                <select name="id_pembimbing"
                        required
                        class="form-input">
                    <option value="">-- Pilih --</option>
                    @foreach($pembimbing as $p)
                        <option value="{{ $p->id_pembimbing }}"
                            @selected(old('id_pembimbing') == $p->id_pembimbing)>
                            {{ $p->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- DUDI --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">DUDI</label>
                <select name="id_dudi"
                        required
                        class="form-input">
                    <option value="">-- Pilih --</option>

                    @foreach($dudi as $d)
                        <option value="{{ $d->id_dudi }}"
                            {{ $d->isPenuh() ? 'disabled' : '' }}
                            @selected(old('id_dudi') == $d->id_dudi)>
                            {{ $d->nama }}
                            ({{ $d->siswas->count() }}/{{ $d->daya_tampung }})
                            {{ $d->isPenuh() ? ' - PENUH' : '' }}
                        </option>
                    @endforeach
                </select>

                <p class="text-xs text-gray-500 mt-1">
                    DUDI yang penuh tidak dapat dipilih
                </p>
            </div>

            {{-- Alamat --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Alamat</label>
                <textarea name="alamat"
                          rows="3"
                          class="form-input"
                          placeholder="Alamat lengkap siswa">{{ old('alamat') }}</textarea>
            </div>

            {{-- BUTTON --}}
            <div class="md:col-span-2 flex justify-between items-center mt-6">

                <a href="{{ route('siswa.index') }}"
                   class="px-6 py-3 rounded-xl border font-semibold
                          hover:bg-gray-100 transition">
                    ← Kembali
                </a>

                <div class="flex gap-3">
                    <a href="{{ route('siswa.index') }}"
                       class="px-6 py-3 rounded-xl border font-semibold
                              hover:bg-gray-100 transition">
                        Batal
                    </a>

                    <button
                        class="bg-primary text-white px-6 py-3 rounded-xl font-semibold
                               hover:bg-primary/90 hover:scale-105
                               transition-all duration-300">
                        <i class="fas fa-save mr-2"></i> Simpan Data
                    </button>
                </div>

            </div>

        </form>
    </div>
</div>

@include('layouts.animation')

@endsection
