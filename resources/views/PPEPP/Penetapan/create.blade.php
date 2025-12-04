@extends('layouts.app')

@section('title', 'Penetapan')

@section('content')

    <h3>Tambah Dokumen Penetapan</h3>
    <p class="text-danger my-3">*Wajib</p>
    <form action="{{ route('penetapan.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Nama Dokumen <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name')
                is-invalid
            @enderror"
                id="name" name="name" placeholder="Masukkan Nama Dokumen" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="link_bukti_dokumen">Link Dokumen <span class="text-danger">*</span></label>
            <input type="url"
                class="form-control @error('link_bukti_dokumen')
                is-invalid
            @enderror"
                id="link_bukti_dokumen" name="link_bukti_dokumen" placeholder="Masukkan Link Dokumen"
                value="{{ old('link_bukti_dokumen') }}">
            @error('link_bukti_dokumen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-sm btn-primary">Simpan</button>
    </form>


@endsection
