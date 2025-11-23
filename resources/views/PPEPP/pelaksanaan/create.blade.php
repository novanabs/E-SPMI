@extends('layouts.app')

@section('title', 'Pelaksanaan')

@section('content')

    <h3>Tambah Laporan Pelaksanaan</h3>
    <form action="{{ route('pelaksanaan.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Nama laporan</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama laporan"
                value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="link_bukti_laporan">Link bukti laporan</label>
            <input type="text" class="form-control" id="link_bukti_laporan" name="link_bukti_laporan"
                placeholder="Masukkan Link laporan" value="{{ old('link_bukti_laporan') }}">
            @error('link_bukti_laporan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="nama_mitra">Nama mitra (Opsional)</label>
            <input type="text" class="form-control" id="nama_mitra" name="nama_mitra" placeholder="Masukkan nama mitra"
                value="{{ old('nama_mitra') }}">
            @error('nama_mitra')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="link_bukti_kerjasama">Link bukti kerjasama (Opsional)</label>
            <input type="text" class="form-control" id="link_bukti_kerjasama" name="link_bukti_kerjasama"
                placeholder="Masukkan Link bukti kerjasama" value="{{ old('link_bukti_kerjasama') }}">
            @error('link_bukti_kerjasama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-sm btn-primary">Simpan</button>
    </form>

@endsection
