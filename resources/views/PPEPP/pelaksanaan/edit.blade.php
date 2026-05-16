@extends('layouts.app')

@section('title', 'Pelaksanaan')

@section('content')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* =========================
   PAGE STYLE
========================= */

.page-header {
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
    border-radius: 18px;
    padding: 22px;
    margin-bottom: 24px;
    color: white;
    box-shadow: 0 10px 30px rgba(15,23,42,0.12);
}

.page-title {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 4px;
}

.page-subtitle {
    opacity: .85;
    font-size: 14px;
}

/* =========================
   FORM CARD
========================= */

.form-card {
    background: white;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 10px 30px rgba(15,23,42,0.06);
}

/* =========================
   ALERT
========================= */

.required-info {
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.12);
    color: #dc2626;
    padding: 14px 18px;
    border-radius: 14px;
    font-weight: 600;
    margin-bottom: 24px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

/* =========================
   FORM
========================= */

.form-group {
    margin-bottom: 22px;
}

.form-label {
    display: block;
    margin-bottom: 10px;
    font-weight: 700;
    color: #0f172a;
    font-size: 14px;
}

.form-control {
    border: 1px solid #e2e8f0 !important;
    border-radius: 14px !important;
    padding: 14px 16px !important;
    min-height: 54px;
    transition: .25s ease;
    box-shadow: none !important;
    color: #334155;
}

.form-control:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 4px rgba(59,130,246,0.12) !important;
}

.form-control::placeholder {
    color: #94a3b8;
}

.is-invalid {
    border-color: #ef4444 !important;
}

.invalid-feedback {
    display: block;
    margin-top: 8px;
    color: #dc2626;
    font-size: 13px;
    font-weight: 500;
}

/* =========================
   BUTTON
========================= */

.btn-save {
    border: none;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white;
    padding: 14px 22px;
    border-radius: 14px;
    font-weight: 700;
    transition: .25s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 10px 24px rgba(34,197,94,0.22);
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 32px rgba(34,197,94,0.3);
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width: 768px) {

    .page-header {
        padding: 20px;
    }

    .page-title {
        font-size: 22px;
    }

    .form-card {
        padding: 20px;
    }

}

</style>

<div class="page-header">

    <div class="page-title">
        Edit Laporan Pelaksanaan
    </div>

    <div class="page-subtitle">
        Perbarui data laporan pelaksanaan dan dokumen kerjasama
    </div>

</div>

<div class="required-info">

    <i class="fas fa-circle-exclamation"></i>
    Field bertanda (*) wajib diisi

</div>

<div class="form-card">

    <form action="{{ route('pelaksanaan.update', $data->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">

            <label for="name" class="form-label">
                Nama Laporan <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   id="name"
                   name="name"
                   placeholder="Masukkan nama laporan"
                   value="{{ old('name', $data->name) }}">

            @error('name')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

               <div class="form-group">

    <label for="tahun" class="form-label">
        Tahun <span class="text-danger">*</span>
    </label>

    <input type="number"
           min="2000"
           max="{{ date('Y') + 10 }}"
           class="form-control @error('tahun') is-invalid @enderror"
           id="tahun"
           name="tahun"
           placeholder="Masukkan tahun"
           value="{{ old('tahun', $data->tahun) }}">

    @error('tahun')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror

</div>

        <div class="form-group">

            <label for="link_bukti_laporan" class="form-label">
                Link Bukti Laporan - Semester Ganjil <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control @error('link_bukti_laporan') is-invalid @enderror"
                   id="link_bukti_laporan"
                   name="link_bukti_laporan"
                   placeholder="Masukkan link laporan"
                   value="{{ old('link_bukti_laporan', $data->link_bukti_laporan) }}">

            @error('link_bukti_laporan')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

         <div class="form-group">

            <label for="link_bukti_laporan_genap" class="form-label">
                Link Bukti Laporan - Semester Genap
            </label>

            <input type="text"
                   class="form-control @error('link_bukti_laporan_genap') is-invalid @enderror"
                   id="link_bukti_laporan_genap"
                   name="link_bukti_laporan_genap"
                   placeholder="Masukkan link laporan"
                   value="{{ old('link_bukti_laporan_genap', $data->link_bukti_laporan_genap) }}">

            @error('link_bukti_laporan_genap')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <div class="form-group">

            <label for="nama_mitra" class="form-label">
                Nama Mitra (Opsional)
            </label>

            <input type="text"
                   class="form-control @error('nama_mitra') is-invalid @enderror"
                   id="nama_mitra"
                   name="nama_mitra"
                   placeholder="Masukkan nama mitra"
                   value="{{ old('nama_mitra', $data->nama_mitra) }}">

            @error('nama_mitra')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <div class="form-group">

            <label for="link_bukti_kerjasama" class="form-label">
                Link Bukti Kerjasama (Opsional)
            </label>

            <input type="text"
                   class="form-control @error('link_bukti_kerjasama') is-invalid @enderror"
                   id="link_bukti_kerjasama"
                   name="link_bukti_kerjasama"
                   placeholder="Masukkan link bukti kerjasama"
                   value="{{ old('link_bukti_kerjasama', $data->link_bukti_kerjasama) }}">

            @error('link_bukti_kerjasama')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <button type="submit" class="btn-save">

            <i class="fas fa-save"></i>
            Simpan Perubahan

        </button>

    </form>

</div>

@endsection