{{-- Shared Year Card Partial — uses auditor dashboard card styling --}}
<style>
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

    .audit-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 24px;
    }
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
    .status-inactive {
        background: rgba(239,68,68,.10);
        color: #b91c1c;
    }
    .btn-audit {
        width: 100%;
        border: none;
        background: linear-gradient(135deg,#0f172a,#1e293b);
        color: white;
        padding: 14px 24px;
        border-radius: 16px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: .25s ease;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-audit:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(15,23,42,.18);
        color: white;
    }

    {{-- Add Year Card — same grid slot --}}
    .add-year-card {
        background: white;
        border-radius: 24px;
        padding: 26px;
        border: 2px dashed #cbd5e1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        min-height: 100%;
        transition: .3s ease;
        cursor: pointer;
    }
    .add-year-card:hover {
        border-color: #2563eb;
        background: #f8fafc;
    }
    .add-year-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(37,99,235,.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 24px;
    }
    .add-year-label {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
    }
    .add-year-form-inline {
        display: none;
        width: 100%;
        margin-top: 4px;
    }
    .add-year-input-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .add-year-input-group input {
        flex: 1;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        padding: 10px 14px;
        font-size: 14px;
        text-align: center;
        font-weight: 600;
        transition: .2s;
    }
    .add-year-input-group input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,.15);
        outline: none;
    }
    .add-year-input-group button {
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
        font-size: 14px;
        background: linear-gradient(135deg,#2563eb,#1d4ed8);
        border: none;
        color: white;
        cursor: pointer;
        transition: .2s;
    }
    .add-year-input-group button:hover {
        box-shadow: 0 4px 14px rgba(37,99,235,.3);
    }
    .add-year-cancel {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 13px;
        cursor: pointer;
        margin-top: 4px;
    }
    .add-year-cancel:hover {
        color: #64748b;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="page-header">
    <div class="page-title">{{ $title }}</div>
    <div class="page-subtitle">{{ $subtitle }}</div>
</div>

<div class="audit-grid">
    @foreach ($tahunList as $th)
        @php $isActive = $th >= now()->year; @endphp
        <div class="audit-card">
            <div class="card-top">
                <div class="audit-icon">
                    <i class="{{ $icon }}"></i>
                </div>
                <div class="audit-year">AMI {{ $th }}</div>
            </div>

            <div class="audit-jurusan">{{ $homebase }}</div>

            <div class="audit-meta">
                <div class="audit-item">
                    <i class="fas fa-calendar-days"></i>
                    Tahun Audit: {{ $th }}
                </div>
            </div>

            <div class="audit-status {{ $isActive ? 'status-active' : 'status-inactive' }}">
                @if ($isActive)
                    <i class="fas fa-circle-check"></i> Audit Aktif
                @else
                    <i class="fas fa-circle-xmark"></i> Tidak Aktif
                @endif
            </div>

            <a href="{{ $routeParamName ? route($routeName, [$routeParamName => $routeParamValue, 'tahun' => $th]) : route($routeName, ['tahun' => $th]) }}" class="btn-audit">
                <i class="fas fa-arrow-right"></i> {{ $btnLabel }}
            </a>
        </div>
    @endforeach

    {{-- Add Year Card --}}
    @if (!isset($showAddYear) || $showAddYear)
    <div class="add-year-card" id="addYearCard" onclick="toggleAddYear()">
        <div class="add-year-icon"><i class="fas fa-plus"></i></div>
        <div class="add-year-label">Tambah Tahun</div>
    </div>
    <div class="add-year-form-inline" id="addYearForm" style="display:none;">
        <form action="{{ $routeParamName ? route($addYearRouteName, $addYearRouteValue) : route($addYearRouteName) }}" method="GET" id="addYearFormTag">
            <div class="add-year-input-group">
                <input type="number" name="tahun" placeholder="cth: {{ now()->year }}"
                       min="2000" max="2099" value="{{ now()->year }}" required>
                <button type="submit"><i class="fas fa-check"></i> Buka</button>
            </div>
            <button type="button" class="add-year-cancel mt-2" onclick="toggleAddYear()">Batal</button>
        </form>
    </div>
    @endif
</div>

<script>
    function toggleAddYear() {
        const card = document.getElementById('addYearCard');
        const form = document.getElementById('addYearForm');
        if (!card || !form) return;
        if (form.style.display === 'none' || !form.style.display) {
            card.style.display = 'none';
            form.style.display = 'block';
        } else {
            card.style.display = 'flex';
            form.style.display = 'none';
        }
    }
</script>
