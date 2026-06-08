@extends('layouts.app')

@section('title', 'Tambah Penetapan')

@section('content')
    <div class="container py-4">

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">

                <div class="mb-4">
                    <h3 class="fw-bold mb-1">Tambah Dokumen Penetapan</h3>
                    <p class="text-muted mb-0">
                        Silakan lengkapi data dokumen penetapan
                    </p>
                </div>

                <div class="alert alert-danger py-2 px-3 rounded-3">
                    <small><strong>*</strong> Wajib diisi</small>
                </div>

                <form action="{{ route('penetapan.store') }}" method="POST">
                    @csrf

                    {{-- Nama Dokumen --}}
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">
                            Nama Dokumen <span class="text-danger">*</span>
                        </label>

                        <input type="text" id="name" name="name"
                            class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                            placeholder="Masukkan Nama Dokumen" value="{{ old('name') }}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Tanggal Ditetapkan --}}
                    <div class="mb-4">
                        <label for="tanggal_penetapan" class="form-label fw-semibold">
                            Tanggal Ditetapkan <span class="text-danger">*</span>
                        </label>

                        <input type="date" id="tanggal_penetapan" name="tanggal_penetapan"
                            class="form-control form-control-lg rounded-3 @error('tanggal_penetapan') is-invalid @enderror"
                            value="{{ old('tanggal_penetapan') }}">

                        @error('tanggal_penetapan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Tanggal Berakhir --}}
                    <div class="mb-4">
                        <label for="tanggal_berakhir" class="form-label fw-semibold">
                            Tanggal Berakhir
                        </label>

                        <input type="date" id="tanggal_berakhir" name="tanggal_berakhir"
                            class="form-control form-control-lg rounded-3 @error('tanggal_berakhir') is-invalid @enderror"
                            value="{{ old('tanggal_berakhir') }}">

                        @error('tanggal_berakhir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Link Dokumen --}}
                    <div class="mb-4">
                        <label for="link_bukti_dokumen" class="form-label fw-semibold">
                            Link Dokumen <span class="text-danger">*</span>
                        </label>
                        <small class="text-muted d-block mb-2">
                            Pastikan tautan dokumen dapat diakses secara publik (open access) tanpa memerlukan izin atau
                            login.
                        </small>

                        <input type="url" id="link_bukti_dokumen" name="link_bukti_dokumen"
                            class="form-control form-control-lg rounded-3 @error('link_bukti_dokumen') is-invalid @enderror"
                            placeholder="https://example.com/dokumen" value="{{ old('link_bukti_dokumen') }}">

                        @error('link_bukti_dokumen')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Action Button --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success px-4 rounded-3">
                            <i class="bi bi-check-circle me-1"></i>
                            Simpan
                        </button>

                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-3">
                            Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
