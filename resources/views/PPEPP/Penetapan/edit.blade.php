@extends('layouts.app')

@section('title', 'Penetapan')

@section('content')

    <h3>Edit Dokumen Penetapan</h3>
    <form action="{{ route('penetapan.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="name">Nama Dokumen</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Dokumen"
                value="{{ old('name', $data->name) }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="link_bukti_dokumen">Link Dokumen</label>
            <input type="text" class="form-control" id="link_bukti_dokumen" name="link_bukti_dokumen"
                placeholder="Masukkan Link Dokumen" value="{{ old('link_bukti_dokumen', $data->link_bukti_dokumen) }}">
            @error('link_bukti_dokumen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-sm btn-primary">Simpan</button>
    </form>

@endsection
