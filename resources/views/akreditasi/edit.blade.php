@extends('layouts.app')

@section('title', 'Edit Akreditasi')

@section('content')

    <h3>Edit Akreditasi Jurusan</h3>
    <p class="text-danger my-3">*Wajib</p>

    <form action="{{ route('akreditasi.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Jurusan --}}
        <div class="form-group mb-3">
            <label for="nama_jurusan">Nama Jurusan <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror" id="nama_jurusan"
                name="nama_jurusan" placeholder="Masukkan Nama Jurusan"
                value="{{ old('nama_jurusan', $data->nama_jurusan) }}">

            @error('nama_jurusan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Akreditasi --}}
        <div class="form-group mb-3">
            <label for="akreditasi">Akreditasi <span class="text-danger">*</span></label>
            <select class="form-control @error('akreditasi') is-invalid @enderror" id="akreditasi" name="akreditasi">
                <option value="">-- Pilih Akreditasi --</option>
                <option value="Unggul" {{ old('akreditasi', $data->akreditasi) == 'Unggul' ? 'selected' : '' }}>
                    Unggul
                </option>
                <option value="A" {{ old('akreditasi', $data->akreditasi) == 'A' ? 'selected' : '' }}>
                    A
                </option>
                <option value="B" {{ old('akreditasi', $data->akreditasi) == 'B' ? 'selected' : '' }}>
                    B
                </option>
                <option value="Baik" {{ old('akreditasi', $data->akreditasi) == 'Baik' ? 'selected' : '' }}>
                    Baik
                </option>
            </select>

            @error('akreditasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Nomor SK --}}
        <div class="form-group mb-3">
            <label for="nomor_sk">Nomor SK <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nomor_sk') is-invalid @enderror" id="nomor_sk"
                name="nomor_sk" placeholder="Masukkan Nomor SK" value="{{ old('nomor_sk', $data->nomor_sk) }}">

            @error('nomor_sk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Tanggal SK --}}
        <div class="form-group mb-3">
            <label for="tanggal_sk">Tanggal SK <span class="text-danger">*</span></label>
            <input type="date" class="form-control @error('tanggal_sk') is-invalid @enderror" id="tanggal_sk"
                name="tanggal_sk" value="{{ old('tanggal_sk', $data->tanggal_sk) }}">

            @error('tanggal_sk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Tanggal Kadaluarsa --}}
        <div class="form-group mb-3">
            <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa <span class="text-danger">*</span></label>
            <input type="date" class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror"
                id="tanggal_kadaluarsa" name="tanggal_kadaluarsa"
                value="{{ old('tanggal_kadaluarsa', $data->tanggal_kadaluarsa) }}">

            @error('tanggal_kadaluarsa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Dokumen --}}
        <div class="form-group">
            <label for="dokumen">Link Dokumen <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('dokumen') is-invalid @enderror" id="dokumen" name="dokumen"
                placeholder="Masukkan Link Dokumen" value="{{ old('dokumen', $data->dokumen) }}">

            @error('dokumen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-sm btn-success">
            Simpan
        </button>

        <a href="{{ route('akreditasi.index') }}" class="mt-3 btn btn-sm btn-secondary">
            Kembali
        </a>
    </form>

@endsection
