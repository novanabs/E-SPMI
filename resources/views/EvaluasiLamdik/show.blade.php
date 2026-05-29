@extends('layouts.app')

@section('title', 'Perbandingan Evaluasi Diri ' . (auth()->user()->homebase ?? ''))

@section('content')

    @php
        $auditorList = $auditors ?? collect();
    @endphp

    {{-- CLICKABLE PILL PANEL --}}
    <div class="card shadow-sm mb-3 border-0 rounded-3" style="background: #f8faff;">
        <div class="card-body py-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="fw-semibold me-2 text-nowrap" style="color: #173b70;"><i class="bi bi-arrow-left-right me-1"></i>Bandingkan:</span>
                @forelse ($auditorList as $a)
                    @php
                        $isUPM = str_contains($a->auditor_label ?? '', 'UPM');
                        $pillLabel = $isUPM ? 'UPM' : $a->name;
                        $dataLabel = $isUPM ? 'UPM' : 'Auditor';
                    @endphp
                    <button class="btn btn-sm rounded-pill px-3 {{ $loop->first ? 'btn-primary' : 'btn-outline-secondary' }} auditor-pill" data-auditor-id="{{ $a->id }}" data-label="{{ $dataLabel }}">
                        <i class="bi {{ $isUPM ? 'bi-shield-fill-check' : 'bi-person-check-fill' }} me-1"></i>{{ $pillLabel }}
                    </button>
                @empty
                    <span class="text-muted small">Tidak ada auditor terdaftar</span>
                @endforelse
            </div>
        </div>
    </div>



    {{-- NAV TABS --}}
    <ul class="nav nav-tabs" id="perbandinganTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="evaluasi-tab" data-bs-toggle="tab" data-bs-target="#evaluasi" type="button" role="tab" aria-controls="evaluasi" aria-selected="true">
                <i class="bi bi-list-check me-1"></i>Evaluasi Diri
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="syarat-tab" data-bs-toggle="tab" data-bs-target="#syarat" type="button" role="tab" aria-controls="syarat" aria-selected="false">
                <i class="bi bi-trophy me-1"></i>Syarat Unggul
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="chart-tab" data-bs-toggle="tab" data-bs-target="#chart" type="button" role="tab" aria-controls="chart" aria-selected="false">
                <i class="bi bi-bar-chart-line me-1"></i>Chart
            </button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="perbandinganTabContent">

        {{-- ======================== TAB 1: EVALUASI DIRI ======================== --}}
        <div class="tab-pane fade show active" id="evaluasi" role="tabpanel" aria-labelledby="evaluasi-tab">

            {{-- SUMMARY CARDS --}}
            <div class="row align-items-stretch g-3 py-3 py-md-0 my-2 my-md-0">
                <div class="col-md-5 d-flex">
                    <div class="card shadow-sm h-100 w-100 border-0 rounded-3">
                        <div class="card-header py-2 rounded-top-3" style="background: #173b70; color: #fff;">
                            <h5 class="mb-0"><i class="bi bi-building me-1"></i>Penilaian Mandiri Jurusan</h5>
                        </div>
                        <div class="card-body py-2">
                            <div class="d-flex">
                                <p class="mb-1 me-2 text-muted">Nilai Akreditasi:</p>
                                <p class="mb-1 fw-bold" id="nilai_jurusan"></p>
                            </div>
                            <div class="d-flex">
                                <p class="mb-1 me-2 text-muted">Status:</p>
                                <p class="mb-1 fw-semibold" id="status_jurusan"></p>
                            </div>
                            <div class="d-flex">
                                <p class="mb-0 me-2 text-muted">Masa Berlaku:</p>
                                <p class="mb-0 fw-bold" id="masa_jurusan"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 d-flex">
                    <div class="card shadow-sm h-100 w-100 border-0 rounded-3">
                        <div class="card-header py-2 rounded-top-3" style="background: #173b70; color: #fff;">
                            <h5 class="mb-0" id="auditorCardTitle"><i class="bi bi-shield-check me-1"></i>Penilaian UPM</h5>
                        </div>
                        <div class="card-body py-2">
                            <div id="auditorNamesContainer" class="mb-2"></div>
                            <div class="d-flex">
                                <p class="mb-1 me-2 text-muted">Nilai Akreditasi:</p>
                                <p class="mb-1 fw-bold" id="nilai_auditor"></p>
                            </div>
                            <div class="d-flex">
                                <p class="mb-1 me-2 text-muted">Status:</p>
                                <p class="mb-1 fw-semibold" id="status_auditor"></p>
                            </div>
                            <div class="d-flex">
                                <p class="mb-0 me-2 text-muted">Masa Berlaku:</p>
                                <p class="mb-0 fw-bold" id="masa_auditor"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 d-flex">
                    <div class="card shadow-sm h-100 w-100 border-0 rounded-3">
                        <div class="card-header py-2 rounded-top-3" style="background: #173b70; color: #fff;">
                            <h5 class="mb-0 text-center"><i class="bi bi-graph-up-arrow me-1"></i>Selisih</h5>
                        </div>
                        <div class="card-body py-2 d-flex align-items-center justify-content-center">
                            <h3 class="mb-0 fw-bold" id="selisih" style="color: #173b70;"></h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold" style="color: #173b70;"><i class="bi bi-list-check me-2"></i>Daftar Elemen</h4>
                <div>
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="previewPdf()">
                        <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                    </button>
                    <a class="btn btn-sm ms-2" style="background: #173b70; color: #fff;" href="{{ route('evaluasi_lamdik.index') }}">
                        <i class="bi bi-pencil-square me-1"></i>Isi Evaluasi
                    </a>
                </div>
            </div>

            <div class="table-responsive rounded-3">
                <table id="penetapanTable" class="table table-bordered table-striped mb-0">
                    <thead class="align-middle">
                        <tr>
                            <th class="text-white" style="background: #173b70;">No</th>
                            <th class="text-white" style="background: #173b70;">Kriteria</th>
                            <th class="text-white" style="background: #173b70;">Elemen</th>
                            <th class="text-white" style="background: #173b70;">Penilaian Jurusan</th>
                            <th id="thAuditor" class="text-white" style="background: #173b70;">Penilaian UPM</th>
                            <th class="text-white" style="background: #173b70; width:5%;">Selisih</th>
                            <th class="text-white" style="background: #173b70; width:22%;">Temuan</th>
                            <th class="text-white" style="background: #173b70; width:22%;">Saran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kriteria->name }}</td>
                                <td>{{ $item->elemen }}</td>
                                <td class="nilai-jurusan text-center" data-nilai="{{ $item->userMatrik?->nilai_total ?? 0 }}">
                                    {{ ($item->userMatrik?->nilai_total ?? 0) > 0 ? number_format($item->userMatrik->nilai_total, 2) : '-' }}
                                </td>
                                <td class="nilai-auditor text-center" data-auditor-data='@json($item->auditorMatriks)'>
                                    @php
                                        $firstAuditorScore = $item->auditorMatriks->first()?->nilai_total ?? 0;
                                    @endphp
                                    <span class="auditor-value">{{ $firstAuditorScore > 0 ? number_format($firstAuditorScore, 2) : '-' }}</span>
                                </td>
                                <td class="selisih-cell text-center">
                                    {{ $item->userMatrik && $firstAuditorScore > 0
                                        ? number_format(abs($item->userMatrik->nilai_total - $firstAuditorScore), 2)
                                        : '-' }}
                                </td>
                                <td class="temuan-cell" style="width:22%;text-align:justify;">{!! !empty($item->auditorMatriks->first()?->temuan) ? $item->auditorMatriks->first()->temuan : '-' !!}</td>
                                <td class="saran-cell" style="width:22%;text-align:justify;">{!! !empty($item->auditorMatriks->first()?->saran) ? $item->auditorMatriks->first()->saran : '-' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ======================== TAB 2: SYARAT UNGGUL ======================== --}}
        <div class="tab-pane fade" id="syarat" role="tabpanel" aria-labelledby="syarat-tab">

            {{-- TABEL STATUS AKREDITASI --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: #173b70; color: #fff;">
                    <h5 class="mb-0"><i class="bi bi-award me-1"></i>Status Akreditasi dan Masa Berlaku</h5>
                    <div>
                        <span class="fs-6 fw-bold me-3" style="color: #a3d9a5;">NA Jurusan: <span id="syaratNaDisplay">—</span></span>
                        <span class="fs-6 fw-bold" style="color: #ffd699;">NA <span class="auditor-syarat-label">UPM</span>: <span id="syaratNaAuditorDisplay">—</span></span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 align-middle text-center small" id="tabelStatusAkreditasi">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nilai Akreditasi</th>
                                    <th>Syarat 3 Thn</th>
                                    <th>Syarat 5 Thn</th>
                                    <th>Status</th>
                                    <th>Masa Berlaku</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-na-min="361" data-na-max="999" data-s3="1" data-s5="1">
                                    <td>1</td><td><strong>NA ≥ 361</strong></td>
                                    <td>Memenuhi</td><td>Memenuhi</td>
                                    <td><strong>Terakreditasi Unggul</strong></td><td>5 Tahun</td>
                                </tr>
                                <tr data-na-min="361" data-na-max="999" data-s3="1" data-s5="0">
                                    <td>2</td><td><strong>NA ≥ 361</strong></td>
                                    <td>Memenuhi</td><td>Tidak</td>
                                    <td><strong>Terakreditasi Unggul</strong></td><td>3 Tahun</td>
                                </tr>
                                <tr data-na-min="321" data-na-max="361" data-s3="*" data-s5="*">
                                    <td>3</td><td><strong>321 ≤ NA &lt; 361</strong></td>
                                    <td>V / X</td><td>V / X</td>
                                    <td>Terakreditasi</td><td>5 Tahun</td>
                                </tr>
                                <tr data-na-min="200" data-na-max="321" data-s3="*" data-s5="*">
                                    <td>4</td><td><strong>200 ≤ NA &lt; 321</strong></td>
                                    <td>V / X</td><td>V / X</td>
                                    <td>Terakreditasi</td><td>5 Tahun</td>
                                </tr>
                                <tr data-na-min="-999" data-na-max="200" data-s3="*" data-s5="*">
                                    <td>5</td><td><strong>NA &lt; 200</strong></td>
                                    <td>V / X</td><td>V / X</td>
                                    <td>Tidak Terakreditasi</td><td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- LEGEND --}}
            <div class="d-flex gap-4 justify-content-end mb-3 px-2 small">
                <span><span class="d-inline-block rounded-1 me-1" style="width:14px;height:14px;background:#a3d9a5;vertical-align:middle;"></span> Penilaian Mandiri Jurusan</span>
                <span><span class="d-inline-block rounded-1 me-1" style="width:14px;height:14px;background:#ffd699;vertical-align:middle;"></span> <span class="auditor-syarat-label">UPM</span></span>
            </div>

            {{-- SYARAT UNGGUL CARDS — comparison jurusan vs auditor --}}
            <div class="row g-4" id="syaratCardsContainer">
                @php $syaratTemplate = $jurusanSyarat; @endphp
                @foreach ($syaratTemplate as $idx => $su)
                    <div class="col-md-12">
                        <div class="card border border-secondary-subtle shadow-sm overflow-hidden">
                            <div class="card-header d-flex align-items-center justify-content-between py-3"
                                 style="background: #173b70; color: #fff;">
                                <div>
                                    <h5 class="mb-0 fw-bold text-white">
                                        Syarat {{ $su['nomor'] }}: {{ $su['elemen'] ?? '-' }}
                                    </h5>
                                    <small style="color: rgba(255,255,255,0.7);">
                                        <span class="badge bg-light text-dark me-1">{{ $su['kriteria'] }}</span>
                                    </small>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <h6 class="fw-bold text-uppercase" style="color: #173b70; font-size: 0.75rem; letter-spacing: 0.05em; border-bottom: 2px solid #173b70; padding-bottom: 4px; display: inline-block;">
                                        Indikator
                                    </h6>
                                    <p class="mb-0">{{ $su['indikator'] }}</p>
                                </div>

                                <div class="row g-3">
                                    {{-- Jurusan column --}}
                                    <div class="col-md-6">
                                        <div class="border rounded-3 p-3 h-100 bg-white" style="border-left: 4px solid #173b70 !important;">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <i class="bi bi-building" style="color: #173b70;"></i>
                                                <span class="fw-semibold">Penilaian Mandiri Jurusan</span>
                                            </div>
                                            @include('EvaluasiLamdik._syarat_card_body', [
                                                'su' => $su,
                                                'prefix' => 'jurusan'
                                            ])
                                        </div>
                                    </div>

                                    {{-- Auditor column (updated via JS) --}}
                                    <div class="col-md-6">
                                        <div class="border rounded-3 p-3 h-100 bg-white auditor-syarat-col" data-auditor-syarat='@json($auditorSyaratData)'
                                             style="border-left: 4px solid #173b70 !important;">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <i class="bi bi-shield-check" style="color: #173b70;"></i>
                                                <span class="fw-semibold auditor-syarat-label">Penilaian UPM</span>
                                            </div>
                                            <div class="auditor-syarat-body" data-idx="{{ $idx }}">
                                                {{-- Filled by JS on pill click --}}
                                                <div class="text-muted small">Pilih penilai untuk melihat data...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ======================== TAB 3: CHART ======================== --}}
        <div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="chart-tab">
            <div class="card shadow-sm">
                <div class="card-header py-2 d-flex justify-content-between" style="background: #173b70; color: #fff;">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-1"></i>Hasil Akreditasi {{ $userJurusan->homebase ?? '' }}</h5>
                    <div>
                        <button class="btn btn-sm btn-success me-2" onclick="previewPdf()">
                            <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                        </button>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <canvas id="radarChart"></canvas>
                    </div>
                    <div class="col-md-6 d-flex flex-column">
                        <div class="d-flex">
                            <p class="mb-1 me-2">Nilai Akreditasi Jurusan:</p>
                            <p class="mb-1 fw-bold" id="chart_na_jurusan"></p>
                        </div>
                        <div class="d-flex">
                            <p class="mb-1 me-2">Status Jurusan:</p>
                            <p class="mb-1 fw-bold" id="chart_status_jurusan"></p>
                        </div>
                        <div class="d-flex mb-2">
                            <p class="mb-0 me-2">Masa Berlaku Jurusan:</p>
                            <p class="mb-0 fw-bold" id="chart_masa_jurusan"></p>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <p class="mb-1 me-2">Nilai Akreditasi <span class="auditor-syarat-label">UPM</span>:</p>
                            <p class="mb-1 fw-bold" id="chart_na_auditor"></p>
                        </div>
                        <div class="d-flex">
                            <p class="mb-1 me-2">Status <span class="auditor-syarat-label">UPM</span>:</p>
                            <p class="mb-1 fw-bold" id="chart_status_auditor"></p>
                        </div>
                        <div class="d-flex mb-2">
                            <p class="mb-0 me-2">Masa Berlaku:</p>
                            <p class="mb-0 fw-bold" id="chart_masa_auditor"></p>
                        </div>

                        <table class="table table-bordered text-center align-middle mt-3" id="chartPerAspekTable">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kriteria</th>
                                    <th>Nilai Jurusan</th>
                                    <th class="chart-th-auditor">Nilai UPM</th>
                                    <th>Nilai Maks</th>
                                    <th>% Jurusan</th>
                                    <th class="chart-th-auditor">% UPM</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($perAspekMax as $aspek => $max)
                                    @php
                                        $jurusanVal = $perAspekJurusan[$aspek] ?? 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td class="text-start">{{ $aspek }}</td>
                                        <td class="chart-jurusan-val" data-na="{{ $jurusanVal }}">{{ number_format($jurusanVal, 2) }}</td>
                                        <td class="chart-auditor-val" data-auditor-aspek='@json($perAspekAuditor)'>-</td>
                                        <td>{{ $max }}</td>
                                        <td>{{ $max > 0 ? number_format(($jurusanVal / $max) * 100, 2) : 0 }}%</td>
                                        <td class="chart-auditor-pct">-</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between mb-2" id="chartTotalRow">
                            <span>Total Jurusan: <strong id="chartTotalJurusan">0</strong></span>
                            <span>Total <span class="auditor-syarat-label">UPM</span>: <strong id="chartTotalAuditor">0</strong></span>
                            <span>Maks: <strong id="chartTotalMax">0</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL PDF --}}
    <div class="modal fade" id="previewPdfModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: #173b70; color: #fff;">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-pdf me-2"></i>Preview Laporan Evaluasi Diri {{ auth()->user()->homebase ?? '' }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="previewPdfContent">
                    <div class="text-center text-muted py-4"><i class="bi bi-hourglass-split me-2"></i>Memuat preview...</div>
                </div>
                <div class="modal-footer">
                    <a id="downloadPdfLink" href="{{ url('/export/export-pdf/perbandingan') }}" target="_blank" class="btn btn-sm" style="background: #173b70; color: #fff;">
                        <i class="bi bi-download me-1"></i>Download PDF
                    </a>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- DATA JURUSAN SYARAT UNGGUL (untuk JS) --}}
    <script>
        let syarat3 = {{ $syarat3 ? 'true' : 'false' }};
        let syarat5 = {{ $syarat5 ? 'true' : 'false' }};
        const jurusanSyarat = @json($jurusanSyarat);
        const auditorSyaratData = @json($auditorSyaratData);
        const perAspekJurusan = @json($perAspekJurusan);
        const perAspekAuditor = @json($perAspekAuditor);
        const perAspekMax = @json($perAspekMax);
    </script>

    <script>
        function hitungAkreditasi(NA, syarat3, syarat5) {
            let status = "", masa = "";
            if (NA >= 361) {
                if (syarat5) { status = "Terakreditasi Unggul"; masa = "5 Tahun"; }
                else if (syarat3) { status = "Terakreditasi Unggul"; masa = "3 Tahun"; }
                else { status = "Terakreditasi"; masa = "5 Tahun"; }
            } else if (NA >= 321) {
                if (syarat5) { status = "Terakreditasi Unggul"; masa = "5 Tahun"; }
                else if (syarat3) { status = "Terakreditasi Unggul"; masa = "3 Tahun"; }
                else { status = "Terakreditasi"; masa = "5 Tahun"; }
            } else if (NA >= 200) { status = "Terakreditasi"; masa = "5 Tahun"; }
            else { status = "Tidak Terakreditasi"; masa = "-"; }
            return { status, masa };
        }

        // ---- Render syarat unggul body HTML for an auditor ----
        function renderSyaratBody(su, prefix) {
            let m3 = su.memenuhi_3, m5 = su.memenuhi_5;
            let d = su.detail || {};
            let border3 = m3 ? '#28a745' : '#dc3545';
            let border5 = m5 ? '#28a745' : '#dc3545';

            let html = '';
            // Data badges
            html += '<div class="mb-3">';
            html += '<h6 class="fw-bold text-uppercase" style="color: #173b70; font-size: 0.75rem; letter-spacing: 0.05em; border-bottom: 2px solid #173b70; padding-bottom: 4px; display: inline-block;">Data Saat Ini</h6>';
            html += '<div class="d-flex flex-wrap gap-2 mt-2">';
            if (su.nomor == 1) {
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">NDS3 = ${d.NDS3 ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">NDL = ${d.NDL ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">NDLK = ${d.NDLK ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">NDGB = ${d.NDGB ?? 0}</span>`;
                html += `<small class="text-muted d-block mt-1 w-100">Total Lektor = <strong>${d.totalLektor ?? 0}</strong></small>`;
            } else if (su.nomor >= 2 && su.nomor <= 4) {
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">Skor = ${d.skor ?? 0}</span>`;
            } else if (su.nomor == 5) {
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">NM = ${d.NM ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">S1 = ${d.S1 ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">S2 = ${d.S2 ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">S3 = ${d.S3 ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">S4 = ${d.S4 ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">S5 = ${d.S5 ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">S6 = ${d.S6 ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">INT = ${d.INT ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">ISBN = ${d.ISBN ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">PATEN = ${d.PATEN ?? 0}</span>`;
                if ((d.NM ?? 0) > 0) {
                    html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">Total (3thn) = ${d.total3 ?? 0}</span>`;
                    html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">${(d.persen3 ?? 0).toFixed(1)}% (3thn)</span>`;
                    html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">Total (5thn) = ${d.total5 ?? 0}</span>`;
                    html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">${(d.persen5 ?? 0).toFixed(1)}% (5thn)</span>`;
                }
            } else if (su.nomor == 6) {
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">NDTPS = ${d.NDTPS ?? 0}</span>`;
                html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">NDTPS_PUB = ${d.NDTPS_PUB ?? 0}</span>`;
                if ((d.NDTPS ?? 0) > 0) {
                    html += `<span class="badge bg-light text-dark border px-3 py-2 fs-6">${(d.persen3 ?? 0).toFixed(1)}%</span>`;
                }
            }
            html += '</div></div>';

            // Pemenuhan cards
            html += '<div class="row g-3">';
            // 3 Tahun
            html += `<div class="col-md-6"><div class="border rounded-3 p-3 h-100 bg-white" style="border-left: 4px solid ${border3} !important;">`;
            html += `<div class="d-flex align-items-center justify-content-between mb-2">`;
            html += `<span class="fw-semibold">Syarat 3 Tahun</span>`;
            html += m3 ? `<span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Terpenuhi</span>` : `<span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i>Belum Terpenuhi</span>`;
            html += `</div><p class="mb-1 small text-muted">${su.syarat_3}</p>`;
            if (su.nomor == 1) {
                html += `<div class="small mt-1">NDS3 ${(d.NDS3??0)} ${(d.NDS3??0) >= 1 ? '≥ 1 <i class="bi bi-check-circle-fill text-success"></i>' : '< 1 <i class="bi bi-x-circle-fill text-danger"></i>'} &nbsp;|&nbsp; Lektor ${(d.totalLektor??0)} ${(d.totalLektor??0) >= 2 ? '≥ 2 <i class="bi bi-check-circle-fill text-success"></i>' : '< 2 <i class="bi bi-x-circle-fill text-danger"></i>'}</div>`;
            } else if (su.nomor >= 2 && su.nomor <= 4) {
                html += `<div class="small mt-1">Skor ${(d.skor??0).toFixed(2)} ${(d.skor??0) >= 3.0 ? '≥ 3.0 <i class="bi bi-check-circle-fill text-success"></i>' : '< 3.0 <i class="bi bi-x-circle-fill text-danger"></i>'}</div>`;
            } else if (su.nomor == 5 && (d.NM??0) > 0) {
                html += `<div class="small mt-1">${(d.persen3??0).toFixed(1)}% ${(d.persen3??0) >= 15 ? '≥ 15% <i class="bi bi-check-circle-fill text-success"></i>' : '< 15% <i class="bi bi-x-circle-fill text-danger"></i>'}</div>`;
            } else if (su.nomor == 6 && (d.NDTPS??0) > 0) {
                html += `<div class="small mt-1">${(d.persen3??0).toFixed(1)}% ${(d.persen3??0) >= 20 ? '≥ 20% <i class="bi bi-check-circle-fill text-success"></i>' : '< 20% <i class="bi bi-x-circle-fill text-danger"></i>'}</div>`;
            }
            html += '</div></div>';

            // 5 Tahun
            html += `<div class="col-md-6"><div class="border rounded-3 p-3 h-100 bg-white" style="border-left: 4px solid ${border5} !important;">`;
            html += `<div class="d-flex align-items-center justify-content-between mb-2">`;
            html += `<span class="fw-semibold">Syarat 5 Tahun</span>`;
            html += m5 ? `<span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Terpenuhi</span>` : `<span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i>Belum Terpenuhi</span>`;
            html += `</div><p class="mb-1 small text-muted">${su.syarat_5}</p>`;
            if (su.nomor == 1) {
                html += `<div class="small mt-1">NDS3 ${(d.NDS3??0)} ${(d.NDS3??0) >= 2 ? '≥ 2 <i class="bi bi-check-circle-fill text-success"></i>' : '< 2 <i class="bi bi-x-circle-fill text-danger"></i>'} &nbsp;|&nbsp; Lektor ${(d.totalLektor??0)} ${(d.totalLektor??0) >= 2 ? '≥ 2 <i class="bi bi-check-circle-fill text-success"></i>' : '< 2 <i class="bi bi-x-circle-fill text-danger"></i>'} &nbsp;|&nbsp; LK ${(d.NDLK??0)} ${(d.NDLK??0) >= 1 ? '≥ 1 <i class="bi bi-check-circle-fill text-success"></i>' : '< 1 <i class="bi bi-x-circle-fill text-danger"></i>'}</div>`;
            } else if (su.nomor >= 2 && su.nomor <= 4) {
                html += `<div class="small mt-1">Skor ${(d.skor??0).toFixed(2)} ${(d.skor??0) >= 3.5 ? '≥ 3.5 <i class="bi bi-check-circle-fill text-success"></i>' : '< 3.5 <i class="bi bi-x-circle-fill text-danger"></i>'}</div>`;
            } else if (su.nomor == 5 && (d.NM??0) > 0) {
                html += `<div class="small mt-1">${(d.persen5??0).toFixed(1)}% ${(d.persen5??0) >= 25 ? '≥ 25% <i class="bi bi-check-circle-fill text-success"></i>' : '< 25% <i class="bi bi-x-circle-fill text-danger"></i>'}</div>`;
            } else if (su.nomor == 6 && (d.NDTPS??0) > 0) {
                html += `<div class="small mt-1">${(d.persen5??0).toFixed(1)}% ${(d.persen5??0) >= 20 ? '≥ 20% <i class="bi bi-check-circle-fill text-success"></i>' : '< 20% <i class="bi bi-x-circle-fill text-danger"></i>'}</div>`;
            }
            html += '</div></div>';

            html += '</div></div>';
            return html;
        }

        // ---- Render syarat unggul column for an auditor ----
        function updateSyaratAuditor(auditorId, label) {
            document.querySelectorAll('.auditor-syarat-label').forEach(el => {
                el.textContent = 'Penilaian ' + label;
            });

            let data = auditorSyaratData[auditorId];
            if (!data) {
                document.querySelectorAll('.auditor-syarat-body').forEach(el => {
                    el.innerHTML = '<div class="text-muted small">Tidak ada data untuk penilai ini.</div>';
                });
                return;
            }

            document.querySelectorAll('.auditor-syarat-body').forEach(el => {
                let idx = parseInt(el.dataset.idx);
                let su = data[idx];
                if (su) {
                    el.innerHTML = renderSyaratBody(su, 'auditor-' + auditorId);
                } else {
                    el.innerHTML = '<div class="text-muted small">Data tidak tersedia.</div>';
                }
            });
        }

        // ---- Update chart tab ----
        let radarChartInstance = null;

        function updateChart(auditorId, label) {
            // Update labels
            document.querySelectorAll('.auditor-syarat-label').forEach(el => {
                if (el.closest('#chart') || el.closest('.auditor-syarat-col')) {
                    el.textContent = 'Penilaian ' + label;
                }
            });
            document.querySelectorAll('.chart-th-auditor').forEach(el => {
                el.textContent = 'Nilai ' + label;
            });

            // Update per-aspek table
            let totalJurusan = 0, totalAuditor = 0, totalMax = 0;
            document.querySelectorAll('#chartPerAspekTable tbody tr').forEach(row => {
                let aspek = row.querySelector('.text-start')?.textContent?.trim();
                if (!aspek) return;
                let jurusanVal = parseFloat(row.querySelector('.chart-jurusan-val')?.dataset?.na) || 0;
                let max = parseFloat(row.cells[4]?.textContent) || 0;
                let auditorVal = (perAspekAuditor[auditorId] && perAspekAuditor[auditorId][aspek]) || 0;

                row.querySelector('.chart-auditor-val').textContent = auditorVal.toFixed(2);
                let pctAuditor = max > 0 ? (auditorVal / max) * 100 : 0;
                row.querySelector('.chart-auditor-pct').textContent = pctAuditor.toFixed(2) + '%';

                totalJurusan += jurusanVal;
                totalAuditor += auditorVal;
                totalMax += max;
            });

            document.getElementById('chartTotalJurusan').textContent = totalJurusan.toFixed(2);
            document.getElementById('chartTotalAuditor').textContent = totalAuditor.toFixed(2);
            document.getElementById('chartTotalMax').textContent = totalMax.toFixed(2);

            // NA & status
            document.getElementById('chart_na_jurusan').textContent = totalJurusan.toFixed(2);
            document.getElementById('chart_na_auditor').textContent = totalAuditor.toFixed(2);

            let hJ = hitungAkreditasi(totalJurusan, syarat3, syarat5);
            document.getElementById('chart_status_jurusan').textContent = hJ.status;
            document.getElementById('chart_masa_jurusan').textContent = hJ.masa;

            // Compute auditor syarat3/syarat5 from auditorSyaratData
            let audSyarat = auditorSyaratData[auditorId] || [];
            let audS3 = audSyarat.length > 0 ? audSyarat.every(s => s.memenuhi_3) : false;
            let audS5 = audSyarat.length > 0 ? audSyarat.every(s => s.memenuhi_5) : false;
            let hA = hitungAkreditasi(totalAuditor, audS3, audS5);
            document.getElementById('chart_status_auditor').textContent = hA.status;
            document.getElementById('chart_masa_auditor').textContent = hA.masa;

            // Sync syarat NA display
            document.getElementById('syaratNaDisplay').textContent = totalJurusan.toFixed(2);
            document.getElementById('syaratNaAuditorDisplay').textContent = totalAuditor.toFixed(2);

            // Highlight tabel status akreditasi (jurusan + auditor)
            document.querySelectorAll("#tabelStatusAkreditasi tbody tr").forEach(row => {
                let naMin = parseFloat(row.dataset.naMin);
                let naMax = parseFloat(row.dataset.naMax);
                let s3 = row.dataset.s3;
                let s5 = row.dataset.s5;

                row.classList.remove('table-success', 'table-warning', 'fw-bold');

                // Jurusan match
                let jMatchNa = totalJurusan >= naMin && totalJurusan < naMax;
                let jMatchS3 = s3 === '*' || parseInt(s3) === (syarat3 ? 1 : 0);
                let jMatchS5 = s5 === '*' || parseInt(s5) === (syarat5 ? 1 : 0);
                if (jMatchNa && jMatchS3 && jMatchS5) {
                    row.classList.add('table-success', 'fw-bold');
                }

                // Auditor match
                let aMatchNa = totalAuditor >= naMin && totalAuditor < naMax;
                let aMatchS3 = s3 === '*' || parseInt(s3) === (audS3 ? 1 : 0);
                let aMatchS5 = s5 === '*' || parseInt(s5) === (audS5 ? 1 : 0);
                if (aMatchNa && aMatchS3 && aMatchS5) {
                    row.classList.add('table-warning');
                }
            });

            // Radar chart
            let ctx = document.getElementById('radarChart');
            if (!ctx) return;

            let labels = Object.keys(perAspekMax);
            let jurusanPct = labels.map(k => {
                let max = perAspekMax[k] || 1;
                return ((perAspekJurusan[k] || 0) / max) * 100;
            });
            let auditorPct = labels.map(k => {
                let max = perAspekMax[k] || 1;
                let val = (perAspekAuditor[auditorId] && perAspekAuditor[auditorId][k]) || 0;
                return (val / max) * 100;
            });

            if (radarChartInstance) {
                radarChartInstance.destroy();
            }

            radarChartInstance = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Jurusan (%)',
                            data: jurusanPct,
                            fill: true,
                            backgroundColor: 'rgba(23, 59, 112, 0.2)',
                            borderColor: '#173b70',
                            pointBackgroundColor: '#173b70',
                        },
                        {
                            label: label + ' (%)',
                            data: auditorPct,
                            fill: true,
                            backgroundColor: 'rgba(40, 167, 69, 0.2)',
                            borderColor: '#28a745',
                            pointBackgroundColor: '#28a745',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: { r: { min: 0, max: 100 } }
                }
            });
        }

        // ---- Tab 1 helpers ----
        function compute(auditorId) {
            let totalJurusan = 0;
            document.querySelectorAll(".nilai-jurusan").forEach(el => {
                totalJurusan += parseFloat(el.dataset.nilai) || 0;
            });

            let totalAuditor = 0;
            document.querySelectorAll(".nilai-auditor .auditor-value").forEach(el => {
                totalAuditor += parseFloat(el.textContent) || 0;
            });

            document.getElementById("nilai_jurusan").innerHTML = totalJurusan.toFixed(2);
            document.getElementById("nilai_auditor").innerHTML = totalAuditor.toFixed(2);
            document.getElementById("selisih").innerHTML = Math.abs(totalJurusan - totalAuditor).toFixed(2);

            let hasilJurusan = hitungAkreditasi(totalJurusan, syarat3, syarat5);
            document.getElementById("status_jurusan").innerHTML = hasilJurusan.status;
            document.getElementById("masa_jurusan").innerHTML = hasilJurusan.masa;

            // Use the provided auditorId, otherwise fall back to first auditor
            let aid = auditorId || Object.keys(auditorSyaratData)[0];
            let audSyarat = auditorSyaratData[aid] || [];
            let audS3 = audSyarat.every(s => s.memenuhi_3);
            let audS5 = audSyarat.every(s => s.memenuhi_5);
            let hasilAuditor = hitungAkreditasi(totalAuditor, audS3, audS5);
            document.getElementById("status_auditor").innerHTML = hasilAuditor.status;
            document.getElementById("masa_auditor").innerHTML = hasilAuditor.masa;
        }

        // Auditor name mapping for card header
        var auditorNameMap = @json($auditorNameMap ?? []);

        function updateAuditorNames(label) {
            var container = document.getElementById('auditorNamesContainer');
            if (!container) return;
            if (label === 'Auditor') {
                var html = Object.entries(auditorNameMap).map(function(e) {
                    return '<p class="mb-1"><span class="text-muted">' + e[0] + ':</span> <span class="fw-bold">' + e[1] + '</span></p>';
                }).join('');
                container.innerHTML = html;
            } else {
                container.innerHTML = '';
            }
        }

        // ---- Tab 1 pill click handler (also syncs tabs 2 & 3) ----
        document.querySelectorAll(".auditor-pill").forEach(btn => {
            btn.addEventListener("click", function() {
                document.querySelectorAll(".auditor-pill").forEach(b => {
                    b.classList.remove("btn-primary", "active");
                    b.classList.add("btn-outline-secondary");
                });
                this.classList.remove("btn-outline-secondary");
                this.classList.add("btn-primary", "active");

                let auditorId = this.dataset.auditorId;
                let label = this.dataset.label;

                // Tab 1: card + table header
                document.getElementById("auditorCardTitle").innerHTML =
                    '<i class="bi bi-shield-check me-1"></i>Penilaian ' + label;
                document.getElementById("thAuditor").textContent = "Penilaian " + label;

                updateAuditorNames(label);

                // Tab 1: update all rows
                document.querySelectorAll(".nilai-auditor").forEach(td => {
                    let data;
                    try { data = JSON.parse(td.dataset.auditorData); } catch (e) { data = []; }
                    let valSpan = td.querySelector(".auditor-value");
                    let row = td.closest("tr");
                    let match = data.find(d => String(d.id_users) === auditorId);
                    let score = match ? match.nilai_total : null;
                    valSpan.textContent = score !== null && score > 0 ? Number(score).toFixed(2) : "-";

                    let jurusanVal = parseFloat(row.querySelector(".nilai-jurusan").dataset.nilai) || 0;
                    let selCell = row.querySelector(".selisih-cell");
                    selCell.textContent = score !== null && score > 0 ? Math.abs(jurusanVal - score).toFixed(2) : "-";

                    let temuanCell = row.querySelector(".temuan-cell");
                    let saranCell = row.querySelector(".saran-cell");
                    temuanCell.innerHTML = match ? (match.temuan || '-') : '-';
                    saranCell.innerHTML = match ? (match.saran || '-') : '-';
                });

                compute(auditorId);

                // Tab 2: update syarat unggul
                updateSyaratAuditor(auditorId, label);

                // Tab 3: update chart
                updateChart(auditorId, label);
            });
        });

        // ---- Init ----
        document.addEventListener("DOMContentLoaded", function() {
            $('#penetapanTable').DataTable({
                pageLength: 65,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: { first: "Pertama", last: "Terakhir", next: "Berikutnya", previous: "Sebelumnya" },
                    emptyTable: "Tidak ada data"
                }
            });

            let firstPill = document.querySelector('.auditor-pill');
            if (firstPill) {
                let auditorId = firstPill.dataset.auditorId;
                let label = firstPill.dataset.label;

                // Tab 1: card + table header
                document.getElementById("auditorCardTitle").innerHTML =
                    '<i class="bi bi-shield-check me-1"></i>Penilaian ' + label;
                document.getElementById("thAuditor").textContent = "Penilaian " + label;

                updateAuditorNames(label);

                compute(auditorId);
                updateSyaratAuditor(auditorId, label);
                updateChart(auditorId, label);
            } else {
                compute();
            }
        });
    </script>

    <script>
        function previewPdf() {
            const modal = new bootstrap.Modal(document.getElementById('previewPdfModal'));
            const content = document.getElementById('previewPdfContent');
            modal.show();
            content.innerHTML = '<div class="text-center text-muted py-4"><i class="bi bi-hourglass-split me-2"></i>Memuat preview...</div>';
            const activePill = document.querySelector('.auditor-pill.btn-primary');
            const isUPM = activePill && activePill.dataset.label === 'UPM';
            const auditorId = activePill && !isUPM ? activePill.dataset.auditorId : '';
            const params = auditorId ? '?auditor_id=' + auditorId : '';
            const url = '/export/preview/perbandingan' + params;
            document.getElementById('downloadPdfLink').href = '/export/export-pdf/perbandingan' + params;
            fetch(url)
                .then(res => res.text())
                .then(html => { content.innerHTML = html; })
                .catch(() => { content.innerHTML = '<div class="text-danger text-center py-4"><i class="bi bi-exclamation-triangle me-2"></i>Gagal memuat preview</div>'; });
        }
    </script>

@endsection
