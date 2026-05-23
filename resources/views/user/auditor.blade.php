@extends('layouts.app')

@section('title', 'Manajemen Auditor')

@section('content')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* =========================================
   PAGE HEADER
========================================= */

.page-header {

    background: linear-gradient(135deg,#0f172a,#1e3a8a);
    border-radius: 24px;
    padding: 30px;
    margin-bottom: 24px;
    color: white;
    box-shadow: 0 12px 30px rgba(15,23,42,.10);

}

.page-title {

    font-size: 30px;
    font-weight: 800;
    margin-bottom: 6px;

}

.page-subtitle {

    opacity: .88;
    line-height: 1.8;
    max-width: 760px;

}

/* =========================================
   TABLE CARD
========================================= */

.table-card {

    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(15,23,42,.06);

}

.table-header {

    padding: 24px;
    border-bottom: 1px solid #eef2f7;
    display: flex;
    justify-content: space-between;
    align-items: center;

}

.table-title {

    font-size: 24px;
    font-weight: 800;
    color: #0f172a;

}

/* =========================================
   TABLE
========================================= */

.table {

    margin-bottom: 0 !important;

}

.table thead {

    background: #f8fafc;

}

.table th {

    border-bottom: 1px solid #e2e8f0 !important;
    color: #64748b;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .5px;
    white-space: nowrap;

}

.table td {

    vertical-align: middle;
    color: #334155;

}

.table tbody tr {

    transition: .2s ease;

}

.table tbody tr:hover {

    background: rgba(37,99,235,.03);

}

/* =========================================
   AUDITOR INFO
========================================= */

.auditor-name {

    font-weight: 700;
    color: #0f172a;

}

.auditor-homebase {

    font-size: 13px;
    color: #64748b;

}

/* =========================================
   BADGE
========================================= */

.jurusan-badge {

    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    border-radius: 999px;
    background: rgba(37,99,235,.10);
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
    margin: 4px;
    border: 1px solid rgba(37,99,235,.08);

}

.badge-delete {

    border: none;
    background: transparent;
    color: #dc2626;
    padding: 0;
    margin-left: 4px;

}

/* =========================================
   BUTTON
========================================= */

.btn {

    border-radius: 12px !important;
    font-weight: 700 !important;

}

.btn-primary {

    background: linear-gradient(135deg,#2563eb,#1d4ed8);
    border: none;

}

.btn-danger {

    background: linear-gradient(135deg,#ef4444,#dc2626);
    border: none;

}

.btn-secondary {

    background: linear-gradient(135deg,#64748b,#475569);
    border: none;

}

/* =========================================
   DATATABLE
========================================= */

.dataTables_filter input,
.dataTables_length select {

    border-radius: 12px !important;
    border: 1px solid #dbe2ea !important;
    min-height: 42px;
    box-shadow: none !important;

}

.dataTables_filter input:focus {

    border-color: #2563eb !important;
    box-shadow: 0 0 0 4px rgba(37,99,235,.12) !important;

}

/* =========================================
   MODAL
========================================= */

.modal-content {

    border: none !important;
    border-radius: 24px !important;
    overflow: hidden;

}

.modal-header {

    background: linear-gradient(135deg,#0f172a,#1e293b);
    color: white;
    border: none;

}

.modal-title {

    font-weight: 700;

}

.form-select,
.form-control {

    border-radius: 14px !important;
    min-height: 54px;
    border: 1px solid #dbe2ea !important;
    box-shadow: none !important;
    padding: 14px 16px !important;

}

.form-select:focus,
.form-control:focus {

    border-color: #2563eb !important;
    box-shadow: 0 0 0 4px rgba(37,99,235,.12) !important;

}

/* =========================================
   EMPTY TEXT
========================================= */

.empty-text {

    color: #94a3b8;
    font-style: italic;

}

/* =========================================
   RESPONSIVE
========================================= */

@media(max-width:768px){

    .page-title {

        font-size: 24px;

    }

}

</style>

<!-- =========================================
     HEADER
========================================= -->

<div class="page-header">

    <div class="page-title">

        Manajemen Auditor

    </div>

    <div class="page-subtitle">

        Kelola hubungan auditor dengan jurusan/program studi
        untuk pelaksanaan Audit Mutu Internal (AMI)
        di lingkungan FKIP ULM.

    </div>

</div>

<!-- =========================================
     TABLE CARD
========================================= -->

<div class="table-card">

    <div class="table-header">

        <div class="table-title">

            Daftar Auditor

        </div>

    </div>

    <div class="table-responsive">

        <table id="auditorTable"
               class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Auditor</th>
                    <th>NIP</th>
                    <th>Email</th>
                    <th>Jurusan Audit</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($data as $item)

                    <tr>

                        <!-- NO -->

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <!-- AUDITOR -->

                        <td>

                            <div class="auditor-name">

                                {{ $item->name }}

                            </div>

                            <div class="auditor-homebase">

                                {{ $item->homebase }}

                            </div>

                        </td>

                        <!-- NIP -->

                        <td>

                            {{ $item->nip }}

                        </td>

                        <!-- EMAIL -->

                        <td>

                            {{ $item->email }}

                        </td>

                        <!-- JURUSAN -->

                        <td>

                            @forelse ($item->auditorJurusan as $jurusan)

                                <span class="jurusan-badge">

                                    <i class="fas fa-building-columns"></i>

                                    {{ $jurusan->jurusan }}

                                    ({{ $jurusan->tahun_audit }})

                                    <!-- HAPUS -->

                                    <form action="{{ route('auditor.hapusHubungan', $jurusan->id) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="badge-delete">

                                            <i class="fas fa-xmark"></i>

                                        </button>

                                    </form>

                                </span>

                            @empty

                                <span class="empty-text">

                                    Belum ada hubungan auditor

                                </span>

                            @endforelse

                        </td>

                        <!-- ACTION -->

                        <td>

                            <button class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#hubungkanModal{{ $item->id }}">

                                <i class="fas fa-link me-1"></i>

                                Tambah Hubungan

                            </button>

                        </td>

                    </tr>

                    <!-- =========================================
                         MODAL TAMBAH HUBUNGAN
                    ========================================== -->

                    <div class="modal fade"
                         id="hubungkanModal{{ $item->id }}"
                         tabindex="-1">

                        <div class="modal-dialog">

                            <div class="modal-content">

                                <form action="{{ route('auditor.hubungkan') }}"
                                      method="POST">

                                    @csrf

                                    <input type="hidden"
                                           name="user_id"
                                           value="{{ $item->id }}">

                                    <!-- HEADER -->

                                    <div class="modal-header">

                                        <h5 class="modal-title">

                                            Hubungkan Auditor

                                        </h5>

                                        <button type="button"
                                                class="btn-close btn-close-white"
                                                data-bs-dismiss="modal">
                                        </button>

                                    </div>

                                    <!-- BODY -->

                                    <div class="modal-body">

                                        <!-- AUDITOR -->

                                        <div class="mb-3">

                                            <label class="form-label fw-bold">

                                                Auditor

                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   value="{{ $item->name }}"
                                                   readonly>

                                        </div>

                                        <!-- JURUSAN -->

                                        <div class="mb-3">

                                            <label class="form-label fw-bold">

                                                Jurusan

                                            </label>

                                            <select class="form-select"
                                                    name="jurusan"
                                                    required>

                                                <option value="">
                                                    -- Pilih Jurusan --
                                                </option>

                                                <option value="Pendidikan Geografi">
                                                    Pendidikan Geografi
                                                </option>

                                                <option value="Pendidikan Khusus">
                                                    Pendidikan Khusus
                                                </option>

                                                <option value="Pendidikan Guru Sekolah Dasar">
                                                    Pendidikan Guru Sekolah Dasar
                                                </option>

                                                <option value="Pendidikan Sosiologi">
                                                    Pendidikan Sosiologi
                                                </option>

                                                <option value="Pendidikan Bahasa dan Sastra Indonesia">
                                                    Pendidikan Bahasa dan Sastra Indonesia
                                                </option>

                                                <option value="Pendidikan Pancasila dan Kewarganegaraan">
                                                    Pendidikan Pancasila dan Kewarganegaraan
                                                </option>

                                                <option value="Pendidikan Jasmani">
                                                    Pendidikan Jasmani
                                                </option>

                                                <option value="Pendidikan Sejarah">
                                                    Pendidikan Sejarah
                                                </option>

                                                <option value="Pendidikan Ekonomi">
                                                    Pendidikan Ekonomi
                                                </option>

                                                <option value="Bimbingan Konseling">
                                                    Bimbingan Konseling
                                                </option>

                                                <option value="Pendidikan Seni Pertunjukan">
                                                    Pendidikan Seni Pertunjukan
                                                </option>

                                                <option value="Pendidikan Biologi">
                                                    Pendidikan Biologi
                                                </option>

                                                <option value="Pendidikan IPA">
                                                    Pendidikan IPA
                                                </option>

                                                <option value="Pendidikan Guru PAUD">
                                                    Pendidikan Guru PAUD
                                                </option>

                                                <option value="Pendidikan Komputer">
                                                    Pendidikan Komputer
                                                </option>

                                                <option value="Pendidikan IPS">
                                                    Pendidikan IPS
                                                </option>

                                                <option value="Teknologi Pendidikan">
                                                    Teknologi Pendidikan
                                                </option>

                                                <option value="Pendidikan Fisika">
                                                    Pendidikan Fisika
                                                </option>

                                                <option value="Pendidikan Bahasa Inggris">
                                                    Pendidikan Bahasa Inggris
                                                </option>

                                                <option value="Pendidikan Kimia">
                                                    Pendidikan Kimia
                                                </option>

                                                <option value="Pendidikan Matematika">
                                                    Pendidikan Matematika
                                                </option>

                                            </select>

                                        </div>

                                        <!-- TAHUN -->

                                        <div class="mb-3">

                                            <label class="form-label fw-bold">

                                                Tahun Audit

                                            </label>

                                            <input type="number"
                                                   class="form-control"
                                                   name="tahun_audit"
                                                   min="2020"
                                                   max="2100"
                                                   value="{{ date('Y') }}"
                                                   required>

                                        </div>

                                    </div>

                                    <!-- FOOTER -->

                                    <div class="modal-footer">

                                        <button type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">

                                            Tutup

                                        </button>

                                        <button type="submit"
                                                class="btn btn-primary">

                                            <i class="fas fa-save me-2"></i>

                                            Simpan Hubungan

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<!-- =========================================
     DATATABLE
========================================= -->

<script>

$(document).ready(function() {

    $('#auditorTable').DataTable({

        pageLength: 10,

        language: {

            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",

            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

            paginate: {

                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"

            },

            emptyTable: "Tidak ada data"

        }

    });

});

</script>

@endsection