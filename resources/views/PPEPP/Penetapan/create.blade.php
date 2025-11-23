@extends('layouts.app')

@section('title', 'Penetapan')

@section('content')

    <h3>Tambah Dokumen Penetapan</h3>
    <form action="{{ route('penetapan.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Nama Dokumen</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Dokumen">
        </div>
        <div class="form-group">
            <label for="link_bukti_dokumen">Link Dokumen</label>
            <input type="text" class="form-control" id="link_bukti_dokumen" name="link_bukti_dokumen"
                placeholder="Masukkan Link Dokumen">
        </div>

        <button type="submit" class="mt-3 btn btn-sm btn-primary">Simpan</button>
    </form>


@endsection
