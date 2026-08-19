@php
    $m3 = $su['memenuhi_3'] ?? false;
    $m5 = $su['memenuhi_5'] ?? false;
    $d = $su['detail'] ?? [];
    $border3 = $m3 ? '#28a745' : '#dc3545';
    $border5 = $m5 ? '#28a745' : '#dc3545';
@endphp

<div class="mb-3">
    <h6 class="fw-bold text-uppercase"
        style="color: #173b70; font-size: 0.75rem; letter-spacing: 0.05em; border-bottom: 2px solid #173b70; padding-bottom: 4px; display: inline-block;">
        Data Saat Ini
    </h6>
    <div class="d-flex flex-wrap gap-2 mt-2">
        @if ($su['nomor'] == 1)
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">NDS3 = {{ $d['NDS3'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">NDL = {{ $d['NDL'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">NDLK = {{ $d['NDLK'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">NDGB = {{ $d['NDGB'] ?? 0 }}</span>
            <small class="text-muted d-block mt-1 w-100">Total Lektor =
                <strong>{{ $d['totalLektor'] ?? 0 }}</strong></small>
        @elseif (in_array($su['nomor'], [2, 3, 4]))
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">Skor = {{ $d['skor'] ?? 0 }}</span>
        @elseif ($su['nomor'] == 5)
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">NM = {{ $d['NM'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">S1 = {{ $d['S1'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">S2 = {{ $d['S2'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">S3 = {{ $d['S3'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">S4 = {{ $d['S4'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">S5 = {{ $d['S5'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">INT = {{ $d['INT'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">ISBN = {{ $d['ISBN'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">PATEN = {{ $d['PATEN'] ?? 0 }}</span>
            @if (($d['NM'] ?? 0) > 0)
                <span class="badge bg-light text-dark border px-3 py-2 fs-6">Total (3thn) =
                    {{ $d['total3'] ?? 0 }}</span>
                <span
                    class="badge bg-light text-dark border px-3 py-2 fs-6">{{ number_format($d['persen3'] ?? 0, 1) }}%
                    (3thn)</span>
                <span class="badge bg-light text-dark border px-3 py-2 fs-6">Total (5thn) =
                    {{ $d['total5'] ?? 0 }}</span>
                <span
                    class="badge bg-light text-dark border px-3 py-2 fs-6">{{ number_format($d['persen5'] ?? 0, 1) }}%
                    (5thn)</span>
            @endif
        @elseif ($su['nomor'] == 6)
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">NDTPS = {{ $d['NDTPS'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">S4 = {{ $d['S4'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">S3 = {{ $d['S3'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">S2 = {{ $d['S2'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">S1 = {{ $d['S1'] ?? 0 }}</span>
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">INT = {{ $d['INT'] ?? 0 }}</span>
            @if (($d['NDTPS'] ?? 0) > 0)
                <div class="mt-2 w-100">
                    <small class="text-muted d-block">3 Tahun: Total = S4+S3+S2+S1+INT =
                        <strong>{{ $d['total3'] ?? 0 }}</strong> → {{ number_format($d['persen3'] ?? 0, 1) }}%</small>
                    <small class="text-muted d-block">5 Tahun: Total = S2+S1+INT =
                        <strong>{{ $d['total5'] ?? 0 }}</strong> → {{ number_format($d['persen5'] ?? 0, 1) }}%</small>
                </div>
            @endif
        @endif
    </div>
</div>

<div class="row g-3">
    {{-- 3 Tahun --}}
    <div class="col-md-6">
        <div class="border rounded-3 p-3 h-100 bg-white"
            style="border-left: 4px solid {{ $border3 }} !important;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-semibold">Syarat 3 Tahun</span>
                @if ($m3)
                    <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Terpenuhi</span>
                @else
                    <span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i>Belum Terpenuhi</span>
                @endif
            </div>
            <p class="mb-1 small text-muted">{{ $su['syarat_3'] }}</p>
            @if ($su['nomor'] == 1)
                <div class="small mt-1">
                    NDS3 {{ $d['NDS3'] ?? 0 }}
                    @if (($d['NDS3'] ?? 0) >= 1)
                        ≥ 1 <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 1 <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                    &nbsp;|&nbsp;
                    Lektor {{ $d['totalLektor'] ?? 0 }}
                    @if (($d['totalLektor'] ?? 0) >= 2)
                        ≥ 2 <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 2 <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                </div>
            @elseif (in_array($su['nomor'], [2, 3, 4]))
                <div class="small mt-1">
                    Skor {{ number_format($d['skor'] ?? 0, 2) }}
                    @if (($d['skor'] ?? 0) >= 3.0)
                        ≥ 3.0 <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 3.0 <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                </div>
            @elseif ($su['nomor'] == 5 && ($d['NM'] ?? 0) > 0)
                <div class="small mt-1">
                    {{ number_format($d['persen3'] ?? 0, 1) }}%
                    @if (($d['persen3'] ?? 0) >= 15)
                        ≥ 15% <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 15% <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                </div>
            @elseif ($su['nomor'] == 6 && ($d['NDTPS'] ?? 0) > 0)
                <div class="small mt-1">
                    {{ number_format($d['persen3'] ?? 0, 1) }}%
                    @if (($d['persen3'] ?? 0) >= 20)
                        ≥ 20% <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 20% <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- 5 Tahun --}}
    <div class="col-md-6">
        <div class="border rounded-3 p-3 h-100 bg-white"
            style="border-left: 4px solid {{ $border5 }} !important;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-semibold">Syarat 5 Tahun</span>
                @if ($m5)
                    <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Terpenuhi</span>
                @else
                    <span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i>Belum Terpenuhi</span>
                @endif
            </div>
            <p class="mb-1 small text-muted">{{ $su['syarat_5'] }}</p>
            @if ($su['nomor'] == 1)
                <div class="small mt-1">
                    NDS3 {{ $d['NDS3'] ?? 0 }}
                    @if (($d['NDS3'] ?? 0) >= 2)
                        ≥ 2 <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 2 <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                    &nbsp;|&nbsp;
                    Lektor & LK & GB {{ $d['totalLektor'] ?? 0 }}
                    @if (($d['totalLektor'] ?? 0) >= 2)
                        ≥ 2 <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 2 <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                    &nbsp;|&nbsp;
                    LK & GB {{ $d['efektifLK'] ?? 0 }}
                    @if (($d['efektifLK'] ?? 0) >= 1)
                        ≥ 1 <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 1 <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                </div>
            @elseif (in_array($su['nomor'], [2, 3, 4]))
                <div class="small mt-1">
                    Skor {{ number_format($d['skor'] ?? 0, 2) }}
                    @if (($d['skor'] ?? 0) >= 3.5)
                        ≥ 3.5 <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 3.5 <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                </div>
            @elseif ($su['nomor'] == 5 && ($d['NM'] ?? 0) > 0)
                <div class="small mt-1">
                    {{ number_format($d['persen5'] ?? 0, 1) }}%
                    @if (($d['persen5'] ?? 0) >= 25)
                        ≥ 25% <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 25% <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                </div>
            @elseif ($su['nomor'] == 6 && ($d['NDTPS'] ?? 0) > 0)
                <div class="small mt-1">
                    {{ number_format($d['persen5'] ?? 0, 1) }}%
                    @if (($d['persen5'] ?? 0) >= 20)
                        ≥ 20% <i class="bi bi-check-circle-fill text-success"></i>
                    @else
                        &lt; 20% <i class="bi bi-x-circle-fill text-danger"></i>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
