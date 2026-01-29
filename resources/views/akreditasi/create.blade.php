@extends('layouts.app')

@section('title', 'Tambah Akreditasi')

@section('content')

    <h3>Tambah Akreditasi Jurusan</h3>
    <p class="text-danger my-3">*Wajib</p>

    <form action="{{ route('akreditasi.store') }}" method="POST">
        @csrf

        {{-- Nama Jurusan --}}
        <div class="form-group mb-3">
            <label for="nama_jurusan">Nama Jurusan <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror" id="nama_jurusan"
                name="nama_jurusan" placeholder="Masukkan Nama Jurusan" value="{{ old('nama_jurusan') }}">

            @error('nama_jurusan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Akreditasi --}}
        <div class="form-group mb-3">
            <label for="akreditasi">Akreditasi <span class="text-danger">*</span></label>
            <select class="form-control @error('akreditasi') is-invalid @enderror" id="akreditasi" name="akreditasi">
                <option value="">-- Pilih Akreditasi --</option>
                <option value="Unggul" {{ old('akreditasi') == 'Unggul' ? 'selected' : '' }}>Unggul</option>
                <option value="A" {{ old('akreditasi') == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ old('akreditasi') == 'B' ? 'selected' : '' }}>B</option>
                <option value="Baik" {{ old('akreditasi') == 'Baik' ? 'selected' : '' }}>Baik</option>
            </select>

            @error('akreditasi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nomor SK --}}
        <div class="form-group mb-3">
            <label for="nomor_sk">Nomor SK <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nomor_sk') is-invalid @enderror" id="nomor_sk"
                name="nomor_sk" placeholder="Masukkan Nomor SK" value="{{ old('nomor_sk') }}">

            @error('nomor_sk')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal SK --}}
        <div class="form-group mb-3">
            <label for="tanggal_sk">Tanggal SK <span class="text-danger">*</span></label>
            <input type="date" class="form-control @error('tanggal_sk') is-invalid @enderror" id="tanggal_sk"
                name="tanggal_sk" value="{{ old('tanggal_sk') }}">

            @error('tanggal_sk')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Kadaluarsa --}}
        <div class="form-group mb-3">
            <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa <span class="text-danger">*</span></label>
            <input type="date" class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror"
                id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa') }}">

            @error('tanggal_kadaluarsa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Dokumen --}}
        <div class="form-group">
            <label for="dokumen">Link Dokumen <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('dokumen')
                is-invalid
            @enderror"
                id="dokumen" name="dokumen" placeholder="Masukkan Link Dokumen" value="{{ old('dokumen') }}">
            @error('dokumen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-sm btn-primary mt-3">
            Simpan
        </button>

        <a href="{{ route('akreditasi') }}" class="btn btn-sm btn-secondary mt-3">
            Kembali
        </a>
    </form>

@endsection
