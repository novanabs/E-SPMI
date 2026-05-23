@extends('layouts.app')

@section('title', 'Dokumen')

@section('content')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* =========================
   PAGE HEADER
========================= */

.page-header {
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
    border-radius: 24px;
    padding: 28px;
    margin-bottom: 24px;
    color: white;
    box-shadow: 0 12px 30px rgba(15,23,42,.10);
}

.page-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 6px;
}

.page-subtitle {
    opacity: .88;
    line-height: 1.8;
    max-width: 760px;
}

/* =========================
   FORM CARD
========================= */

.form-card {
    background: white;
    border-radius: 24px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(15,23,42,.06);
}

/* =========================
   ALERT
========================= */

.required-alert {
    background: rgba(239,68,68,.08);
    border: 1px solid rgba(239,68,68,.14);
    color: #dc2626;
    padding: 14px 18px;
    border-radius: 16px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 24px;
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

    border-radius: 14px !important;
    min-height: 54px;
    border: 1px solid #dbe2ea !important;
    box-shadow: none !important;
    padding: 14px 16px !important;
    transition: .25s ease;

}

textarea.form-control {

    min-height: 120px;
    resize: vertical;

}

.form-control:focus {

    border-color: #2563eb !important;
    box-shadow: 0 0 0 4px rgba(37,99,235,.12) !important;

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
   INFO BOX
========================= */

.info-box {

    background: rgba(37,99,235,.06);
    border: 1px solid rgba(37,99,235,.10);
    border-radius: 18px;
    padding: 18px;
    margin-bottom: 24px;
    display: flex;
    align-items: flex-start;
    gap: 14px;

}

.info-icon {

    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: rgba(37,99,235,.12);
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;

}

.info-title {

    font-weight: 700;
    color: #0f172a;
    margin-bottom: 6px;

}

.info-desc {

    color: #64748b;
    line-height: 1.7;
    font-size: 14px;

}

/* =========================
   BUTTON
========================= */

.btn-save {

    border: none;
    background: linear-gradient(135deg,#2563eb,#1d4ed8);
    color: white;
    padding: 14px 24px;
    border-radius: 14px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: .25s ease;
    box-shadow: 0 12px 24px rgba(37,99,235,.22);

}

.btn-save:hover {

    transform: translateY(-2px);
    box-shadow: 0 18px 32px rgba(37,99,235,.28);

}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:768px){

    .page-header {

        padding: 22px;

    }

    .page-title {

        font-size: 22px;

    }

    .form-card {

        padding: 22px;

    }

}

</style>

<!-- HEADER -->

<div class="page-header">

    <div class="page-title">
        Tambah Dokumen
    </div>

    <div class="page-subtitle">

        Tambahkan dokumen pendukung untuk mendukung
        pelaksanaan Sistem Penjaminan Mutu Internal (SPMI)
        di lingkungan FKIP ULM.

    </div>

</div>

<!-- ALERT -->

<div class="required-alert">

    <i class="fas fa-circle-exclamation"></i>
    Field bertanda (*) wajib diisi

</div>

<!-- FORM CARD -->

<div class="form-card">

    <!-- INFO -->

    <div class="info-box">

        <div class="info-icon">

            <i class="fas fa-folder-open"></i>

        </div>

        <div>

            <div class="info-title">
                Informasi Dokumen
            </div>

            <div class="info-desc">

                Pastikan dokumen yang diunggah memiliki link yang valid,
                dapat diakses, dan sesuai dengan kebutuhan administrasi mutu.

            </div>

        </div>

    </div>

    <!-- FORM -->

    <form action="{{ route('dokumen.store') }}"
          method="POST">

        @csrf

        <!-- NAMA DOKUMEN -->

        <div class="form-group">

            <label for="name"
                   class="form-label">

                Nama Dokumen
                <span class="text-danger">*</span>

            </label>

            <input type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   id="name"
                   name="name"
                   placeholder="Masukkan Nama Dokumen"
                   value="{{ old('name') }}">

            @error('name')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <!-- DESKRIPSI -->

        <div class="form-group">

            <label for="deskripsi"
                   class="form-label">

                Deskripsi

            </label>

            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                      id="deskripsi"
                      name="deskripsi"
                      placeholder="Masukkan Deskripsi Dokumen">{{ old('deskripsi') }}</textarea>

            @error('deskripsi')

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

        <!-- LINK DOKUMEN -->

        <div class="form-group">

            <label for="link_dokumen"
                   class="form-label">

                Link Dokumen
                <span class="text-danger">*</span>

            </label>

            <input type="text"
                   class="form-control @error('link_dokumen') is-invalid @enderror"
                   id="link_dokumen"
                   name="link_dokumen"
                   placeholder="Masukkan Link Dokumen"
                   value="{{ old('link_dokumen') }}">

            @error('link_dokumen')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <!-- BUTTON -->

        <button type="submit"
                class="btn-save">

            <i class="fas fa-floppy-disk"></i>
            Simpan Dokumen

        </button>

    </form>

</div>

@endsection