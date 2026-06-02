@extends('layouts.app')

@section('title', 'Evaluasi')

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

.form-control,
.form-select {
    border: 1px solid #e2e8f0 !important;
    border-radius: 14px !important;
    padding: 14px 16px !important;
    min-height: 54px;
    transition: .25s ease;
    box-shadow: none !important;
    color: #334155;
}

.form-control:focus,
.form-select:focus {
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
        Tambah Laporan Evaluasi
    </div>

    <div class="page-subtitle">
        Tambahkan laporan evaluasi berdasarkan aspek dan jenis laporan
    </div>

</div>

<div class="required-info">

    <i class="fas fa-circle-exclamation"></i>
    Field bertanda (*) wajib diisi

</div>

<div class="form-card">

    <form action="{{ route('evaluasi.store') }}"
          method="POST">

        @csrf

        <div class="form-group">

            <label for="aspek" class="form-label">
                Aspek <span class="text-danger">*</span>
            </label>

            <select class="form-select @error('aspek') is-invalid @enderror"
                    name="aspek"
                    id="aspek">

                <option value="" disabled selected>
                    -- Pilih Aspek --
                </option>

                <option value="Pendidikan"
                    {{ old('aspek') == 'Pendidikan' ? 'selected' : '' }}>
                    Pendidikan
                </option>

                <option value="Penelitian"
                    {{ old('aspek') == 'Penelitian' ? 'selected' : '' }}>
                    Penelitian
                </option>

                <option value="Pengabdian"
                    {{ old('aspek') == 'Pengabdian' ? 'selected' : '' }}>
                    Pengabdian
                </option>

            </select>

            @error('aspek')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <div class="form-group">

            <label for="jenis_laporan" class="form-label">
                Jenis Laporan <span class="text-danger">*</span>
            </label>

            <select class="form-select @error('jenis_laporan') is-invalid @enderror"
                    name="jenis_laporan"
                    id="jenis_laporan">

                <option value="" disabled selected>
                    -- Pilih Jenis Laporan --
                </option>

                <option value="AMI"
                    {{ old('jenis_laporan') == 'AMI' ? 'selected' : '' }}>
                    AMI
                </option>

                <option value="Monev_jurusan"
                    {{ old('jenis_laporan') == 'Monev_jurusan' ? 'selected' : '' }}>
                    Monev Jurusan
                </option>

                <option value="Survey"
                    {{ old('jenis_laporan') == 'Survey' ? 'selected' : '' }}>
                    Survey
                </option>

            </select>

            @error('jenis_laporan')

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
           value="{{ old('tahun') }}">

    @error('tahun')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror

</div>

<div class="form-group">

    <label class="form-label">
        Jenis Laporan <span class="text-danger">*</span>
    </label>

    <div class="d-flex flex-wrap gap-4 mt-2">

        @foreach (['Tahun', 'Semester Ganjil', 'Semester Genap'] as $i => $option)

            <div class="form-check">

                <input class="form-check-input @error('jenis') is-invalid @enderror"
                       type="radio"
                       name="jenis"
                       id="jenis_{{ $i }}"
                       value="{{ $option }}"
                       {{ old('jenis') === $option ? 'checked' : '' }}>

                <label class="form-check-label fw-semibold" for="jenis_{{ $i }}">
                    {{ $option }}
                </label>

            </div>

        @endforeach

    </div>

    @error('jenis')

        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>

    @enderror

</div>

<div class="form-group">

    <label for="link_bukti_laporan" class="form-label">
        Link Bukti Laporan <span class="text-danger">*</span>
    </label>

    <input type="url"
           class="form-control @error('link_bukti_laporan') is-invalid @enderror"
           id="link_bukti_laporan"
           name="link_bukti_laporan"
           placeholder="Masukkan link bukti laporan"
           value="{{ old('link_bukti_laporan') }}">

    @error('link_bukti_laporan')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror

</div>

        <button type="submit" class="btn-save">

            <i class="fas fa-save"></i>
            Simpan Data

        </button>

    </form>

</div>

@endsection