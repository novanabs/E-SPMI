@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

    <h3>Edit User</h3>
    <p class="text-danger my-3">*Wajib</p>
    <form action="{{ route('user.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="name">Nama User <span class="text-danger">*</span></label>
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
            <label for="homebase">Homebase <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('homebase')
                is-invalid
            @enderror"
                id="homebase" name="homebase" placeholder="Masukkan Nama Dokumen"
                value="{{ old('homebase', $data->homebase) }}">
            @error('homebase')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="ketua">Ketua <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('ketua')
                is-invalid
            @enderror"
                id="ketua" name="ketua" placeholder="Masukkan Nama Dokumen" value="{{ old('ketua', $data->ketua) }}">
            @error('ketua')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control @error('email')
                is-invalid
            @enderror"
                id="email" name="email" placeholder="Masukkan Nama Dokumen" value="{{ old('email', $data->email) }}">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="role">Role <span class="text-danger">*</span></label>
            <select class="form-select @error('role') is-invalid @enderror" name="role" id="role">
                <option value="" disabled selected>-- Pilih Role --</option>
                <option value="pimpinan" {{ old('role', $data->role) == 'pimpinan' ? 'selected' : '' }}>Pimpinan Fakultas
                </option>
                <option value="admin_jurusan" {{ old('role', $data->role) == 'admin_jurusan' ? 'selected' : '' }}>Admin
                    Jurusan</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="mt-3 btn btn-sm btn-success">Simpan</button>
    </form>


@endsection
