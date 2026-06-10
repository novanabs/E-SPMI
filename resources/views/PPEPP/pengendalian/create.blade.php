@extends('layouts.app')

@section('title', 'Pengendalian')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
            box-shadow: 0 12px 30px rgba(15, 23, 42, .10);
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
            box-shadow: 0 10px 30px rgba(15, 23, 42, .06);
        }

        /* =========================
       ALERT
    ========================= */

        .required-alert {
            background: rgba(239, 68, 68, .08);
            border: 1px solid rgba(239, 68, 68, .14);
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

        .form-control:focus {

            border-color: #2563eb !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12) !important;

        }

        .form-control[readonly] {

            background: #f8fafc !important;
            color: #475569;
            font-weight: 600;

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

            background: rgba(37, 99, 235, .06);
            border: 1px solid rgba(37, 99, 235, .10);
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
            background: rgba(37, 99, 235, .12);
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
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            padding: 14px 24px;
            border-radius: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: .25s ease;
            box-shadow: 0 12px 24px rgba(22, 163, 74, .22);

        }

        .btn-save:hover {

            transform: translateY(-2px);
            box-shadow: 0 18px 32px rgba(22, 163, 74, .28);

        }

        /* =========================
       RESPONSIVE
    ========================= */

        @media(max-width:768px) {

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
            Tambah Laporan Pengendalian
        </div>

        <div class="page-subtitle">

            Tambahkan laporan pengendalian sebagai bagian dari proses
            tindak lanjut hasil evaluasi mutu di lingkungan FKIP ULM.

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

                <i class="fas fa-circle-info"></i>

            </div>

            <div>

                <div class="info-title">
                    Informasi Pengendalian
                </div>

                <div class="info-desc">

                    Pastikan link laporan dapat diakses dan sesuai
                    dengan dokumen pengendalian yang telah disusun.

                </div>

            </div>

        </div>

        <!-- FORM -->

        <form action="{{ route('pengendalian.store') }}" method="POST">

            @csrf

            <!-- NAMA LAPORAN -->

            <div class="form-group">

                <label for="name" class="form-label">

                    Nama Laporan
                    <span class="text-danger">*</span>

                </label>

                <input type="text" class="form-control" id="name" name="name"
                    value="Laporan Pengendalian {{ auth()->user()->homebase }}" readonly>

            </div>

            <div class="form-group">

                <label for="bidang" class="form-label">
                    Bidang <span class="text-danger">*</span>
                </label>

                <select class="form-select @error('bidang') is-invalid @enderror" id="bidang" name="bidang">
                    <option value="">-- Pilih Bidang --</option>
                    <option value="Pendidikan" {{ old('bidang') == 'Pendidikan' ? 'selected' : '' }}>1) Pendidikan</option>
                    <option value="Penelitian" {{ old('bidang') == 'Penelitian' ? 'selected' : '' }}>2) Penelitian</option>
                    <option value="Pengabdian kepada Masyarakat" {{ old('bidang') == 'Pengabdian kepada Masyarakat' ? 'selected' : '' }}>3) Pengabdian kepada Masyarakat</option>
                </select>

                @error('bidang')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">

                <label for="tahun" class="form-label">
                    Tahun <span class="text-danger">*</span>
                </label>

                <input type="number" min="2000" max="{{ date('Y') + 10 }}"
                    class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun"
                    placeholder="Masukkan tahun" value="{{ old('tahun') }}">

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

                            <input class="form-check-input @error('jenis') is-invalid @enderror" type="radio"
                                name="jenis" id="jenis_{{ $i }}" value="{{ $option }}"
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

            <!-- LINK LAPORAN -->

            <div class="form-group">

                <label for="link_bukti_laporan" class="form-label">

                    Link Laporan
                    <span class="text-danger">*</span>

                </label>
                <small class="text-muted d-block mb-2">
                    Pastikan tautan dokumen dapat diakses secara publik (open access) tanpa memerlukan izin atau
                    login.
                </small>

                <input type="url" class="form-control @error('link_bukti_laporan') is-invalid @enderror"
                    id="link_bukti_laporan" name="link_bukti_laporan" placeholder="Masukkan link laporan pengendalian"
                    value="{{ old('link_bukti_laporan') }}">

                @error('link_bukti_laporan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- BUTTON -->

            <button type="submit" class="btn-save">

                <i class="fas fa-floppy-disk"></i>
                Simpan Data

            </button>

        </form>

    </div>

@endsection
