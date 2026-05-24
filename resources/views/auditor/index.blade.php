@extends('layouts.app')

@section('title', 'Dashboard Auditor')

@section('content')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* =========================================
   PAGE HEADER
========================================= */

.page-header {

    background: linear-gradient(135deg,#0f172a,#1e3a8a);
    border-radius: 28px;
    padding: 34px;
    margin-bottom: 28px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 14px 34px rgba(15,23,42,.12);

}

.page-header::before {

    content: '';
    position: absolute;
    width: 260px;
    height: 260px;
    background: rgba(255,255,255,.05);
    border-radius: 50%;
    right: -100px;
    top: -100px;

}

.page-title {

    font-size: 34px;
    font-weight: 800;
    margin-bottom: 8px;
    position: relative;
    z-index: 2;

}

.page-subtitle {

    opacity: .92;
    line-height: 1.8;
    max-width: 760px;
    position: relative;
    z-index: 2;

}

/* =========================================
   GRID
========================================= */

.audit-grid {

    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 24px;

}

/* =========================================
   CARD
========================================= */

.audit-card {

    background: white;
    border-radius: 24px;
    padding: 26px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 28px rgba(15,23,42,.06);
    transition: .3s ease;
    border: 1px solid rgba(226,232,240,.7);

}

.audit-card:hover {

    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(15,23,42,.10);

}

.audit-card::before {

    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg,rgba(37,99,235,.03),transparent);
    pointer-events: none;

}

/* =========================================
   TOP
========================================= */

.card-top {

    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 22px;

}

.audit-icon {

    width: 68px;
    height: 68px;
    border-radius: 20px;
    background: linear-gradient(135deg,#2563eb,#1d4ed8);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
    box-shadow: 0 12px 24px rgba(37,99,235,.25);

}

.audit-year {

    background: rgba(37,99,235,.10);
    color: #1d4ed8;
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;

}

/* =========================================
   CONTENT
========================================= */

.audit-jurusan {

    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 10px;
    line-height: 1.5;

}

.audit-meta {

    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 26px;

}

.audit-item {

    display: flex;
    align-items: center;
    gap: 12px;
    color: #64748b;
    font-size: 14px;

}

.audit-item i {

    width: 18px;
    color: #2563eb;

}

/* =========================================
   STATUS
========================================= */

.audit-status {

    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 22px;

}

.status-active {

    background: rgba(34,197,94,.10);
    color: #15803d;

}

/* =========================================
   BUTTON
========================================= */

.btn-audit {

    width: 100%;
    border: none;
    background: linear-gradient(135deg,#0f172a,#1e293b);
    color: white;
    padding: 15px;
    border-radius: 16px;
    font-weight: 700;
    transition: .25s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;

}

.btn-audit:hover {

    transform: translateY(-2px);
    box-shadow: 0 14px 24px rgba(15,23,42,.18);
    color: white;

}

/* =========================================
   EMPTY STATE
========================================= */

.empty-state {

    background: white;
    border-radius: 28px;
    padding: 70px 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(15,23,42,.06);

}

.empty-icon {

    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: rgba(37,99,235,.08);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto auto 24px;
    color: #2563eb;
    font-size: 42px;

}

.empty-title {

    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 10px;

}

.empty-desc {

    color: #64748b;
    line-height: 1.8;
    max-width: 560px;
    margin: auto;

}

/* =========================================
   RESPONSIVE
========================================= */

@media(max-width:768px){

    .page-header {

        padding: 26px;

    }

    .page-title {

        font-size: 26px;

    }

    .audit-grid {

        grid-template-columns: 1fr;

    }

}

</style>

<!-- =========================================
     HEADER
========================================= -->


<div class="page-header">

    <div class="page-title">

        Dashboard Auditor

    </div>

    <div class="page-subtitle">

        Selamat datang,
        <strong>{{ auth()->user()->name }}</strong>.
        Pilih jurusan yang akan diaudit berdasarkan
        penugasan Audit Mutu Internal (AMI).

    </div>

</div>

<!-- =========================================
     LIST AUDIT
========================================= -->
@if ($data->count() > 0)

    <div class="audit-grid">

        @foreach ($data as $item)

            <div class="audit-card">

                <!-- TOP -->

                <div class="card-top">

                    <div class="audit-icon">

                        <i class="fas fa-building-columns"></i>

                    </div>

                    <div class="audit-year">

                        Audit {{ $item->tahun_audit }}

                    </div>

                </div>

                <!-- JURUSAN -->

                <div class="audit-jurusan">

                    {{ $item->jurusan }}

                </div>

                <!-- META -->

                <div class="audit-meta">

                    <div class="audit-item">

                        <i class="fas fa-user-check"></i>

                        Auditor:
                        {{ auth()->user()->name }}

                    </div>

                    <div class="audit-item">

                        <i class="fas fa-id-card"></i>

                        NIP:
                        {{ auth()->user()->nip }}

                    </div>

                    <div class="audit-item">

                        <i class="fas fa-calendar-days"></i>

                        Tahun Audit:
                        {{ $item->tahun_audit }}

                    </div>

                </div>

                <!-- STATUS -->

                <div class="audit-status status-active">

                    <i class="fas fa-circle-check"></i>

                    Audit Aktif

                </div>

                <!-- BUTTON -->

                <a href="#"
                   class="btn-audit">

                    <i class="fas fa-arrow-right"></i>

                    Masuk Audit

                </a>

            </div>

        @endforeach

    </div>

@else

    <!-- EMPTY -->

    <div class="empty-state">

        <div class="empty-icon">

            <i class="fas fa-folder-open"></i>

        </div>

        <div class="empty-title">

            Belum Ada Penugasan Audit

        </div>

        <div class="empty-desc">

            Saat ini Anda belum terhubung dengan jurusan manapun
            untuk pelaksanaan Audit Mutu Internal (AMI).
            Silakan hubungi admin FKIP.

        </div>

    </div>

@endif

@endsection