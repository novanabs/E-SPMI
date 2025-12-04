@extends('layouts.app')

@section('title', 'Evaluasi')

@section('content')

    <h3>Tambah Laporan Evaluasi</h3>
    <p class="text-danger my-3">*Wajib</p>
    <form action="{{ route('evaluasi.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="aspek">Aspek <span class="text-danger">*</span></label>
            <select class="form-select @error('aspek') is-invalid @enderror" name="aspek" id="aspek">
                <option value="" disabled selected>-- Pilih Aspek --</option>
                <option value="Pendidikan" {{ old('aspek') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                <option value="Penelitian" {{ old('aspek') == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                <option value="Pengabdian" {{ old('aspek') == 'Pengabdian' ? 'selected' : '' }}>Pengabdian</option>
            </select>
            @error('aspek')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="jenis_laporan">Jenis Laporan <span class="text-danger">*</span></label>
            <select class="form-select @error('jenis_laporan') is-invalid @enderror" name="jenis_laporan"
                id="jenis_laporan">
                <option value="" disabled selected>-- Pilih Jenis Laporan --</option>
                <option value="AMI" {{ old('jenis_laporan') == 'AMI' ? 'selected' : '' }}>AMI</option>
                <option value="Monev_jurusan" {{ old('jenis_laporan') == 'Monev_jurusan' ? 'selected' : '' }}>Monev Jurusan
                </option>
                <option value="Survey" {{ old('jenis_laporan') == 'Survey' ? 'selected' : '' }}>Survey</option>
            </select>
            @error('jenis_laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="link_bukti_laporan">Link Bukti Laporan <span class="text-danger">*</span></label>
            <input type="url" class="form-control @error('link_bukti_laporan') is-invalid @enderror"
                id="link_bukti_laporan" name="link_bukti_laporan" placeholder="Masukkan Link Bukti Laporan"
                value="{{ old('link_bukti_laporan') }}">
            @error('link_bukti_laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-sm btn-primary">Simpan</button>
    </form>


@endsection
