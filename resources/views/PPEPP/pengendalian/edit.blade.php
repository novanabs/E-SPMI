@extends('layouts.app')

@section('title', 'Pengendalian')

@section('content')

    <h3>Edit Laporan Pengendalian</h3>
    <p class="text-danger my-3">*Wajib</p>
    <form action="{{ route('pengendalian.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="name">Nama Laporan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Dokumen"
                value="{{ old('name', $data->name) }}" readonly>
        </div>
        <div class="form-group">
            <label for="link_bukti_laporan">Link Laporan <span class="text-danger">*</span></label>
            <input type="text"
                class="form-control @error('link_bukti_laporan')
                is-invalid
            @enderror"
                id="link_bukti_laporan" name="link_bukti_laporan" placeholder="Masukkan Link Laporan"
                value="{{ old('link_bukti_laporan', $data->link_bukti_laporan) }}">
            @error('link_bukti_laporan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-sm btn-primary">Simpan</button>
    </form>

@endsection
