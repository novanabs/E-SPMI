@extends('layouts.app')

@section('title', 'Dokumen')

@section('content')

    <h3>Edit Dokumen</h3>
    <p class="text-danger my-3">*Wajib</p>
    <form action="{{ route('dokumen.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="name">Nama Dokumen <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name')
                is-invalid
            @enderror"
                id="name" name="name" placeholder="Masukkan Nama Dokumen" value="{{ old('name', $data->name) }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea type="text" class="form-control @error('deskripsi')
                is-invalid
            @enderror"
                id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi">{{ old('deskripsi', $data->deskripsi) }}</textarea>
        </div>
        <div class="form-group">
            <label for="link_dokumen">Link Dokumen <span class="text-danger">*</span></label>
            <input type="text"
                class="form-control @error('link_dokumen')
                is-invalid
            @enderror"
                id="link_dokumen" name="link_dokumen" placeholder="Masukkan Link Dokumen"
                value="{{ old('link_dokumen', $data->link_dokumen) }}">
            @error('link_dokumen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-sm btn-success">Simpan</button>
    </form>

@endsection
