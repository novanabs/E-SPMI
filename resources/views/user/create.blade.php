@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* =========================
   PAGE HEADER
========================= */

.page-header {

    background: linear-gradient(135deg,#0f172a,#1e3a8a);
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

.form-control,
.form-select {

    border-radius: 14px !important;
    min-height: 54px;
    border: 1px solid #dbe2ea !important;
    box-shadow: none !important;
    padding: 14px 16px !important;
    transition: .25s ease;

}

.form-control:focus,
.form-select:focus {

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
        Tambah User
    </div>

    <div class="page-subtitle">

        Tambahkan akun pengguna baru untuk mengakses
        sistem E-SPMI FKIP ULM sesuai dengan role
        dan hak akses masing-masing.

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

            <i class="fas fa-user-plus"></i>

        </div>

        <div>

            <div class="info-title">
                Informasi User
            </div>

            <div class="info-desc">

                Pastikan data pengguna yang dimasukkan benar
                dan email aktif agar akun dapat digunakan
                dengan baik.

            </div>

        </div>

    </div>

    <!-- FORM -->

    <form action="{{ route('user.store') }}"
          method="POST">

        @csrf



        <!-- HOMEBASE -->


<div class="form-group">

    <label for="homebase"
           class="form-label">

        Homebase
        <span class="text-danger">*</span>

    </label>

    <select class="form-select @error('homebase') is-invalid @enderror"
            name="homebase"
            id="homebase">

        <option value="" disabled selected>
            -- Pilih Homebase --
        </option>

        <option value="Pendidikan Geografi"
            {{ old('homebase') == 'Pendidikan Geografi' ? 'selected' : '' }}>
            Pendidikan Geografi
        </option>

        <option value="Pendidikan Khusus"
            {{ old('homebase') == 'Pendidikan Khusus' ? 'selected' : '' }}>
            Pendidikan Khusus
        </option>

        <option value="Pendidikan Guru Sekolah Dasar"
            {{ old('homebase') == 'Pendidikan Guru Sekolah Dasar' ? 'selected' : '' }}>
            Pendidikan Guru Sekolah Dasar (PGSD)
        </option>

        <option value="Pendidikan Sosiologi"
            {{ old('homebase') == 'Pendidikan Sosiologi' ? 'selected' : '' }}>
            Pendidikan Sosiologi
        </option>

        <option value="Pendidikan Bahasa dan Sastra Indonesia"
            {{ old('homebase') == 'Pendidikan Bahasa dan Sastra Indonesia' ? 'selected' : '' }}>
            Pendidikan Bahasa dan Sastra Indonesia
        </option>

        <option value="Pendidikan Pancasila dan Kewarganegaraan"
            {{ old('homebase') == 'Pendidikan Pancasila dan Kewarganegaraan' ? 'selected' : '' }}>
            Pendidikan Pancasila dan Kewarganegaraan (PPKn)
        </option>

        <option value="Pendidikan Jasmani"
            {{ old('homebase') == 'Pendidikan Jasmani' ? 'selected' : '' }}>
            Pendidikan Jasmani
        </option>

        <option value="Pendidikan Sejarah"
            {{ old('homebase') == 'Pendidikan Sejarah' ? 'selected' : '' }}>
            Pendidikan Sejarah
        </option>

        <option value="Pendidikan Ekonomi"
            {{ old('homebase') == 'Pendidikan Ekonomi' ? 'selected' : '' }}>
            Pendidikan Ekonomi
        </option>

        <option value="Bimbingan Konseling"
            {{ old('homebase') == 'Bimbingan Konseling' ? 'selected' : '' }}>
            Bimbingan Konseling
        </option>

        <option value="Pendidikan Seni Pertunjukan"
            {{ old('homebase') == 'Pendidikan Seni Pertunjukan' ? 'selected' : '' }}>
            Pendidikan Seni Pertunjukan
        </option>

        <option value="Pendidikan Biologi"
            {{ old('homebase') == 'Pendidikan Biologi' ? 'selected' : '' }}>
            Pendidikan Biologi
        </option>

        <option value="Pendidikan IPA"
            {{ old('homebase') == 'Pendidikan IPA' ? 'selected' : '' }}>
            Pendidikan IPA
        </option>

        <option value="Pendidikan Guru PAUD"
            {{ old('homebase') == 'Pendidikan Guru PAUD' ? 'selected' : '' }}>
            Pendidikan Guru PAUD
        </option>

        <option value="Pendidikan Komputer"
            {{ old('homebase') == 'Pendidikan Komputer' ? 'selected' : '' }}>
            Pendidikan Komputer
        </option>

        <option value="Pendidikan IPS"
            {{ old('homebase') == 'Pendidikan IPS' ? 'selected' : '' }}>
            Pendidikan IPS
        </option>

        <option value="Teknologi Pendidikan"
            {{ old('homebase') == 'Teknologi Pendidikan' ? 'selected' : '' }}>
            Teknologi Pendidikan
        </option>

        <option value="Pendidikan Fisika"
            {{ old('homebase') == 'Pendidikan Fisika' ? 'selected' : '' }}>
            Pendidikan Fisika
        </option>

        <option value="Pendidikan Bahasa Inggris"
            {{ old('homebase') == 'Pendidikan Bahasa Inggris' ? 'selected' : '' }}>
            Pendidikan Bahasa Inggris
        </option>

        <option value="Pendidikan Kimia"
            {{ old('homebase') == 'Pendidikan Kimia' ? 'selected' : '' }}>
            Pendidikan Kimia
        </option>

        <option value="Pendidikan Matematika"
            {{ old('homebase') == 'Pendidikan Matematika' ? 'selected' : '' }}>
            Pendidikan Matematika
        </option>

        <option value="UPM"
            {{ old('homebase') == 'UPM' ? 'selected' : '' }}>
            UPM
        </option>

        <option value="Gugus Penjaminan Mutu"
            {{ old('homebase') == 'Gugus Penjaminan Mutu' ? 'selected' : '' }}>
            Gugus Penjaminan Mutu
        </option>

    </select>

    @error('homebase')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror

</div>

        <!-- NAMA USER -->

        <div class="form-group">

            <label for="name"
                   class="form-label">

                Nama (Dengan Gelar)
                <span class="text-danger">*</span>

            </label>

            <input type="text"
                   class="form-control @error('name') is-invalid @enderror"
                   id="name"
                   name="name"
                   placeholder="Masukkan Nama User"
                   value="{{ old('name') }}">

            @error('name')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <!-- KETUA -->

        <div class="form-group">

            <label for="ketua"
                   class="form-label">

                Jabatan
                <span class="text-danger">*</span>

            </label>

            <input type="text"
                   class="form-control @error('jabatan') is-invalid @enderror"
                   id="jabatan"
                   name="jabatan"
                   placeholder="Masukkan Jabatan"
                   value="{{ old('jabatan') }}">

            @error('jabatan')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <!-- NIP -->

<div class="form-group">

    <label for="nip"
           class="form-label">

        NIP
        <span class="text-danger">*</span>

    </label>

    <input type="text"
           class="form-control @error('nip') is-invalid @enderror"
           id="nip"
           name="nip"
           placeholder="Masukkan NIP"
           value="{{ old('nip') }}">

    @error('nip')

        <div class="invalid-feedback">
            {{ $message }}
        </div>

    @enderror

</div>
        <!-- EMAIL -->

        <div class="form-group">

            <label for="email"
                   class="form-label">

                Email
                <span class="text-danger">*</span>

            </label>

            <input type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   id="email"
                   name="email"
                   placeholder="Masukkan Email"
                   value="{{ old('email') }}">

            @error('email')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <!-- ROLE -->

        <div class="form-group">

            <label for="role"
                   class="form-label">

                Role
                <span class="text-danger">*</span>

            </label>

            <select class="form-select @error('role') is-invalid @enderror"
                    name="role"
                    id="role">

                <option value="" disabled selected>
                    -- Pilih Role --
                </option>

                <option value="pimpinan"
                    {{ old('role') == 'pimpinan' ? 'selected' : '' }}>

                    Pimpinan Fakultas

                </option>

                <option value="admin_jurusan"
                    {{ old('role') == 'admin_jurusan' ? 'selected' : '' }}>

                    Admin Jurusan

                </option>

                <option value="admin_FKIP"
                    {{ old('role') == 'admin_FKIP' ? 'selected' : '' }}>

                    Admin FKIP

                </option>

                <option value="auditor"
                    {{ old('role') == 'auditor' ? 'selected' : '' }}>

                    Auditor

                </option>

            </select>

            @error('role')

                <div class="invalid-feedback">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <!-- BUTTON -->

        <button type="submit"
                class="btn-save">

            <i class="fas fa-floppy-disk"></i>
            Simpan User

        </button>

    </form>

</div>

@endsection