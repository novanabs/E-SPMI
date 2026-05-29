@extends('layouts.app')

@section('title', 'Syarat Unggul ' . (auth()->user()->homebase ?? ''))

@section('content')

    {{-- TABEL STATUS AKREDITASI --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background: #173b70; color: #fff;">
            <h5 class="mb-0">Status Akreditasi dan Masa Berlaku</h5>
            <span class="fs-6 fw-bold" id="nilaiAkreditasiDisplay" style="color: #ffd700;">NA: —</span>
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

    <div class="row g-4">
        @foreach ($data as $item)
            @php
                $syarat = json_decode($item->syarat_tahun, true);

                $memenuhi3 = false;
                $memenuhi5 = false;

                $subItems = json_decode($item->matriks->subItemElemen ?? '[]', true);
                $userValues = json_decode($item->matriks->userSubItemElements ?? '[]', true);
                $nilaiMap = [];
                foreach ($userValues as $val) {
                    $nilaiMap[$val['id_sub_item_elemen']] = $val['nilai'];
                }

                if ($item->nomor == 1) {
                    $NDS3 = $NDL = $NDLK = $NDGB = 0;
                    foreach ($subItems as $sub) {
                        $v = $sub['variabel'];
                        $n = $nilaiMap[$sub['id']] ?? 0;
                        if ($v == 'NDS3') $NDS3 = $n;
                        if ($v == 'NDL') $NDL = $n;
                        if ($v == 'NDLK') $NDLK = $n;
                        if ($v == 'NDGB') $NDGB = $n;
                    }
                    $totalLektor = $NDL + $NDLK + $NDGB;
                    $memenuhi3 = $NDS3 >= 1 && $totalLektor >= 2;
                    $memenuhi5 = $NDS3 >= 2 && $totalLektor >= 2 && $NDLK >= 1;
                } elseif (in_array($item->nomor, [2, 3, 4])) {
                    $jawaban = (float) ($item->matriks->userMatrik->jawaban ?? 0);
                    $memenuhi3 = $jawaban >= 3.0;
                    $memenuhi5 = $jawaban >= 3.5;
                } elseif ($item->nomor == 5) {
                    $NM = 0; $S1=$S2=$S3=$S4=$S5=$S6=0; $INT=$ISBN=$PATEN=0;
                    foreach ($subItems as $sub) {
                        $v = $sub['variabel']; $n = $nilaiMap[$sub['id']] ?? 0;
                        if ($v == 'NM') $NM = $n;
                        if ($v == 'SINTA1_MHS') $S1 = $n;
                        if ($v == 'SINTA2_MHS') $S2 = $n;
                        if ($v == 'SINTA3_MHS') $S3 = $n;
                        if ($v == 'SINTA4_MHS') $S4 = $n;
                        if ($v == 'SINTA5_MHS') $S5 = $n;
                        if ($v == 'SINTA6_MHS') $S6 = $n;
                        if ($v == 'INT_MHS') $INT = $n;
                        if ($v == 'ISBN_MHS') $ISBN = $n;
                        if ($v == 'PATEN_MHS') $PATEN = $n;
                    }
                    if ($NM > 0) {
                        $total3 = $S1+$S2+$S3+$S4+$S5+$INT+$ISBN+$PATEN;
                        $persen3 = ($total3/$NM)*100;
                        $memenuhi3 = $persen3 >= 15;
                        $total5 = $S1+$S2+$S3+$S4+$INT+$ISBN+$PATEN;
                        $persen5 = ($total5/$NM)*100;
                        $memenuhi5 = $persen5 >= 25;
                    }
                } elseif ($item->nomor == 6) {
                    $NDTPS = 0; $NDTPS_PUB = 0;
                    foreach ($subItems as $sub) {
                        $v = $sub['variabel']; $n = $nilaiMap[$sub['id']] ?? 0;
                        if ($v == 'NDTPS') $NDTPS = $n;
                        if ($v == 'NDTPS_PUB') $NDTPS_PUB = $n;
                    }
                    if ($NDTPS > 0) {
                        $persen3 = ($NDTPS_PUB / $NDTPS) * 100;
                        $persen5 = $persen3;
                        $memenuhi3 = $persen3 >= 20;
                        $memenuhi5 = $persen5 >= 20;
                    }
                }
            @endphp

            <div class="col-md-12">
                <div class="card border border-secondary-subtle shadow-sm overflow-hidden">

                    <div class="card-header d-flex align-items-center justify-content-between py-3"
                         style="background: #173b70; color: #fff;">
                        <div>
                            <h5 class="mb-0 fw-bold text-white">
                                Syarat {{ $item->nomor }}: {{ $item->elemen ?? '-' }}
                            </h5>
                            <small class="text-white-50">
                                {{ $item->matriks->elemen ?? '-' }}
                            </small>
                        </div>
                        <div class="text-end">
                            @if ($memenuhi5)
                                <span class="badge bg-success fs-6 px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i>Terpenuhi 5 Tahun</span>
                            @elseif ($memenuhi3)
                                <span class="badge bg-warning text-dark fs-6 px-3 py-2"><i class="bi bi-exclamation-triangle-fill me-1"></i>Terpenuhi 3 Tahun</span>
                            @else
                                <span class="badge bg-danger fs-6 px-3 py-2"><i class="bi bi-x-circle-fill me-1"></i>Belum Terpenuhi</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body p-4">

                        <div class="mb-4">
                            <h6 class="fw-bold text-uppercase" style="color: #173b70; font-size: 0.75rem; letter-spacing: 0.05em; border-bottom: 2px solid #173b70; padding-bottom: 4px; display: inline-block;">
                                Indikator
                            </h6>
                            <p class="mb-0">{{ $item->indikator }}</p>
                        </div>

                        @if ($item->nomor == 1)
                            <div class="mb-4">
                                <h6 class="fw-bold text-uppercase" style="color: #173b70; font-size: 0.75rem; letter-spacing: 0.05em; border-bottom: 2px solid #173b70; padding-bottom: 4px; display: inline-block;">
                                    Data Saat Ini
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">NDS3 = {{ $NDS3 ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">NDL = {{ $NDL ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">NDLK = {{ $NDLK ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">NDGB = {{ $NDGB ?? 0 }}</span>
                                </div>
                                <small class="text-muted d-block mt-1">Total Lektor (NDL+NDLK+NDGB) = <strong>{{ $totalLektor ?? 0 }}</strong></small>
                            </div>
                        @elseif (in_array($item->nomor, [2, 3, 4]))
                            <div class="mb-4">
                                <h6 class="fw-bold text-uppercase" style="color: #173b70; font-size: 0.75rem; letter-spacing: 0.05em; border-bottom: 2px solid #173b70; padding-bottom: 4px; display: inline-block;">
                                    Data Saat Ini
                                </h6>
                                <span class="badge bg-light text-dark border fs-6 px-3 py-2">Skor = {{ $jawaban ?? 0 }}</span>
                            </div>
                        @elseif ($item->nomor == 5)
                            <div class="mb-4">
                                <h6 class="fw-bold text-uppercase" style="color: #173b70; font-size: 0.75rem; letter-spacing: 0.05em; border-bottom: 2px solid #173b70; padding-bottom: 4px; display: inline-block;">
                                    Data Saat Ini
                                </h6>
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">NM = {{ $NM ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">S1 = {{ $S1 ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">S2 = {{ $S2 ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">S3 = {{ $S3 ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">S4 = {{ $S4 ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">S5 = {{ $S5 ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">S6 = {{ $S6 ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">INT = {{ $INT ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">ISBN = {{ $ISBN ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">PATEN = {{ $PATEN ?? 0 }}</span>
                                    @if (($NM ?? 0) > 0)
                                        <span class="badge bg-light text-dark border fs-6 px-3 py-2">Total (3thn) = {{ $total3 ?? 0 }}</span>
                                        <span class="badge bg-light text-dark border fs-6 px-3 py-2">{{ number_format($persen3 ?? 0, 1) }}% (3thn)</span>
                                        <span class="badge bg-light text-dark border fs-6 px-3 py-2">Total (5thn) = {{ $total5 ?? 0 }}</span>
                                        <span class="badge bg-light text-dark border fs-6 px-3 py-2">{{ number_format($persen5 ?? 0, 1) }}% (5thn)</span>
                                    @endif
                                </div>
                            </div>
                        @elseif ($item->nomor == 6)
                            <div class="mb-4">
                                <h6 class="fw-bold text-uppercase" style="color: #173b70; font-size: 0.75rem; letter-spacing: 0.05em; border-bottom: 2px solid #173b70; padding-bottom: 4px; display: inline-block;">
                                    Data Saat Ini
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">NDTPS = {{ $NDTPS ?? 0 }}</span>
                                    <span class="badge bg-light text-dark border fs-6 px-3 py-2">NDTPS_PUB = {{ $NDTPS_PUB ?? 0 }}</span>
                                </div>
                            </div>
                        @endif

                        @php
                            $border3 = $memenuhi3 ? '#28a745' : '#dc3545';
                            $border5 = $memenuhi5 ? '#28a745' : '#dc3545';
                        @endphp
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100 bg-white" style="border-left: 4px solid {{ $border3 }} !important;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold">Syarat 3 Tahun</span>
                                        <span class="badge rounded-pill {{ $memenuhi3 ? 'bg-success' : 'bg-danger' }} px-3 py-1">{!! $memenuhi3 ? '<i class="bi bi-check-circle-fill me-1"></i>Terpenuhi' : '<i class="bi bi-x-circle-fill me-1"></i>Belum' !!}</span>
                                    </div>
                                    <p class="mb-1 small text-muted">{{ $syarat['3_tahun'] ?? '-' }}</p>
                                    @if ($item->nomor == 1)
                                        <div class="small mt-1">
                                            NDS3 {{ $NDS3 }} {!! $NDS3 >= 1 ? '≥ 1 <i class="bi bi-check-circle-fill text-success"></i>' : '< 1 <i class="bi bi-x-circle-fill text-danger"></i>' !!} &nbsp;|&nbsp;
                                            Lektor {{ $totalLektor ?? 0 }} {!! ($totalLektor ?? 0) >= 2 ? '≥ 2 <i class="bi bi-check-circle-fill text-success"></i>' : '< 2 <i class="bi bi-x-circle-fill text-danger"></i>' !!}
                                        </div>
                                    @elseif (in_array($item->nomor, [2, 3, 4]))
                                        <div class="small mt-1">Skor {{ $jawaban ?? 0 }} {!! ($jawaban??0) >= 3.0 ? '≥ 3.0 <i class="bi bi-check-circle-fill text-success"></i>' : '< 3.0 <i class="bi bi-x-circle-fill text-danger"></i>' !!}</div>
                                    @elseif ($item->nomor == 5 && ($NM??0) > 0)
                                        <div class="small mt-1">{!! number_format($persen3??0,1) !!}% mahasiswa {!! ($persen3??0) >= 15 ? '≥ 15% <i class="bi bi-check-circle-fill text-success"></i>' : '< 15% <i class="bi bi-x-circle-fill text-danger"></i>' !!}</div>
                                    @elseif ($item->nomor == 6 && ($NDTPS??0) > 0)
                                        <div class="small mt-1">{!! number_format($persen3??0,1) !!}% DTPS {!! ($persen3??0) >= 20 ? '≥ 20% <i class="bi bi-check-circle-fill text-success"></i>' : '< 20% <i class="bi bi-x-circle-fill text-danger"></i>' !!}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100 bg-white" style="border-left: 4px solid {{ $border5 }} !important;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold">Syarat 5 Tahun</span>
                                        <span class="badge rounded-pill {{ $memenuhi5 ? 'bg-success' : 'bg-danger' }} px-3 py-1">{!! $memenuhi5 ? '<i class="bi bi-check-circle-fill me-1"></i>Terpenuhi' : '<i class="bi bi-x-circle-fill me-1"></i>Belum' !!}</span>
                                    </div>
                                    <p class="mb-1 small text-muted">{{ $syarat['5_tahun'] ?? '-' }}</p>
                                    @if ($item->nomor == 1)
                                        <div class="small mt-1">
                                            NDS3 {{ $NDS3 }} {!! $NDS3 >= 2 ? '≥ 2 <i class="bi bi-check-circle-fill text-success"></i>' : '< 2 <i class="bi bi-x-circle-fill text-danger"></i>' !!} &nbsp;|&nbsp;
                                            Lektor {{ $totalLektor ?? 0 }} {!! ($totalLektor ?? 0) >= 2 ? '≥ 2 <i class="bi bi-check-circle-fill text-success"></i>' : '< 2 <i class="bi bi-x-circle-fill text-danger"></i>' !!} &nbsp;|&nbsp;
                                            LK {{ $NDLK }} {!! $NDLK >= 1 ? '≥ 1 <i class="bi bi-check-circle-fill text-success"></i>' : '< 1 <i class="bi bi-x-circle-fill text-danger"></i>' !!}
                                        </div>
                                    @elseif (in_array($item->nomor, [2, 3, 4]))
                                        <div class="small mt-1">Skor {{ $jawaban ?? 0 }} {!! ($jawaban??0) >= 3.5 ? '≥ 3.5 <i class="bi bi-check-circle-fill text-success"></i>' : '< 3.5 <i class="bi bi-x-circle-fill text-danger"></i>' !!}</div>
                                    @elseif ($item->nomor == 5 && ($NM??0) > 0)
                                        <div class="small mt-1">{!! number_format($persen5??0,1) !!}% mahasiswa {!! ($persen5??0) >= 25 ? '≥ 25% <i class="bi bi-check-circle-fill text-success"></i>' : '< 25% <i class="bi bi-x-circle-fill text-danger"></i>' !!}</div>
                                    @elseif ($item->nomor == 6 && ($NDTPS??0) > 0)
                                        <div class="small mt-1">{!! number_format($persen5??0,1) !!}% DTPS {!! ($persen5??0) >= 20 ? '≥ 20% <i class="bi bi-check-circle-fill text-success"></i>' : '< 20% <i class="bi bi-x-circle-fill text-danger"></i>' !!}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @php
        $displayNA = number_format($na, 2);
        $s3 = $syarat3 ? 'true' : 'false';
        $s5 = $syarat5 ? 'true' : 'false';
    @endphp
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let total = {{ $na }};
            let syarat3 = {{ $s3 }};
            let syarat5 = {{ $s5 }};

            document.getElementById("nilaiAkreditasiDisplay").innerText = "NA: " + total.toFixed(2);

            document.querySelectorAll("#tabelStatusAkreditasi tbody tr").forEach(row => {
                let naMin = parseFloat(row.dataset.naMin);
                let naMax = parseFloat(row.dataset.naMax);
                let s3 = row.dataset.s3;
                let s5 = row.dataset.s5;

                let matchNa = total >= naMin && total < naMax;
                let matchS3 = s3 === '*' || parseInt(s3) === (syarat3 ? 1 : 0);
                let matchS5 = s5 === '*' || parseInt(s5) === (syarat5 ? 1 : 0);

                if (matchNa && matchS3 && matchS5) {
                    row.classList.add('table-success', 'fw-bold');
                }
            });
        });
    </script>

@endsection
