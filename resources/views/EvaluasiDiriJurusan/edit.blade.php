@extends('layouts.app')

@section('title', 'Evaluasi Diri ' . ($userJurusan->homebase ?? ''))

@section('content')

    <style>
        .harkat_penskoran {
            white-space: pre-wrap;
            overflow-wrap: break-word;
            word-break: break-word;
            tab-size: 4;
            font-family: inherit;
        }

        .nav-item-btn.active {
            background-color: #0d6efd33;
            border-left: 4px solid #0d6efd;
            font-weight: bold;
            color: #061f47 !important;
        }

        .nav-item-btn.active.border-green {
            border-left: 4px solid #28a745;
            background-color: #28a74522;
            color: #0d3b1d !important;
        }

        .nav-item-btn.active.border-yellow {
            border-left: 4px solid #ffc107;
            background-color: #ffc10722;
            color: #5c4800 !important;
        }

        .nav-item-btn.active.border-red {
            border-left: 4px solid #dc3545;
            background-color: #dc354522;
            color: #4a0008 !important;
        }

        .nav-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 6px;
            padding: 4px;
            max-height: 50vh;
            overflow-y: auto;
        }

        .nav-grid-btn {
            aspect-ratio: 1;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            min-width: 0;
            padding: 0;
            color: #333;
        }

        .nav-grid-btn:hover {
            transform: scale(1.08);
            box-shadow: 0 3px 10px rgba(0,0,0,0.12);
            z-index: 1;
        }

        .nav-grid-btn.active {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 3px rgba(13,110,253,0.25);
        }

        .nav-grid-btn.border-green {
            border-color: #28a745 !important;
        }

        .nav-grid-btn.border-yellow {
            border-color: #ffc107 !important;
        }

        .nav-grid-btn.border-red {
            border-color: #dc3545 !important;
        }

        .nav-grid-header {
            grid-column: 1 / -1;
            padding: 4px 8px;
            background: #6c757d;
            color: white;
            font-weight: 700;
            font-size: 11px;
            border-radius: 6px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        #loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        #loading-overlay.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 6px solid #ddd;
            border-top-color: #007bff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            margin-top: 10px;
            font-size: 16px;
            color: #444;
        }

        .search-match {
            outline: 2px solid #0d6efd;
            background-color: #e7f1ff !important;
        }

        .accordion-button:not(.collapsed) {
            pointer-events: auto !important;
        }

        .container {
            max-width: 100% !important;
            padding-left: 10 !important;
            padding-right: 10 !important;
        }
    </style>

    @if (!isset($tahun))
        @include('EvaluasiLamdik._year_cards', [
            'tahunList' => $tahunList,
            'title' => 'Isi AMI — ' . ($userJurusan->homebase ?? 'Jurusan'),
            'subtitle' => 'Pilih tahun audit untuk mengisi borang AMI atas nama jurusan.',
            'homebase' => $userJurusan->homebase ?? 'Jurusan',
            'icon' => 'fas fa-calendar-alt',
            'btnLabel' => 'Isi AMI',
            'routeName' => 'evaluasi_diri_jurusan.edit.custom',
            'routeParamName' => 'evaluasi_diri_jurusan',
            'routeParamValue' => $userJurusan->id,
            'addYearRouteName' => 'evaluasi_diri_jurusan.edit.custom',
            'addYearRouteValue' => $userJurusan->id,
        ])
    @else

    @php
        $user = auth()->user();
        $isSubmitted = $auditHeader && $auditHeader->jurusan_submitted_at;
    @endphp

    @if ($user->role === 'admin_jurusan')
        @php $for = 'jurusan'; @endphp
    @elseif ($user->role === 'admin_FKIP')
        @php $for = 'fakultas'; @endphp
    @else
        @php $for = ''; @endphp
    @endif

    <div id="loading-overlay">
        <div class="spinner"></div>
        <p class="loading-text">Memuat...</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-9 d-flex flex-column">

            <div class="mb-3">
                <div class="card shadow-sm">
                    <div class="card-header py-2">
                        <h5 class="mb-0">Hasil Akreditasi {{ $userJurusan->homebase }} oleh UPM FKIP ULM</h5>
                    </div>
                    <div class="card-body py-2">
                        <div class="d-flex">
                            <p class="mb-1 me-2">Nilai Akreditasi:</p>
                            <p class="mb-1 fw-bold" id="total_nilai_semua"></p>
                        </div>
                        <div class="d-flex">
                            <p class="mb-1 me-2">Status:</p>
                            <p class="mb-1" id="status"></p>
                        </div>
                        <div class="d-flex">
                            <p class="mb-0 me-2">Masa Berlaku:</p>
                            <p class="mb-0 fw-bold" id="masa"></p>
                        </div>
                        <a class="btn btn-primary btn-sm mt-3"
                            href="{{ route('evaluasi_diri_jurusan.show', $userJurusan->id) }}">
                            Bandingkan
                        </a>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 id="content-title" class="mb-0">Pilih Navigasi di Sebelah Kanan</h4>
                    <small id="kriteria-title" class="text-muted d-block mt-1">Kriteria</small>
                </div>
                <div class="card-body">
                    <p class="fw-bold">Bobot : <span id="content-poin"></span></p>
                    <span id="content-body" class="mt-2"></span>
                    <form id="kriteriaForm" action="{{ route('evaluasi_diri_jurusan.store') }}" method="POST">
                    </form>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-2">
                <button id="btnPrev" class="btn btn-secondary btn-sm">
                    <i class="bi bi-chevron-double-left"></i>
                </button>
                <button id="btnNext" class="btn btn-secondary btn-sm">
                    <i class="bi bi-chevron-double-right"></i>
                </button>
            </div>

        </div>

        <div class="col-md-3">

                    <div class="card shadow-sm mb-3">
                        <label for="search-elemen" class="form-label fw-bold">Cari Elemen</label>
                        <input type="text" id="search-elemen" class="form-control mb-3"
                            placeholder="Ketik nama elemen...">
                        <label for="filterColor" class="form-label fw-bold">Filter Warna</label>
                        <select id="filterColor" class="form-select mb-3">
                            <option value="">Semua</option>
                            <option value="green">Hijau</option>
                            <option value="yellow">Kuning</option>
                            <option value="red">Merah</option>
                            <option value="none">Belum Terisi</option>
                        </select>

                        <p class="fw-bold mb-1">
                            Keterangan
                        </p>

                        <div class="d-flex align-items-center mb-1">
                            <div style="width: 15px; height: 15px; background:#28a745; border-radius:3px;" class="me-2">
                            </div>
                            <span>Skor <strong>4</strong> (Baik)</span>
                        </div>

                        <div class="d-flex align-items-center mb-1">
                            <div style="width: 15px; height: 15px; background:#ffc107; border-radius:3px;" class="me-2">
                            </div>
                            <span>Skor <strong>3–2</strong> (Cukup)</span>
                        </div>

                        <div class="d-flex align-items-center mb-1">
                            <div style="width: 15px; height: 15px; background:#dc3545; border-radius:3px;" class="me-2">
                            </div>
                            <span>Skor <strong>1</strong> (Kurang)</span>
                        </div>

                        <div class="d-flex align-items-center">
                            <div style="
                    width:15px;
                    height:15px;
                    background:#ffffff;
                    border:1px solid #ccc;
                    border-radius:3px;
                "
                                class="me-2"></div>

                            <span>Belum Terisi</span>
                        </div>

                        <div class="mt-3 mb-1">
                            <strong>Navigasi Elemen</strong>
                        </div>
                        <div class="nav-grid" id="nav-container">

                    @php
                        $currentKriteria = null;
                    @endphp

                    @foreach ($data as $item)
                        @if ($currentKriteria !== $item->kriteria->name)
                            @php
                                $currentKriteria = $item->kriteria->name;
                            @endphp
                            <div class="nav-grid-header">
                                {{ $currentKriteria }}
                            </div>
                        @endif

                        @php
                            $jawaban = $item->userMatrikByUser->jawaban ?? null;

                            $bgColor = match (true) {
                                $jawaban == 4 => '#d4edda',
                                $jawaban < 4 && $jawaban > 1 => '#fff3cd',
                                $jawaban == 1 => '#f8d7da',
                                default => '#f8f9fa',
                            };

                            $borderClass = match (true) {
                                $jawaban == 4 => 'border-green',
                                $jawaban < 4 && $jawaban > 1 => 'border-yellow',
                                $jawaban == 1 => 'border-red',
                                default => '',
                            };
                        @endphp

                        <button
                            class="nav-grid-btn nav-item-btn {{ $borderClass }}"
                            style="background: {{ $bgColor }};"
                            title="{{ $item->nomor }}. {{ $item->elemen }}"
                            data-id="{{ $item->id }}" data-nomor="{{ $item->nomor }}"
                            data-title="{{ $item->nomor }}. {{ $item->elemen }}"
                            data-content="{{ $item->indikator }}" data-kriteria="{{ $item->kriteria->name }}"
                            data-pilihan='@json($item->option_pilihan_ganda)'
                            data-poin="{{ $item->poin }}" data-harkat_penskoran="{{ $item->harkat_penskoran }}"
                            data-jenis="{{ $item->jenis }}"
                            data-link_bukti="{{ $item->userMatrikByUser->link_bukti ?? '' }}"
                            data-temuan="{{ $item->userMatrikByUser->temuan ?? '' }}"
                            data-saran="{{ $item->userMatrikByUser->saran ?? '' }}"
                            data-jawaban="{{ $item->userMatrikByUser->jawaban ?? 0 }}"
                            data-skor_a="{{ $item->userMatrikByUser->skor_a ?? '' }}"
                            data-skor_b="{{ $item->userMatrikByUser->skor_b ?? '' }}"
                            data-color="{{ $jawaban == 4 ? 'green' : ($jawaban < 4 && $jawaban > 1 ? 'yellow' : ($jawaban == 1 ? 'red' : 'none')) }}"
                            data-nilai_total="{{ $item->userMatrikByUser->nilai_total ?? 0 }}"
                            data-subitem='@json($item->subItemElemen)'
                            data-usersubitems='@json($item->userSubItemElements)'>
                            {{ $item->nomor }}
                        </button>
                    @endforeach

                </div>
                    </div>

            {{-- Submit / status penilaian AMI --}}
            <div class="mt-3">
                @if ($isSubmitted)
                    <div class="alert alert-info d-flex align-items-center justify-content-between mb-0 py-2">
                        <div>
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Sudah Disubmit</strong>
                            <br><small class="text-muted">{{ optional($auditHeader->jurusan_submitted_at)->format('d M Y, H:i') ?? '' }}</small>
                        </div>
                    </div>
                @else
                    <button type="button" id="btn-submit-ami" class="btn btn-danger btn-sm w-100 d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-send-fill"></i>
                        Submit Penilaian AMI
                    </button>
                    <small class="text-muted d-block mt-1 text-center">Data tidak dapat diubah setelah disubmit.</small>
                @endif
            </div>

            <script>
                window.isAMISubmitted = {{ $isSubmitted ? 'true' : 'false' }};
                const btnSubmitAMI = document.getElementById('btn-submit-ami');
                if (btnSubmitAMI) {
                    btnSubmitAMI.addEventListener('click', function () {
                        Swal.fire({
                            title: 'Submit Penilaian AMI?',
                            text: 'Setelah disubmit, seluruh data penilaian tidak dapat diubah lagi.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Submit',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#dc3545',
                            reverseButtons: true
                        }).then((result) => {
                            if (!result.isConfirmed) return;
                            fetch('{{ route('audit.submit') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    program_studi: '{{ $userJurusan->id ?? '' }}',
                                    role: '{{ auth()->user()->role }}',
                                    tahun: '{{ $tahun }}'
                                })
                            }).then(r => r.json()).then(data => {
                                if (data.success) {
                                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message });
                                    setTimeout(() => location.reload(), 1500);
                                } else {
                                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message || 'Terjadi kesalahan.' });
                                }
                            }).catch(() => {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan jaringan.' });
                            });
                        });
                    });
                }
            </script>

        </div>
    </div>

    {{-- Hitung Akreditasi --}}
    <script>
        function hitungAkreditasi(NA, syarat3, syarat5) {
            let status = "";
            let masa = "";

            if (NA >= 361) {
                if (syarat5) {
                    status = "Terakreditasi Unggul";
                    masa = "5 Tahun";
                } else if (syarat3) {
                    status = "Terakreditasi Unggul";
                    masa = "3 Tahun";
                } else {
                    status = "Terakreditasi";
                    masa = "5 Tahun";
                }
            } else if (NA >= 321) {
                if (syarat5) {
                    status = "Terakreditasi Unggul";
                    masa = "5 Tahun";
                } else if (syarat3) {
                    status = "Terakreditasi Unggul";
                    masa = "3 Tahun";
                } else {
                    status = "Terakreditasi";
                    masa = "5 Tahun";
                }
            } else if (NA >= 200) {
                status = "Terakreditasi";
                masa = "5 Tahun";
            } else {
                status = "Tidak Terakreditasi";
                masa = "-";
            }

            return { status, masa };
        }

        let syarat3 = {{ isset($syarat3) && $syarat3 ? 'true' : 'false' }};
        let syarat5 = {{ isset($syarat5) && $syarat5 ? 'true' : 'false' }};
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let total = 0;

            document.querySelectorAll(".nav-item-btn").forEach(btn => {
                let nilai_total_users_matriks = parseFloat(btn.dataset.nilai_total);
                total += nilai_total_users_matriks;
            });

            document.getElementById("total_nilai_semua").innerText = total;

            let hasil = hitungAkreditasi(total, syarat3, syarat5);

            document.getElementById("status").innerText = hasil.status;
            document.getElementById("masa").innerText = hasil.masa;
        });
    </script>

    {{-- Click Handler Utama --}}
    <script>
        // Auto-save current form before navigating
        function saveCurrentForm() {
            if (window.isAMISubmitted) return Promise.resolve();
            const form = document.getElementById('kriteriaForm');
            if (!form || !form.action) return Promise.resolve();
            const formData = new FormData(form);
            // Skip if no jawaban/nilai_total input (form not initialized)
            if (!formData.has('nilai_total')) return Promise.resolve();
            // Add CSRF from the form
            const csrf = form.querySelector('input[name="_token"]');
            if (!csrf) return Promise.resolve();
            return fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            }).then(r => {
                if (!r.ok) { console.error('Auto-save HTTP', r.status, r.statusText); return r; }
                // Sync active nav-item dataset so navigating back shows saved data
                const activeBtn = document.querySelector('.nav-item-btn.active');
                if (activeBtn) {
                    ['jawaban','nilai_total','link_bukti','temuan','saran'].forEach(k => {
                        const v = formData.get(k);
                        if (v !== null) activeBtn.dataset[k] = v;
                    });
                }
                return r;
            }).catch(e => console.error('Auto-save gagal:', e));
        }

        document.querySelectorAll(".nav-item-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                // Auto-save current form before switching question
                saveCurrentForm();

                localStorage.setItem('lastElement', btn.dataset.id);
                // console.log('ID tersimpan:', btn.dataset.id);
                console.log('Isi btn:', btn.dataset);

                // --- Isi konten utama ---
                var poin = parseFloat(btn.dataset.poin);
                const nomor = parseInt(btn.dataset.nomor);
                const isElemen7 = nomor === 7;
                const isElemen11 = nomor === 11;
                const isElemen14 = nomor === 14;
                const isElemen15 = nomor === 15;
                const isElemen16 = nomor === 16;
                const isElemen19 = nomor === 19;
                const isElemen20 = nomor === 20;
                const isElemen21 = nomor === 21;
                const isElemen22 = nomor === 22;
                const isElemen23 = nomor === 23;
                const isElemen33 = nomor === 33;
                const isElemen40 = nomor === 40;
                const isElemen41 = nomor === 41;
                const isElemen42 = nomor === 42;
                const isElemen43 = nomor === 43;
                const isElemen45 = nomor === 45;
                const isElemen46 = nomor === 46;
                const isElemen47 = nomor === 47;
                const isElemen48 = nomor === 48;
                const isElemen53 = nomor === 53;
                const isElemen54 = nomor === 54;
                const isElemen55 = nomor === 55;
                const isElemen56 = nomor === 56;
                const isElemen57 = nomor === 57;
                const isElemen59 = nomor === 59;
                const isElemen60 = nomor === 60;
                // var kepemilikan_kriteria = document.getElementById('kepemilikan_kriteria').value;
                document.getElementById("content-title").innerText = btn.dataset.title;
                document.getElementById("kriteria-title").innerText = btn.dataset.kriteria;
                document.getElementById("content-body").innerText = (isElemen7 || isElemen11 || isElemen14 || isElemen15 || isElemen16 || isElemen19 || isElemen20 || isElemen21 || isElemen22 || isElemen23 || isElemen33 || isElemen40 || isElemen41 || isElemen42 || isElemen43 || isElemen45 || isElemen46 || isElemen47 || isElemen48 || isElemen53 || isElemen54 || isElemen55 || isElemen56 || isElemen57 || isElemen59 || isElemen60) ? '' : btn.dataset.content;
                document.getElementById("content-poin").innerText = poin;

                var jenis = btn.dataset.jenis
                var id_matriks_led = btn.dataset.id

                // Ini yang dari userMatrik
                var link_bukti = btn.dataset.link_bukti;
                var saran = btn.dataset.saran;
                var temuan = btn.dataset.temuan;
                var jawaban = btn.dataset.jawaban;
                var nilai_total = btn.dataset.nilai_total;
                // console.log("jawaban:", nilai_total);
                // console.log(typeof nilai_total); // number

                // console.log("jawaban:", jawaban);

                const jsonString = btn.dataset.pilihan;
                let pilihan = JSON.parse(JSON.parse(jsonString));
                let harkat_penskoran = btn.dataset.harkat_penskoran;

                // Sub Item Elemen
                const subItems = JSON.parse(btn.dataset.subitem || '[]');
                console.log(subItems);

                // Ini jawaban dari sub item elemen
                const userSubItems = JSON.parse(btn.dataset.usersubitems || '[]');
                // console.log(userSubItems);

                // Gabung dengan mapping
                const userSubItemMap = {};
                userSubItems.forEach(item => {
                    userSubItemMap[item.id_sub_item_elemen] = item;
                });


                let container = document.getElementById('kriteriaForm');

                console.log("pilihan == null", pilihan == null)
                console.log("typeof(harkat_penskoran)", typeof(harkat_penskoran))
                console.log("harkat_penskoran == ", harkat_penskoran == "")

                // RESET FORM
                container.innerHTML = `@csrf`;

                const isDualRadio = Array.isArray(pilihan) && pilihan.length === 2;
                const isFakultas = {{ $for === 'fakultas' ? 'true' : 'false' }};

                // CEK HARKAT
                if (harkat_penskoran && harkat_penskoran.trim() !== '') {

                    if (isElemen7) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start" rowspan="3">
                            <strong>(a)</strong> PT/UPPS menjalin kerjasama dalam bidang pendidikan, penelitian, dan PkM dengan pihak lain di tingkat wilayah/lokal, nasional dan internasional dalam 3 tahun terakhir.<br><br>
                            <strong>Skor(a) = ((2 × A) + B) / 3</strong>
                        </td>
                        <td class="bg-success text-white">Jika R<sub>K</sub> ≥ 4,<br>A = 4</td>
                        <td colspan="3">Jika R<sub>K</sub> &lt; 4, A = R<sub>K</sub></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-start">
                            <strong>Rumus R<sub>K</sub>:</strong>
                            R<sub>K</sub> = ((3 × N<sub>1</sub>) + (2 × N<sub>2</sub>) + (1 × N<sub>3</sub>)) / N<sub>DTPS</sub><br>
                            <small>N<sub>1</sub>=Pendidikan | N<sub>2</sub>=Penelitian | N<sub>3</sub>=PkM | N<sub>DTPS</sub>=Dosen tetap</small>
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-success text-white">N<sub>I</sub> ≥ 2 → B = 4</td>
                        <td colspan="2">
                            N<sub>I</sub> &lt; 2 &amp;&amp; N<sub>N</sub> ≥ 6 → B = 3 + (N<sub>I</sub>/2)<br>
                            <hr class="my-1">
                            0 &lt; N<sub>I</sub> &lt; 2 &amp;&amp; 0 &lt; N<sub>N</sub> &lt; 6 →<br>
                            B = 2 + (2×N<sub>I</sub>/2) + (N<sub>N</sub>/6) − (N<sub>I</sub>×N<sub>N</sub>)/(2×6)
                        </td>
                        <td>
                            N<sub>I</sub>=0, N<sub>N</sub>=0, N<sub>W</sub> ≥ 9 → B=2<br>
                            <hr class="my-1">
                            N<sub>I</sub>=0, N<sub>N</sub>=0, N<sub>W</sub> &lt; 9 → B=1
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-start small">
                            N<sub>I</sub>=Internasional | N<sub>N</sub>=Nasional | N<sub>W</sub>=Wilayah/Lokal &nbsp;|&nbsp; Faktor: a=2, b=6, c=9
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> Analisis keefektifan kerja sama yang dijalin PS dalam memberikan kontribusi nyata, berkelanjutan, dan terukur bagi peningkatan mutu tridharma serta peningkatan reputasi PS di tingkat lokal, nasional, maupun internasional.
                        </td>
                        <td class="bg-success text-white">Kontribusi nyata, berkelanjutan, terukur <strong>serta</strong> peningkatan reputasi PS lokal, nasional, internasional</td>
                        <td>Kontribusi nyata, berkelanjutan, terukur bagi peningkatan mutu tridharma</td>
                        <td>Kontribusi nyata bagi peningkatan mutu tridharma</td>
                        <td class="bg-danger text-white">PS tidak menganalisis keefektifan kerja sama</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen11) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start" rowspan="3">
                            <strong>(a)</strong> Rasio jumlah DTPS terhadap jumlah mahasiswa memungkinkan mahasiswa berinteraksi dan memperoleh bimbingan dosen dengan baik.<br><br>
                            RMD = N<sub>M</sub> / N<sub>DTPS</sub>
                        </td>
                        <td colspan="4" class="text-start">
                            <strong>Kelompok Sains Teknologi</strong><br>
                            15 ≤ RMD ≤ 25 → Skor = 4 &nbsp;|&nbsp;
                            RMD &lt; 15 → Skor = (4 × RMD) / 15 &nbsp;|&nbsp;
                            25 &lt; RMD ≤ 35 → Skor = (70 − 2×RMD) / 5 &nbsp;|&nbsp;
                            RMD &gt; 35 → Skor = 1
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-start">
                            <strong>Kelompok Sosial Humaniora</strong><br>
                            25 ≤ RMD ≤ 35 → Skor = 4 &nbsp;|&nbsp;
                            RMD &lt; 25 → Skor = (4 × RMD) / 25 &nbsp;|&nbsp;
                            35 &lt; RMD ≤ 50 → Skor = (200 − 4×RMD) / 15 &nbsp;|&nbsp;
                            RMD &gt; 50 → Skor = 1
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">N<sub>M</sub> = Jumlah mahasiswa pada saat TS &nbsp;|&nbsp; N<sub>DTPS</sub> = Jumlah dosen tetap pengampu MK sesuai kompetensi inti PS</td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> PS melakukan analisis ketercapaian rasio dosen terhadap mahasiswa meliputi: (1) mutu pembelajaran, (2) efektivitas penelitian mahasiswa, (3) pencapaian profil lulusan.
                        </td>
                        <td class="bg-success text-white">Analisis 3 aspek</td>
                        <td>Analisis 2 aspek</td>
                        <td>Analisis 1 aspek</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen14) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start" rowspan="2">
                            <strong>(a)</strong> Mahasiswa memiliki prestasi akademik dan non-akademik dalam 3 tahun terakhir.<br><br>
                            RI = N<sub>I</sub> / N<sub>M</sub> &nbsp;|&nbsp;
                            RN = N<sub>N</sub> / N<sub>M</sub> &nbsp;|&nbsp;
                            RW = N<sub>W</sub> / N<sub>M</sub>
                        </td>
                        <td class="bg-success text-white">RI ≥ 0.5%</td>
                        <td>
                            RI &lt; 0.5% dan RN ≥ 5% → 3 + (RI / 0.5%)<br><br>
                            0 &lt; RI &lt; 0.5% dan 0 &lt; RN &lt; 5% → 2 + (RI/0.5%) + (RN/5%) − (RI×RN)/(0.5%×5%)
                        </td>
                        <td>RI=0, RN=0, RW ≥ 10%</td>
                        <td class="bg-danger text-white">RI=0, RN=0, RW &lt; 10%</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-start">
                            N<sub>I</sub> = Prestasi tk. internasional &nbsp;|&nbsp;
                            N<sub>N</sub> = Prestasi tk. nasional &nbsp;|&nbsp;
                            N<sub>W</sub> = Prestasi tk. wilayah/lokal &nbsp;|&nbsp;
                            N<sub>M</sub> = Jumlah mahasiswa saat TS<br>
                            Faktor: a = 0.5% &nbsp;|&nbsp; b = 5% &nbsp;|&nbsp; c = 10%
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> PS melakukan analisis kontribusi prestasi mahasiswa terhadap: (1) peningkatan reputasi akademik PS, (2) penguatan jejaring eksternal, (3) pembentukan profil lulusan unggul dan berdaya saing global.
                        </td>
                        <td class="bg-success text-white">Analisis 3 aspek</td>
                        <td>Analisis 2 aspek</td>
                        <td>Analisis 1 aspek</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen16) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> UPPS/PS melakukan pengukuran kepuasan mahasiswa terhadap performa mengajar dosen, layanan administrasi akademik, dan fasilitas pendidikan, memenuhi 6 aspek: (1) instrumen valid, (2) dilaksanakan tiap akhir semester, (3) dianalisis tepat, (4) ada review hasil, (5) ditindaklanjuti, (6) hasilnya dipublikasikan.
                        </td>
                        <td class="bg-success text-white">6 aspek</td>
                        <td>5 aspek</td>
                        <td>4 aspek</td>
                        <td class="bg-danger text-white">&lt; 4 aspek</td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> Tingkat kepuasan mahasiswa hasil pengukuran.<br><br>
                            TKM = Σ TKM<sub>i</sub> / 5
                        </td>
                        <td class="bg-success text-white">TKM ≥ 75%</td>
                        <td>50% ≤ TKM &lt; 75%</td>
                        <td>25% ≤ TKM &lt; 50%</td>
                        <td class="bg-danger text-white">TKM &lt; 25%</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (Skor(a) + 3 × Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen19) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Kualifikasi akademik DTPS.<br><br>
                            PDS3 = (NDS3 / N<sub>DTPS</sub>) × 100%
                        </td>
                        <td colspan="4" class="text-start">
                            PDS3 ≥ 40% → Skor(a) = 4 &nbsp;|&nbsp;
                            PDS3 &lt; 40% → Skor(a) = 2 + (5 × PDS3) &nbsp;|&nbsp;
                            <em>Tidak ada skor 1</em>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> Jabatan akademik DTPS.<br><br>
                            PGBLKL = ((NDGB + NDLK + NDL) / N<sub>DTPS</sub>) × 100%
                        </td>
                        <td colspan="4" class="text-start">
                            PGBLKL ≥ 70% → Skor(b) = 4 &nbsp;|&nbsp;
                            PGBLKL &lt; 70% → Skor(b) = 2 + (20 × PGBLKL / 7) &nbsp;|&nbsp;
                            <em>Tidak ada skor 1</em>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(c)</strong> PS melakukan analisis terhadap keterpenuhan kualifikasi akademik, ketercapaian jabatan akademik, dan dampaknya.
                        </td>
                        <td class="bg-success text-white">Kualifikasi + jabatan + dampak</td>
                        <td>Kualifikasi + jabatan</td>
                        <td>Salah satu</td>
                        <td class="bg-danger text-white">Tidak ada</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × (Skor(a) + Skor(b)) + Skor(c)) / 7</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen21) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> DTPS memiliki prestasi/pengakuan kepakaran.<br><br>
                            RRD = NRD / N<sub>DTPS</sub>
                        </td>
                        <td colspan="4" class="text-start">
                            RRD ≥ 1 → Skor(a) = 4 &nbsp;|&nbsp;
                            RRD &lt; 1 → Skor(a) = 2 + (2 × RRD) &nbsp;|&nbsp;
                            <em>Tidak ada skor 1</em>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> PS melakukan analisis: (1) pengakuan reputasi kepakaran, (2) penyebab, (3) dampaknya.
                        </td>
                        <td class="bg-success text-white">3 aspek</td>
                        <td>2 aspek</td>
                        <td>1 aspek</td>
                        <td class="bg-danger text-white">Tidak ada</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen20) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Beban kerja DTPS.<br><br>
                            BKD = rata-rata beban kerja dosen (SKS)
                        </td>
                        <td colspan="4" class="text-start">
                            12 ≤ BKD ≤ 16 → Skor = 4 &nbsp;|&nbsp;
                            6 ≤ BKD &lt; 12 → Skor = (2×BKD − 12) / 3 &nbsp;|&nbsp;
                            16 &lt; BKD ≤ 18 → Skor = 36 − (2×BKD) &nbsp;|&nbsp;
                            BKD &lt; 6 atau BKD &gt; 18 → Skor = 1
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> PS melakukan analisis distribusi BKD: (1) kualitas tridarma seimbang, (2) kesejahteraan dosen, (3) keberlanjutan mutu PS.
                        </td>
                        <td class="bg-success text-white">3 aspek</td>
                        <td>2 aspek</td>
                        <td>1 aspek</td>
                        <td class="bg-danger text-white">Tidak ada</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen22) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> DTPS mengikuti kegiatan pengembangan kompetensi.<br><br>
                            NDTPSPK = % DTPS pengembangan kompetensi relevan
                        </td>
                        <td>NDTPSPK ≥ 80%</td>
                        <td>70% ≤ NDTPSPK &lt; 80%</td>
                        <td>60% ≤ NDTPSPK &lt; 70%</td>
                        <td>NDTPSPK &lt; 60%</td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> PS analisis kontribusi: (1) kualitas tridarma, (2) jejaring akademik, (3) visi keilmuan PS.
                        </td>
                        <td class="bg-success text-white">3 aspek</td>
                        <td>2 aspek</td>
                        <td>1 aspek</td>
                        <td class="bg-danger text-white">Tidak ada</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen23) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Tenaga kependidikan ikut pengembangan kompetensi.<br><br>
                            NTENDIKPK = % tenaga kependidikan
                        </td>
                        <td>NTENDIKPK ≥ 40%</td>
                        <td>25% ≤ NTENDIKPK &lt; 40%</td>
                        <td>10% ≤ NTENDIKPK &lt; 25%</td>
                        <td>NTENDIKPK &lt; 10%</td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> PS analisis kontribusi: (1) layanan administrasi, (2) tata kelola, (3) mutu akademik & non-akademik.
                        </td>
                        <td class="bg-success text-white">3 aspek</td>
                        <td>2 aspek</td>
                        <td>1 aspek</td>
                        <td class="bg-danger text-white">Tidak ada</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen33) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start"><strong>(a)</strong> Integrasi penelitian/PkM dalam pembelajaran: (1) relevan, (2) hasil jadi materi, (3) bukti.</td>
                        <td>3 aspek</td>
                        <td>2 aspek</td>
                        <td>1 aspek</td>
                        <td class="bg-danger text-white">Tidak ada</td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> DTPS integrasikan penelitian/PkM.<br>
                            PDIPPKM = (NDIPPKM / N<sub>DTPS</sub>) × 100%
                        </td>
                        <td>PDIPPKM ≥ 50%</td>
                        <td>30% ≤ PDIPPKM &lt; 50%</td>
                        <td>10% ≤ PDIPPKM &lt; 30%</td>
                        <td>PDIPPKM &lt; 10%</td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(c)</strong> MK inti dari integrasi.<br>
                            PMKI = (NMKI / NMK) × 100%
                        </td>
                        <td colspan="4" class="text-start">
                            PMKI ≥ 25% → Skor = 4 &nbsp;|&nbsp;
                            15% ≤ PMKI &lt; 25% → Skor = 3 + (PMKI−0.25)/0.10 &nbsp;|&nbsp;
                            PMKI &lt; 15% → Skor = 2 &nbsp;|&nbsp;
                            <em>Tidak ada skor 1</em>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(d)</strong> Analisis kontribusi: (1) mutu belajar, (2) relevansi kurikulum, (3) kompetensi lulusan.</td>
                        <td class="bg-success text-white">3 aspek</td>
                        <td>2 aspek</td>
                        <td>1 aspek</td>
                        <td class="bg-danger text-white">Tidak ada</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = Skor(a) + (3 × (Skor(b) + Skor(c)) + Skor(d)) / 8</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen40) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Rata-rata IPK lulusan 3 tahun.<br><br>
                            RIPK = Rata-rata IPK lulusan
                        </td>
                        <td colspan="4" class="text-start">
                            RIPK ≥ 3,25 → Skor = 4 &nbsp;|&nbsp;
                            2,00 ≤ RIPK &lt; 3,25 → Skor = ((8 × RIPK) − 6) / 5 &nbsp;|&nbsp;
                            <em>Tidak ada skor 1</em>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> Analisis tren IPK dan faktor penyebab: (1) aspek layanan akademik, (2) aspek mahasiswa.</td>
                        <td>Tren + faktor (akademik & mahasiswa)</td>
                        <td>Tren + faktor (akademik)</td>
                        <td>Tren + faktor (mahasiswa)</td>
                        <td class="bg-danger text-white">Tidak ada</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen41) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Rata-rata masa studi lulusan 3 tahun.<br><br>
                            RMS = rata-rata masa studi (tahun)
                        </td>
                        <td colspan="4" class="text-start">
                            3,5 &lt; RMS ≤ 4,0 → Skor = 4 &nbsp;|&nbsp;
                            4 &lt; RMS ≤ 5 → Skor = 4 − ((RMS−4)/0,5) × 1,5 &nbsp;|&nbsp;
                            RMS &gt; 5 → Skor = 1
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> Analisis tren masa studi, faktor penyebab, dan dampak.</td>
                        <td>Tren + faktor + dampak</td>
                        <td>Tren + faktor</td>
                        <td>Tren saja</td>
                        <td class="bg-danger text-white">Tidak ada</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen42) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Mahasiswa dapat menyelesaikan studinya sesuai masa tempuh kurikulum (MTK).<br><br>
                            PMTK = Persentase mahasiswa menyelesaikan studi sesuai MTK
                        </td>
                        <td colspan="4" class="text-start">
                            PMTK ≥ 50% → Skor = 4 &nbsp;|&nbsp;
                            PMTK &lt; 50% → Skor = 1 + (6 × PMTK)
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> PS melakukan analisis terhadap tren kelulusan tepat waktu, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis tren + faktor penyebab + dampak</td>
                        <td>Analisis tren + faktor penyebab</td>
                        <td>Analisis tren saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen43) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Mahasiswa berhasil menyelesaikan studinya.<br><br>
                            PKMS = Persentase keberhasilan studi mahasiswa
                        </td>
                        <td colspan="4" class="text-start">
                            PKMS ≥ 85% → Skor = 4 &nbsp;|&nbsp;
                            45% ≤ PKMS &lt; 85% → Skor = ((80 × PKMS) − 24) / 11 &nbsp;|&nbsp;
                            PKMS &lt; 45% → Skor = 1
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> PS melakukan analisis keberhasilan studi mahasiswa, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis keberhasilan + faktor penyebab + dampak</td>
                        <td>Analisis keberhasilan + faktor penyebab</td>
                        <td>Analisis keberhasilan saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen45) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Lulusan PS bekerja di lembaga pendidikan/bidang relevan, usaha mandiri, studi lanjut S2, atau mengikuti PPG.<br><br>
                            PLB = persentase lulusan yang bekerja + usaha mandiri + studi lanjut + PPG
                        </td>
                        <td>PLB ≥ 80%</td>
                        <td>60% ≤ PLB &lt; 80%</td>
                        <td>40% ≤ PLB &lt; 60%</td>
                        <td>PLB &lt; 40%</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-start small">
                            <strong>Ketentuan Responden (berlaku untuk elemen 45, 46, 47, 48):</strong><br>
                            NL = Jumlah lulusan dalam 3 tahun (TS-4 s.d. TS-2)<br>
                            NJ = Jumlah lulusan yang terlacak<br>
                            PJ = (NJ / NL) × 100%<br>
                            NL ≥ 150 → Pr<sub>min</sub> = 30% &nbsp;|&nbsp; NL &lt; 150 → Pr<sub>min</sub> = 50% − ((NL/150) × 20%)<br>
                            Jika PJ ≥ Pr<sub>min</sub> → faktor = 1 &nbsp;|&nbsp; Jika PJ &lt; Pr<sub>min</sub> → faktor = PJ / Pr<sub>min</sub><br>
                            Skor(a) akhir = Skor(a) × faktor
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> PS melakukan analisis terhadap kesiapkerjaan, kewirausahaan, studi lanjut, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis + faktor penyebab + dampak</td>
                        <td>Analisis + faktor penyebab</td>
                        <td>Analisis saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen46) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Mahasiswa PS mendapatkan pekerjaan pertama setelah lulus.<br><br>
                            WTMP = waktu tunggu lulusan mendapatkan pekerjaan pertama (bulan), dalam 3 tahun TS-4 s.d. TS-2
                        </td>
                        <td colspan="4" class="text-start">
                            WTMP &lt; 6 → Skor = 4 &nbsp;|&nbsp;
                            6 ≤ WTMP ≤ 12 → Skor = (18 − WTMP) / 3 &nbsp;|&nbsp;
                            WTMP &gt; 12 → Skor = 1
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-start small">
                            <strong>Penyesuaian responden:</strong> berlaku ketentuan yang sama seperti elemen 45 (NL/NJ/PJ/Prmin).
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> PS melakukan analisis terhadap tren waktu tunggu mendapatkan pekerjaan pertama, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis tren + faktor penyebab + dampak</td>
                        <td>Analisis tren + faktor penyebab</td>
                        <td>Analisis tren saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen47) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Lulusan PS memperoleh pekerjaan pertama yang sesuai dengan bidang keilmuan PS (TS-4 s.d. TS-2).<br><br>
                            PBS = persentase kesesuaian bidang kerja lulusan
                        </td>
                        <td colspan="4" class="text-start">
                            PBS ≥ 60% → Skor = 4 &nbsp;|&nbsp;
                            15% &lt; PBS &lt; 60% → Skor = (20 × PBS) / 3 &nbsp;|&nbsp;
                            PBS ≤ 15% → Skor = 1
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-start small">
                            <strong>Penyesuaian responden:</strong> berlaku ketentuan yang sama seperti elemen 45 (NL/NJ/PJ/Prmin).
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> PS melakukan analisis terhadap kesesuaian bidang kerja lulusan, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis kesesuaian + faktor penyebab + dampak</td>
                        <td>Analisis kesesuaian + faktor penyebab</td>
                        <td>Analisis kesesuaian saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen48) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Evaluasi tingkat kepuasan pengguna lulusan terhadap kompetensi lulusan, 9 aspek: (1) etika, (2) keahlian bidang ilmu, (3) bahasa asing, (4) TI, (5) komunikasi, (6) kerjasama, (7) pengembangan diri, (8) berpikir kritis, (9) kreativitas.<br><br>
                            Masukkan TKi (1–4) untuk setiap aspek. TKi = (4 × a<sub>i</sub>) + (3 × b<sub>i</sub>) + (2 × c<sub>i</sub>) + d<sub>i</sub>
                        </td>
                        <td colspan="4" class="text-start small">
                            a<sub>i</sub> = % "Sangat Baik" &nbsp;|&nbsp; b<sub>i</sub> = % "Baik" &nbsp;|&nbsp; c<sub>i</sub> = % "Cukup" &nbsp;|&nbsp; d<sub>i</sub> = % "Kurang"<br>
                            Skor(a) = Σ TKi / 9
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-start small">
                            <strong>Penyesuaian responden:</strong> berlaku ketentuan yang sama seperti elemen 45 (NL/NJ/PJ/Prmin).
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> PS melakukan analisis terhadap tingkat kepuasan pengguna lulusan, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis kepuasan + faktor penyebab + dampak</td>
                        <td>Analisis kepuasan + faktor penyebab</td>
                        <td>Analisis kepuasan saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen53) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> DTPS melakukan penelitian dengan dana mandiri/PT, dalam negeri, dan luar negeri dalam 3 tahun terakhir.<br><br>
                            RI = NI/3/N<sub>DTPS</sub> &nbsp;|&nbsp; RN = NN/3/N<sub>DTPS</sub> &nbsp;|&nbsp; RL = NL/3/N<sub>DTPS</sub>
                        </td>
                        <td colspan="4" class="text-start small">
                            a = 0,05 &nbsp;|&nbsp; b = 0,3 &nbsp;|&nbsp; c = 1<br><br>
                            RI ≥ a → Skor = 4<br>
                            RI &lt; a dan RN ≥ b → Skor = 3 + (RI/a)<br>
                            0 &lt; RI &lt; a dan 0 &lt; RN &lt; b → Skor = 2 + (RI/a) + (RN/b) − (RI×RN)/(a×b)<br>
                            RI = 0, RN = 0, RL ≥ c → Skor = 2<br>
                            RI = 0, RN = 0, RL &lt; c → Skor = 1
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> PS melakukan analisis terhadap produktivitas penelitian DTPS, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis + faktor penyebab + dampak</td>
                        <td>Analisis + faktor penyebab</td>
                        <td>Analisis saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen54) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> DTPS melibatkan mahasiswa dalam kegiatan penelitiannya.<br><br>
                            PPDM = (NPM / NPD) × 100%
                        </td>
                        <td colspan="4" class="text-start">
                            PPDM ≥ 75% → Skor = 4 &nbsp;|&nbsp;
                            PPDM &lt; 75% → Skor = 2 + (8 × PPDM) &nbsp;|&nbsp;
                            <em>Tidak ada skor 1</em>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> PS melakukan analisis terhadap keterlibatan mahasiswa dalam penelitian DTPS, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis + faktor penyebab + dampak</td>
                        <td>Analisis + faktor penyebab</td>
                        <td>Analisis saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen55) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Dalam 3 tahun terakhir, ≥ 20% DTPS memiliki publikasi ilmiah.<br><br>
                            RW = (NA1+NB1+NC1)/N<sub>DTPS</sub><br>
                            RN = (NA2+NA3+NB2+NC2)/N<sub>DTPS</sub><br>
                            RI = (NA4+NB3+NC3)/N<sub>DTPS</sub>
                        </td>
                        <td colspan="4" class="text-start small">
                            a = 0,1 &nbsp;|&nbsp; b = 1 &nbsp;|&nbsp; c = 2<br><br>
                            RI ≥ a → Skor = 4<br>
                            RI &lt; a dan RN ≥ b → Skor = 3 + (RI/a)<br>
                            0 &lt; RI &lt; a dan 0 &lt; RN &lt; b → Skor = 2 + (RI/a) + (RN/b) − (RI×RN)/(a×b)<br>
                            RI = 0, RN = 0, RW ≥ c → Skor = 2<br>
                            RI = 0, RN = 0, RW &lt; c → Skor = 1
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> PS melakukan analisis terhadap tren produktivitas dan relevansi publikasi ilmiah DTPS, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis tren + relevansi + faktor penyebab + dampak</td>
                        <td>Analisis tren + relevansi + faktor penyebab</td>
                        <td>Analisis tren produktivitas saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen56) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="2">
                            <strong>(a)</strong> Dalam 3 tahun terakhir, DTPS memiliki publikasi di jurnal nasional dan/atau internasional sebagai penulis pertama atau <em>corresponding author</em>.<br><br>
                            PPDTPS = (N<sub>DTPS_PUB</sub> / N<sub>DTPS</sub>) × 100%
                        </td>
                        <td colspan="4" class="formula-row">
                            N<sub>DTPS_PUB</sub> = S4_DTPS + S3_DTPS + S2_DTPS + S1_DTPS + INT_DTPS &nbsp;|&nbsp; N<sub>DTPS</sub> = Jumlah Dosen Tetap Program Studi
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-success text-white">PPDTPS ≥ 20%</td>
                        <td>15% ≤ PPDTPS &lt; 20%</td>
                        <td>10% ≤ PPDTPS &lt; 15%</td>
                        <td class="bg-danger text-white">PPDTPS &lt; 10%</td>
                    </tr>
                    <tr>
                        <td><strong>(b)</strong> PS melakukan analisis terhadap tren jumlah DTPS yang melakukan publikasi ilmiah, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis tren + faktor penyebab + dampak</td>
                        <td>Analisis tren + faktor penyebab</td>
                        <td>Analisis tren saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen57) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="2">
                            <strong>(a)</strong> Jumlah artikel ilmiah DTPS yang disitasi dalam 3 tahun terakhir.<br><br>
                            RSA = NAS / N<sub>DTPS</sub>
                        </td>
                        <td colspan="4" class="formula-row">
                            NAS = Jumlah artikel DTPS yang disitasi &nbsp;|&nbsp; N<sub>DTPS</sub> = Jumlah dosen tetap pengampu MK sesuai kompetensi inti PS
                        </td>
                    </tr>
                    <tr>
                        <td class="bg-success text-white">RSA ≥ 9</td>
                        <td>6 ≤ RSA &lt; 9</td>
                        <td>3 ≤ RSA &lt; 6</td>
                        <td class="bg-danger text-white">RSA &lt; 3</td>
                    </tr>
                    <tr>
                        <td><strong>(b)</strong> PS melakukan analisis terhadap jumlah artikel ilmiah DTPS yang disitasi, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis + faktor penyebab + dampak</td>
                        <td>Analisis + faktor penyebab</td>
                        <td>Analisis saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen59) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start" rowspan="2">
                            <strong>(a)</strong> DTPS memiliki produktivitas PkM dengan dana mandiri/PT, dalam negeri, dan luar negeri dalam 3 tahun terakhir.<br><br>
                            RI = NI/3/N<sub>DTPS</sub> &nbsp;|&nbsp; RN = NN/3/N<sub>DTPS</sub> &nbsp;|&nbsp; RL = NL/3/N<sub>DTPS</sub>
                        </td>
                        <td class="bg-success text-white">Jika RI ≥ a → Skor = 4</td>
                        <td>
                            Jika RI &lt; a dan RN ≥ b → Skor = 3 + (RI/a)<br>
                            <hr class="my-1">
                            Jika 0 &lt; RI &lt; a dan 0 &lt; RN &lt; b →<br>
                            Skor = 2 + (RI/a) + (RN/b) − (RI×RN)/(a×b)
                        </td>
                        <td>Jika RI=0, RN=0, RL ≥ c → Skor = 2</td>
                        <td class="bg-danger text-white">Jika RI=0, RN=0, RL &lt; c → Skor = 1</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-start small">
                            NI = PkM luar negeri | NN = PkM dalam negeri | NL = PkM PT/mandiri<br>
                            Faktor: a = 0,05 &nbsp;|&nbsp; b = 0,3 &nbsp;|&nbsp; c = 1
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start"><strong>(b)</strong> PS melakukan analisis terhadap produktivitas PkM DTPS, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis + faktor penyebab + dampak</td>
                        <td>Analisis + faktor penyebab</td>
                        <td>Analisis saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (isElemen60) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="2">
                            <strong>(a)</strong> DTPS melibatkan mahasiswa dalam kegiatan PkM.<br><br>
                            PPkDM = (NPkM / NPkDTPS) × 100%
                        </td>
                        <td colspan="4" class="text-start">
                            PPkDM ≥ 75% → Skor = 4 &nbsp;|&nbsp;
                            PPkDM &lt; 75% → Skor = 2 + (8 × PPkDM) &nbsp;|&nbsp;
                            <em>Tidak ada skor 1</em>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-start small">
                            NPkM = Jumlah PkM DTPS yang melibatkan mahasiswa PS &nbsp;|&nbsp; NPkDTPS = Jumlah PkM DTPS
                        </td>
                    </tr>
                    <tr>
                        <td><strong>(b)</strong> PS melakukan analisis keterlibatan mahasiswa dalam PkM DTPS, faktor-faktor penyebab, dan dampaknya.</td>
                        <td>Analisis + faktor penyebab + dampak</td>
                        <td>Analisis + faktor penyebab</td>
                        <td>Analisis saja</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (nomor === 15) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start">
                            <strong>(a)</strong> Dalam 5 tahun terakhir, mahasiswa menghasilkan karya inovatif, publikasi ilmiah sesuai bidang PS, dan/atau karya seni yang dipamerkan/dipagelarkan.
                        </td>
                        <td class="bg-success text-white">≥ 20% mahasiswa</td>
                        <td>≥ 15% mahasiswa</td>
                        <td>≥ 10% mahasiswa</td>
                        <td class="bg-danger text-white">&lt; 10% mahasiswa</td>
                    </tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> PS melakukan analisis kontribusi produktivitas karya inovatif/publikasi ilmiah terhadap: (1) penguatan budaya akademik, (2) peningkatan daya saing lulusan, (3) reputasi PS nasional/internasional.
                        </td>
                        <td class="bg-success text-white">Analisis 3 aspek</td>
                        <td>Analisis 2 aspek</td>
                        <td>Analisis 1 aspek</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else if (nomor === 10) {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle text-center small">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" rowspan="2" style="width:35%">INDIKATOR</th>
                        <th colspan="4">HARKAT PENSKORAN</th>
                    </tr>
                    <tr>
                        <th class="bg-success text-white">4</th>
                        <th class="bg-warning">3</th>
                        <th class="bg-warning">2</th>
                        <th class="bg-danger text-white">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-start" rowspan="2">
                            <strong>(a)</strong> PS memperoleh mahasiswa baru dengan kualitas input yang baik, memenuhi aspek: (1) kriteria seleksi tinggi, (2) mekanisme seleksi ketat, (3) rasio pendaftar:diterima min 1:1, dan (4) jumlah pendaftar memenuhi daya tampung dalam 5 tahun terakhir.
                        </td>
                        <td class="bg-success text-white">Memenuhi 4 aspek; rasio pendaftar:lulus seleksi ≥ 4:1</td>
                        <td>Memenuhi 3 aspek; rasio ≥ 3:1</td>
                        <td>Memenuhi 2 aspek; rasio ≥ 2:1</td>
                        <td class="bg-danger text-white">Memenuhi &lt;2 aspek; rasio 1:1 atau tidak memenuhi daya tampung</td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td class="text-start">
                            <strong>(b)</strong> PS melakukan analisis terhadap: (1) rasio pendaftar:diterima, (2) jumlah pendaftar vs daya tampung, (3) kualitas input berdasarkan mekanisme dan hasil seleksi.
                        </td>
                        <td class="bg-success text-white">Analisis 3 aspek</td>
                        <td>Analisis 2 aspek</td>
                        <td>Analisis 1 aspek</td>
                        <td class="bg-danger text-white">Tidak ada analisis</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="5">Skor Akhir = (3 × Skor(a) + Skor(b)) / 4</td>
                    </tr>
                </tbody>
            </table>
            </div>`);
                    } else {
                        container.insertAdjacentHTML('beforeend', `
            <div class="mt-3 mb-3">
                <label class="form-label"><strong>Harkat Penskoran</strong></label>
            </div>
            <pre class='harkat_penskoran'>${harkat_penskoran}</pre>`);
                    }
                }

                // =======================
                // 🔥 SUB ITEM (VARIABEL)
                // =======================
                if (subItems && subItems.length > 0) {
                    subItems.forEach(item => {
                        // Skip RK for element 7 — auto-computed
                        if (isElemen7 && item.variabel === 'RK') return;
                        // Skip RMD for element 11 — auto-computed
                        if (isElemen11 && item.variabel === 'RMD') return;
                        // Skip RI, RN, RW for element 14 — auto-computed
                        if (isElemen14 && ['RI', 'RN', 'RW'].includes(item.variabel)) return;
                        // Skip PDS3, PGBLKL for element 19 — auto-computed
                        if (isElemen19 && ['PDS3', 'PGBLKL'].includes(item.variabel)) return;
                        // Skip RRD for element 21 — auto-computed from NRD/NDTPS
                        if (isElemen21 && ['RRD'].includes(item.variabel)) return;
                        // Skip PDIPPKM, PMKI for element 33 — auto-computed
                        if (isElemen33 && ['PDIPPKM', 'PMKI'].includes(item.variabel)) return;
                        // Skip NDTPS_PUB for element 56 — auto-computed from SINTA fields
                        if (isElemen56 && item.variabel === 'NDTPS_PUB') return;

                        const userData = userSubItemMap[item.id] || null;
                        const nilai = userData ? userData.nilai : '';

                        container.insertAdjacentHTML('beforeend', `
            <div class="mb-3 variabel-item">
                <label class="form-label">
                    <strong>${item.variabel}</strong> : ${item.deskripsi}
                </label>

                <input
                    type="number"
                    class="form-control variabel-input"
                    name="variabel[${item.id}]"
                    value="${nilai}"
                    min="0"
                    step="any"
                >
            </div>
        `);
                    });
                }

                // =======================
                // 🔥 PILIHAN SKOR (RADIO)
                // =======================
                var skor_a_awal = btn.dataset.skor_a ? parseInt(btn.dataset.skor_a) : 0;
                var skor_b_awal = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;

                let pilihanFinal = pilihan && Object.keys(pilihan).length > 0 ?
                    pilihan : {
                        1: "",
                        2: "",
                        3: "",
                        4: ""
                    };

                function renderRadioGroup(label, name, options, checkedValue) {
                    let html = `
            <div class="mb-3 mt-3">
                <label class="form-label fw-bold">${label}</label>
            </div>`;

                    Object.keys(options)
                        .sort((a, b) => b - a)
                        .forEach(skor => {
                            let id = name + "_" + skor;
                            let isChecked = (checkedValue == skor) ? "checked" : "";
                            html += `
                <div class="form-check">
                    <input class="form-check-input skor-radio-${name}"
                           type="radio"
                           name="${name}"
                           value="${skor}"
                           id="${id}"
                           ${isChecked}>
                    <label class="form-check-label" for="${id}">
                        <strong>Skor ${skor}</strong>
                        ${options[skor] ?? ''}
                    </label>
                </div>`;
                        });

                    return html;
                }

                if (isElemen7) {
                    // Build variabel name → id mapping
                    const v2id = {};
                    subItems.forEach(item => { v2id[item.variabel] = item.id; });

                    // Helper: read value from input (or saved data as fallback)
                    function val(v) {
                        const id = v2id[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    // Compute Skor(a) from variabel values
                    function hitungSkorA() {
                        const N1 = val('N1'), N2 = val('N2'), N3 = val('N3'), NDTPS = val('NDTPS');
                        const NI = val('NI'), NN = val('NN'), NW = val('NW');

                        const RK = NDTPS > 0 ? ((3 * N1) + (2 * N2) + (1 * N3)) / NDTPS : 0;
                        const A = RK >= 4 ? 4 : RK;
                        let B;
                        if (NI >= 2) B = 4;
                        else if (NI > 0 && NI < 2 && NN >= 6) B = 3 + (NI / 2);
                        else if (NI > 0 && NI < 2 && NN > 0 && NN < 6) B = 2 + (2 * NI / 2) + (NN / 6) - (NI * NN) / (2 * 6);
                        else if (NI === 0 && NN === 0 && NW >= 9) B = 2;
                        else B = 1;
                        const skorA = Math.min(4, ((2 * A) + B) / 3);
                        return { RK, A, B, skorA };
                    }

                    // Auto-compute table
                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora-table">
                    <tr><td style="width:100px"><strong>RK</strong></td><td id="cv-rk" class="fw-bold">-</td></tr>
                    <tr><td><strong>A</strong></td><td id="cv-a">-</td></tr>
                    <tr><td><strong>B</strong></td><td id="cv-b">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora" class="fw-bold">-</td></tr>
                </table>`);

                    // Update table display
                    function updateSkorADisplay() {
                        const { RK, A, B, skorA } = hitungSkorA();
                        const el = id => document.getElementById(id);
                        el('cv-rk').textContent = RK.toFixed(2);
                        el('cv-a').textContent = A.toFixed(2);
                        el('cv-b').textContent = B.toFixed(2);
                        el('cv-skora').textContent = skorA.toFixed(2);
                        return skorA;
                    }

                    // Initial fill from saved data
                    updateSkorADisplay();

                    // Skor B (kualitatif) — manual radio
                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Kualitatif', 'skor_b',
                        pilihanFinal, skor_b_awal
                    ));

                    // Final score badge
                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final">
                        Belum lengkap
                    </span>
                </div>`);

                    function computeFinal7() {
                        const skorA = updateSkorADisplay();
                        const sb = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = sb > 0 ? ((3 * skorA + sb) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final');
                        if (sb > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(2)}</strong> | Skor(b): <strong>${sb}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = skorA > 0 ? 'Pilih Skor (b) untuk hasil akhir' : 'Isi data variabel dan pilih Skor (b)';
                        }

                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('nilai_total').value = nilaiAkhir;
                        document.getElementById('skor_b_hidden').value = sb;
                    }

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="${skor_b_awal}">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    // Hook: variabel inputs → recompute
                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal7);
                    });

                    // Hook: Skor B radio → recompute
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', function() {
                            document.getElementById('skor_b_hidden').value = this.value;
                            computeFinal7();
                        });
                    });

                } else if (isElemen11) {
                    // Element 11: auto-compute Skor(a) from NM/NDTPS + radio for Skor(b)
                    const v2id11 = {};
                    subItems.forEach(item => { v2id11[item.variabel] = item.id; });

                    function val11(v) {
                        const id = v2id11[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    let kelompok = sessionStorage.getItem('kelompok11') || btn.dataset.kelompok || 'sains';
                    window._kelompok11 = kelompok;

                    function hitungSkorA11() {
                        const NM = val11('NM'), NDTPS = val11('NDTPS');
                        const RMD = NDTPS > 0 ? NM / NDTPS : 0;
                        const k = window._kelompok11 || 'sains';
                        let skorA;
                        if (k === 'sains') {
                            if (RMD >= 15 && RMD <= 25) skorA = 4;
                            else if (RMD < 15) skorA = (4 * RMD) / 15;
                            else if (RMD > 25 && RMD <= 35) skorA = (70 - 2 * RMD) / 5;
                            else skorA = 1;
                        } else {
                            if (RMD >= 25 && RMD <= 35) skorA = 4;
                            else if (RMD < 25) skorA = (4 * RMD) / 25;
                            else if (RMD > 35 && RMD <= 50) skorA = (200 - 4 * RMD) / 15;
                            else skorA = 1;
                        }
                        return { RMD, skorA: Math.max(1, Math.min(4, skorA)) };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2 mb-2">
                    <label class="form-label"><strong>Kelompok Program Studi</strong></label>
                    <select class="form-select form-select-sm" id="kelompok-select" style="width:auto">
                        <option value="sains" ${kelompok === 'sains' ? 'selected' : ''}>Sains Teknologi</option>
                        <option value="sosial" ${kelompok === 'sosial' ? 'selected' : ''}>Sosial Humaniora</option>
                    </select>
                </div>
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora11-table">
                    <tr><td style="width:100px"><strong>RMD</strong></td><td id="cv-rmd" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora11" class="fw-bold">-</td></tr>
                </table>`);

                    function updateSkorA11() {
                        const { RMD, skorA } = hitungSkorA11();
                        document.getElementById('cv-rmd').textContent = RMD.toFixed(2);
                        document.getElementById('cv-skora11').textContent = skorA.toFixed(2);
                        return skorA;
                    }

                    updateSkorA11();
                    document.getElementById('kelompok-select').addEventListener('change', function() {
                        kelompok = this.value;
                        window._kelompok11 = this.value;
                        btn.dataset.kelompok = this.value;
                        sessionStorage.setItem('jurusan_kelompok11', this.value);
                        sessionStorage.setItem('kelompok11', this.value);
                        updateSkorA11();
                        computeFinal11();
                    });

                    var skor_b_awal11 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis', 'skor_b',
                        pilihan[1].options, skor_b_awal11
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final11">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="${skor_b_awal11}">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal11() {
                        const skorA = updateSkorA11();
                        const sb = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = sb > 0 ? ((3 * skorA + sb) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final11');
                        if (sb > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(2)}</strong> | Skor(b): <strong>${sb}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = skorA > 0 ? 'Pilih Skor (b) untuk hasil akhir' : 'Isi data variabel dan pilih Skor (b)';
                        }

                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('nilai_total').value = nilaiAkhir;
                        document.getElementById('skor_b_hidden').value = sb;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal11);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', function() {
                            document.getElementById('skor_b_hidden').value = this.value;
                            computeFinal11();
                        });
                    });

                } else if (isElemen14) {
                    // Element 14: auto-compute Skor(a) from NI/NN/NW/NM + radio for Skor(b)
                    const v2id14 = {};
                    subItems.forEach(item => { v2id14[item.variabel] = item.id; });

                    function val14(v) {
                        const id = v2id14[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA14() {
                        const NI = val14('NI'), NN = val14('NN'), NW = val14('NW'), NM = val14('NM');
                        const a = 0.005, b = 0.05, c = 0.10;
                        const RI = NM > 0 ? NI / NM : 0;
                        const RN = NM > 0 ? NN / NM : 0;
                        const RW = NM > 0 ? NW / NM : 0;
                        let skorA;
                        if (RI >= a) skorA = 4;
                        else if (RN >= b) skorA = 3 + (RI / a);
                        else if (RI > 0 && RN > 0) skorA = 2 + (RI / a) + (RN / b) - (RI * RN) / (a * b);
                        else if (RW >= c) skorA = 2;
                        else skorA = 1;
                        return { RI, RN, RW, skorA: Math.max(1, Math.min(4, skorA)) };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora14-table">
                    <tr><td style="width:100px"><strong>RI</strong></td><td id="cv-ri" class="fw-bold">-</td></tr>
                    <tr><td><strong>RN</strong></td><td id="cv-rn" class="fw-bold">-</td></tr>
                    <tr><td><strong>RW</strong></td><td id="cv-rw" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora14" class="fw-bold">-</td></tr>
                </table>`);

                    function updateSkorA14() {
                        const { RI, RN, RW, skorA } = hitungSkorA14();
                        document.getElementById('cv-ri').textContent = (RI * 100).toFixed(2) + '%';
                        document.getElementById('cv-rn').textContent = (RN * 100).toFixed(2) + '%';
                        document.getElementById('cv-rw').textContent = (RW * 100).toFixed(2) + '%';
                        document.getElementById('cv-skora14').textContent = skorA.toFixed(2);
                        return skorA;
                    }

                    updateSkorA14();

                    var skor_b_awal14 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis', 'skor_b',
                        pilihan[1].options, skor_b_awal14
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final14">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="${skor_b_awal14}">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal14() {
                        const skorA = updateSkorA14();
                        const sb = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = sb > 0 ? ((3 * skorA + sb) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final14');
                        if (sb > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(2)}</strong> | Skor(b): <strong>${sb}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = skorA > 0 ? 'Pilih Skor (b) untuk hasil akhir' : 'Isi data variabel dan pilih Skor (b)';
                        }

                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('nilai_total').value = nilaiAkhir;
                        document.getElementById('skor_b_hidden').value = sb;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal14);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', function() {
                            document.getElementById('skor_b_hidden').value = this.value;
                            computeFinal14();
                        });
                    });

                } else if (isElemen15) {
                    // Element 15: auto-compute Skor(a) from PKIM + radio for Skor(b)
                    const v2id15 = {};
                    subItems.forEach(item => { v2id15[item.variabel] = item.id; });

                    function val15(v) {
                        const id = v2id15[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA15() {
                        const NM = val15('NM');
                        const sumPub = val15('SINTA1_MHS') + val15('SINTA2_MHS') + val15('SINTA3_MHS')
                            + val15('SINTA4_MHS') + val15('SINTA5_MHS') + val15('SINTA6_MHS')
                            + val15('INT_MHS') + val15('ISBN_MHS') + val15('PATEN_MHS');
                        const pkim = NM > 0 ? (sumPub / NM) * 100 : 0;
                        let skorA;
                        if (pkim >= 20) skorA = 4;
                        else if (pkim >= 15) skorA = 3;
                        else if (pkim >= 10) skorA = 2;
                        else if (pkim > 0) skorA = 1;
                        else skorA = 0;
                        return { pkim, skorA, sumPub };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora15-table">
                    <tr><td style="width:100px"><strong>Total Karya</strong></td><td id="cv-sumpub" class="fw-bold">-</td></tr>
                    <tr><td><strong>PKIM</strong></td><td id="cv-pkim" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora15" class="fw-bold">-</td></tr>
                </table>`);

                    function updateSkorA15() {
                        const { pkim, skorA, sumPub } = hitungSkorA15();
                        document.getElementById('cv-sumpub').textContent = sumPub;
                        document.getElementById('cv-pkim').textContent = pkim > 0 ? pkim.toFixed(1) + '%' : '-';
                        document.getElementById('cv-skora15').textContent = skorA > 0 ? skorA.toFixed(1) : '-';
                        return skorA;
                    }

                    updateSkorA15();

                    var skor_b_awal15 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis', 'skor_b',
                        pilihan[1].options, skor_b_awal15
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final15">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="${skor_b_awal15}">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal15() {
                        const skorA = updateSkorA15();
                        const sb = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (skorA > 0 && sb > 0) ? ((3 * skorA + sb) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final15');
                        if (sb > 0 && skorA > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(2)}</strong> | Skor(b): <strong>${sb}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else if (skorA > 0) {
                            live.innerHTML = 'Pilih Skor (b) untuk hasil akhir';
                        } else {
                            live.innerHTML = 'Isi PKIM dan pilih Skor (b)';
                        }

                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('nilai_total').value = nilaiAkhir;
                        document.getElementById('skor_b_hidden').value = sb;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal15);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', function() {
                            document.getElementById('skor_b_hidden').value = this.value;
                            computeFinal15();
                        });
                    });

                } else if (isElemen16) {
                    // Element 16: auto-compute Skor(a) from JUMLAH_ASPEK and Skor(b) from TKM
                    // Formula: (Skor(a) + 3 × Skor(b)) / 4
                    const v2id16 = {};
                    subItems.forEach(item => { v2id16[item.variabel] = item.id; });

                    function val16(v) {
                        const id = v2id16[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkor16() {
                        const jumlah = val16('JUMLAH_ASPEK');
                        const tkm = val16('TKM');
                        let skorA;
                        if (jumlah >= 6) skorA = 4;
                        else if (jumlah >= 5) skorA = 3;
                        else if (jumlah >= 4) skorA = 2;
                        else if (jumlah > 0) skorA = 1;
                        else skorA = 0;
                        let skorB;
                        if (tkm >= 75) skorB = 4;
                        else if (tkm >= 50) skorB = 3;
                        else if (tkm >= 25) skorB = 2;
                        else if (tkm > 0) skorB = 1;
                        else skorB = 0;
                        return { jumlah, tkm, skorA, skorB };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora16-table">
                    <tr><td style="width:100px"><strong>Skor (a)</strong></td><td id="cv-skora16" class="fw-bold">-</td></tr>
                    <tr><td><strong>Skor (b)</strong></td><td id="cv-skorB16" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Akhir</strong></td><td id="cv-akhir16" class="fw-bold">-</td></tr>
                </table>`);

                    function updateSkor16() {
                        const { jumlah, tkm, skorA, skorB } = hitungSkor16();
                        document.getElementById('cv-skora16').textContent = skorA > 0 ? skorA.toFixed(1) : '-';
                        document.getElementById('cv-skorB16').textContent = skorB > 0 ? skorB.toFixed(1) : '-';
                        return { skorA, skorB };
                    }

                    // Show initial values immediately
                    updateSkor16();

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal16() {
                        const { skorA, skorB } = updateSkor16();
                        const jawabanAkhir = (skorA > 0 && skorB > 0) ? ((skorA + 3 * skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        document.getElementById('cv-akhir16').textContent = jawabanAkhir > 0 ? jawabanAkhir.toFixed(2) : '-';
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal16);
                    });

                } else if (isElemen19) {
                    // Element 19: auto-compute Skor(a) from PDS3 and Skor(b) from PGBLKL
                    // Final: (3 × (Skor(a) + Skor(b)) + Skor(c)) / 7
                    const v2id19 = {};
                    subItems.forEach(item => { v2id19[item.variabel] = item.id; });

                    function val19(v) {
                        const id = v2id19[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA19() {
                        const nds3 = val19('NDS3'), ndtps = val19('NDTPS');
                        const pds3 = ndtps > 0 ? (nds3 / ndtps) * 100 : 0;
                        let skorA;
                        if (pds3 >= 40) skorA = 4;
                        else if (pds3 > 0) skorA = 2 + (5 * pds3 / 100);
                        else skorA = 0;
                        return { nds3, ndtps, pds3, skorA };
                    }

                    function hitungSkorB19() {
                        const ndgb = val19('NDGB'), ndlk = val19('NDLK'), ndl = val19('NDL'), ndtps = val19('NDTPS');
                        const pgblkl = ndtps > 0 ? ((ndgb + ndlk + ndl) / ndtps) * 100 : 0;
                        let skorB;
                        if (pgblkl >= 70) skorB = 4;
                        else if (pgblkl > 0) skorB = 2 + (20 * pgblkl / 100 / 7);
                        else skorB = 0;
                        return { ndgb, ndlk, ndl, ndtps, pgblkl, skorB };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora19-table">
                    <tr><td style="width:150px"><strong>PDS3</strong></td><td id="cv-pds3" class="fw-bold">-</td></tr>
                    <tr><td><strong>Skor (a)</strong></td><td id="cv-skora19" class="fw-bold">-</td></tr>
                    <tr><td><strong>PGBLKL</strong></td><td id="cv-pgblkl" class="fw-bold">-</td></tr>
                    <tr><td><strong>Skor (b)</strong></td><td id="cv-skorB19" class="fw-bold">-</td></tr>
                </table>`);

                    function updateSkor19() {
                        const { pds3, skorA } = hitungSkorA19();
                        const { pgblkl, skorB } = hitungSkorB19();
                        document.getElementById('cv-pds3').textContent = pds3 > 0 ? pds3.toFixed(2) + '%' : '-';
                        document.getElementById('cv-skora19').textContent = skorA > 0 ? skorA.toFixed(1) : '-';
                        document.getElementById('cv-pgblkl').textContent = pgblkl > 0 ? pgblkl.toFixed(2) + '%' : '-';
                        document.getElementById('cv-skorB19').textContent = skorB > 0 ? skorB.toFixed(1) : '-';
                        return { skorA, skorB };
                    }

                    updateSkor19();

                    // Skor(c) — radio from pilihan.options
                    const skorC_awal = jawaban ? parseInt(jawaban) : 0;
                    const skorCOptions = (pilihan && pilihan.options) ? pilihan.options : {};
                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (c) — Analisis', 'jawaban',
                        skorCOptions, skorC_awal
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final19">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal19() {
                        const { skorA, skorB } = updateSkor19();
                        const skorC = parseInt(document.querySelector('input[name="jawaban"]:checked')?.value || 0);
                        const jawabanAkhir = (skorA > 0 && skorB > 0 && skorC > 0) ? ((3 * (skorA + skorB) + skorC) / 7) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final19');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(1)}</strong> | Skor(b): <strong>${skorB.toFixed(1)}</strong> | Skor(c): <strong>${skorC}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi semua data untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal19);
                    });
                    document.querySelectorAll('.skor-radio-jawaban').forEach(el => {
                        el.addEventListener('change', computeFinal19);
                    });

                } else if (isElemen20) {
                    // Element 20: auto-compute Skor(a) from BKD, radio Skor(b)
                    // Final: (3 × Skor(a) + Skor(b)) / 4
                    const v2id20 = {};
                    subItems.forEach(item => { v2id20[item.variabel] = item.id; });

                    function val20(v) {
                        const id = v2id20[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA20() {
                        const bkd = val20('BKD');
                        let skorA;
                        if (bkd >= 12 && bkd <= 16) skorA = 4;
                        else if (bkd >= 6 && bkd < 12) skorA = (2 * bkd - 12) / 3;
                        else if (bkd > 16 && bkd <= 18) skorA = 36 - (2 * bkd);
                        else if (bkd > 0) skorA = 1;
                        else skorA = 0;
                        return { bkd, skorA };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora20-table">
                    <tr><td style="width:120px"><strong>BKD</strong></td><td id="cv-bkd" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora20" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal20 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions20 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA20() {
                        const { bkd, skorA } = hitungSkorA20();
                        document.getElementById('cv-bkd').textContent = bkd > 0 ? bkd.toFixed(1) : '-';
                        document.getElementById('cv-skora20').textContent = (bkd > 0) ? skorA.toFixed(2) : '-';
                        return { bkd, skorA };
                    }

                    updateSkorA20();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Distribusi BKD', 'skor_b',
                        skorBOptions20, skorB_awal20
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final20">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal20() {
                        const { bkd, skorA } = updateSkorA20();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (bkd > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final20');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(2)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi BKD dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal20);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal20);
                    });

                } else if (isElemen21) {
                    // Element 21: auto-compute Skor(a) from RRD (NRD/NDTPS), radio Skor(b)
                    // Final: (3 × Skor(a) + Skor(b)) / 4
                    const v2id21 = {};
                    subItems.forEach(item => { v2id21[item.variabel] = item.id; });

                    function val21(v) {
                        const id = v2id21[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA21() {
                        const nrd = val21('NRD'), ndtps = val21('NDTPS');
                        const rrd = ndtps > 0 ? nrd / ndtps : 0;
                        let skorA;
                        if (!ndtps) skorA = 0;
                        else if (rrd >= 1) skorA = 4;
                        else skorA = 2 + (2 * rrd);
                        return { nrd, ndtps, rrd, skorA };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora21-table">
                    <tr><td style="width:120px"><strong>RRD</strong></td><td id="cv-rrd21" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora21" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal21 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions21 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA21() {
                        const { ndtps, rrd, skorA } = hitungSkorA21();
                        document.getElementById('cv-rrd21').textContent = ndtps > 0 ? rrd.toFixed(2) : '-';
                        document.getElementById('cv-skora21').textContent = ndtps > 0 ? skorA.toFixed(2) : '-';
                        return { ndtps, skorA };
                    }

                    updateSkorA21();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Kepakaran', 'skor_b',
                        skorBOptions21, skorB_awal21
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final21">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal21() {
                        const { ndtps, skorA } = updateSkorA21();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (ndtps > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final21');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(2)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi NRD/NDTPS dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal21);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal21);
                    });

                } else if (isElemen22) {
                    // Element 22: auto-compute Skor(a) from NDTPSPK (%), radio Skor(b)
                    // Final: (3 × Skor(a) + Skor(b)) / 4
                    const v2id22 = {};
                    subItems.forEach(item => { v2id22[item.variabel] = item.id; });

                    function val22(v) {
                        const id = v2id22[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA22() {
                        const ndtpspk = val22('NDTPSPK');
                        let skorA;
                        if (ndtpspk >= 80) skorA = 4;
                        else if (ndtpspk >= 70) skorA = 3;
                        else if (ndtpspk >= 60) skorA = 2;
                        else if (ndtpspk > 0) skorA = 1;
                        else skorA = 0;
                        return { ndtpspk, skorA };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora22-table">
                    <tr><td style="width:140px"><strong>NDTPSPK</strong></td><td id="cv-ndtpspk" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora22" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal22 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions22 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA22() {
                        const { ndtpspk, skorA } = hitungSkorA22();
                        document.getElementById('cv-ndtpspk').textContent = ndtpspk > 0 ? ndtpspk.toFixed(1) + '%' : '-';
                        document.getElementById('cv-skora22').textContent = ndtpspk > 0 ? skorA.toFixed(1) : '-';
                        return { ndtpspk, skorA };
                    }

                    updateSkorA22();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Kontribusi', 'skor_b',
                        skorBOptions22, skorB_awal22
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final22">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal22() {
                        const { ndtpspk, skorA } = updateSkorA22();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (ndtpspk > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final22');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(1)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi NDTPSPK dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal22);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal22);
                    });

                } else if (isElemen23) {
                    // Element 23: auto-compute Skor(a) from NTENDIKPK (%), radio Skor(b)
                    // Final: (3 × Skor(a) + Skor(b)) / 4
                    const v2id23 = {};
                    subItems.forEach(item => { v2id23[item.variabel] = item.id; });

                    function val23(v) {
                        const id = v2id23[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA23() {
                        const ntendikpk = val23('NTENDIKPK');
                        let skorA;
                        if (ntendikpk >= 40) skorA = 4;
                        else if (ntendikpk >= 25) skorA = 3;
                        else if (ntendikpk >= 10) skorA = 2;
                        else if (ntendikpk > 0) skorA = 1;
                        else skorA = 0;
                        return { ntendikpk, skorA };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora23-table">
                    <tr><td style="width:150px"><strong>NTENDIKPK</strong></td><td id="cv-ntendikpk" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora23" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal23 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions23 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA23() {
                        const { ntendikpk, skorA } = hitungSkorA23();
                        document.getElementById('cv-ntendikpk').textContent = ntendikpk > 0 ? ntendikpk.toFixed(1) + '%' : '-';
                        document.getElementById('cv-skora23').textContent = ntendikpk > 0 ? skorA.toFixed(1) : '-';
                        return { ntendikpk, skorA };
                    }

                    updateSkorA23();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Tenaga Kependidikan', 'skor_b',
                        skorBOptions23, skorB_awal23
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final23">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal23() {
                        const { ntendikpk, skorA } = updateSkorA23();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (ntendikpk > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final23');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(1)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi NTENDIKPK dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal23);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal23);
                    });

                } else if (isElemen33) {
                    // Element 33: 4-score element
                    // (a) radio, (b) auto PDIPPKM, (c) auto PMKI, (d) radio
                    // Akhir = Skor(a) + (3 × (Skor(b) + Skor(c)) + Skor(d)) / 8
                    const v2id33 = {};
                    subItems.forEach(item => { v2id33[item.variabel] = item.id; });

                    function val33(v) {
                        const id = v2id33[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    // Skor(b) from PDIPPKM
                    function hitungSkorB33() {
                        const ndippkm = val33('NDIPPKM'), ndtps = val33('NDTPS');
                        const pdippkm = ndtps > 0 ? (ndippkm / ndtps) * 100 : 0;
                        let skorB;
                        if (!ndtps) skorB = 0;
                        else if (pdippkm >= 50) skorB = 4;
                        else if (pdippkm >= 30) skorB = 3;
                        else if (pdippkm >= 10) skorB = 2;
                        else skorB = 1;
                        return { ndippkm, ndtps, pdippkm, skorB };
                    }

                    // Skor(c) from PMKI
                    function hitungSkorC33() {
                        const nmki = val33('NMKI'), nmk = val33('NMK');
                        const pmki = nmk > 0 ? (nmki / nmk) * 100 : 0;
                        let skorC;
                        if (!nmk) skorC = 0;
                        else if (pmki >= 25) skorC = 4;
                        else if (pmki >= 15) skorC = 3 + ((pmki - 25) / 100 / 0.10);
                        else skorC = 2;
                        return { nmki, nmk, pmki, skorC };
                    }

                    // Auto-compute table
                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora33-table">
                    <tr><td style="width:150px"><strong>PDIPPKM</strong></td><td id="cv-pdippkm" class="fw-bold">-</td></tr>
                    <tr><td><strong>Skor (b)</strong></td><td id="cv-skorB33" class="fw-bold">-</td></tr>
                    <tr><td><strong>PMKI</strong></td><td id="cv-pmki" class="fw-bold">-</td></tr>
                    <tr><td><strong>Skor (c)</strong></td><td id="cv-skorC33" class="fw-bold">-</td></tr>
                </table>`);

                    function updateSkorBC33() {
                        const { ndtps, pdippkm, skorB } = hitungSkorB33();
                        const { nmk, pmki, skorC } = hitungSkorC33();
                        document.getElementById('cv-pdippkm').textContent = ndtps > 0 ? pdippkm.toFixed(1) + '%' : '-';
                        document.getElementById('cv-skorB33').textContent = ndtps > 0 ? skorB.toFixed(1) : '-';
                        document.getElementById('cv-pmki').textContent = nmk > 0 ? pmki.toFixed(1) + '%' : '-';
                        document.getElementById('cv-skorC33').textContent = nmk > 0 ? skorC.toFixed(2) : '-';
                        return { ndtps, nmk, skorB, skorC };
                    }

                    updateSkorBC33();

                    // Skor(a) — radio
                    const skorA_awal33 = btn.dataset.skor_a ? parseInt(btn.dataset.skor_a) : 0;
                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        pilihan[0].label || 'Pilih Skor (a) — Integrasi', 'skor_a',
                        pilihan[0].options, skorA_awal33
                    ));

                    // Skor(d) — radio (store in skor_b column since Skor(b) auto-computed)
                    const skorD_awal33 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        pilihan[1].label || 'Pilih Skor (d) — Analisis', 'skor_b',
                        pilihan[1].options, skorD_awal33
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final33">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal33() {
                        const { ndtps, nmk, skorB, skorC } = updateSkorBC33();
                        const skorA = parseInt(document.querySelector('input[name="skor_a"]:checked')?.value || 0);
                        const skorD = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (ndtps > 0 && nmk > 0 && skorA > 0 && skorD > 0)
                            ? (skorA + (3 * (skorB + skorC) + skorD) / 8) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final33');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA}</strong> | Skor(b): <strong>${skorB.toFixed(1)}</strong> | Skor(c): <strong>${skorC.toFixed(2)}</strong> | Skor(d): <strong>${skorD}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi semua data untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorD;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal33);
                    });
                    document.querySelectorAll('.skor-radio-skor_a').forEach(el => {
                        el.addEventListener('change', computeFinal33);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal33);
                    });

                } else if (isElemen40) {
                    // Element 40: auto-compute Skor(a) from RIPK, radio Skor(b)
                    // Final: (3 × Skor(a) + Skor(b)) / 4
                    const v2id40 = {};
                    subItems.forEach(item => { v2id40[item.variabel] = item.id; });

                    function val40(v) {
                        const id = v2id40[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA40() {
                        const ripk = val40('RIPK');
                        let skorA;
                        if (ripk >= 3.25) skorA = 4;
                        else if (ripk >= 2.00) skorA = ((8 * ripk) - 6) / 5;
                        else if (ripk > 0) skorA = 0;
                        else skorA = 0;
                        return { ripk, skorA };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora40-table">
                    <tr><td style="width:120px"><strong>RIPK</strong></td><td id="cv-ripk" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora40" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal40 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions40 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA40() {
                        const { ripk, skorA } = hitungSkorA40();
                        document.getElementById('cv-ripk').textContent = ripk > 0 ? ripk.toFixed(2) : '-';
                        document.getElementById('cv-skora40').textContent = ripk > 0 ? skorA.toFixed(2) : '-';
                        return { ripk, skorA };
                    }

                    updateSkorA40();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis IPK Lulusan', 'skor_b',
                        skorBOptions40, skorB_awal40
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final40">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal40() {
                        const { ripk, skorA } = updateSkorA40();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (ripk > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final40');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(2)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi RIPK dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal40);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal40);
                    });

                } else if (isElemen41) {
                    // Element 41: auto-compute Skor(a) from RMS, radio Skor(b)
                    // Final: (3 × Skor(a) + Skor(b)) / 4
                    const v2id41 = {};
                    subItems.forEach(item => { v2id41[item.variabel] = item.id; });

                    function val41(v) {
                        const id = v2id41[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA41() {
                        const rms = val41('RMS');
                        let skorA;
                        if (rms <= 0) skorA = 0;
                        else if (rms > 5) skorA = 1;
                        else if (rms > 4) skorA = Math.max(1, 4 - ((rms - 4) / 0.5) * 1.5);
                        else skorA = 4; // RMS ≤ 4 → score 4
                        return { rms, skorA };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora41-table">
                    <tr><td style="width:120px"><strong>RMS</strong></td><td id="cv-rms" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora41" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal41 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions41 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA41() {
                        const { rms, skorA } = hitungSkorA41();
                        document.getElementById('cv-rms').textContent = rms > 0 ? rms.toFixed(2) : '-';
                        document.getElementById('cv-skora41').textContent = rms > 0 ? skorA.toFixed(2) : '-';
                        return { rms, skorA };
                    }

                    updateSkorA41();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Masa Studi', 'skor_b',
                        skorBOptions41, skorB_awal41
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final41">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal41() {
                        const { rms, skorA } = updateSkorA41();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (rms > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final41');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(2)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi RMS dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal41);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal41);
                    });

                } else if (isElemen42) {
                    // Element 42: auto-compute Skor(a) from PMTK, radio Skor(b)
                    // Final: (3 × Skor(a) + Skor(b)) / 4
                    const v2id42 = {};
                    subItems.forEach(item => { v2id42[item.variabel] = item.id; });

                    function val42(v) {
                        const id = v2id42[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA42() {
                        const pmtkPct = val42('PMTK'); // 0-100
                        const pmtk = pmtkPct / 100;
                        let skorA;
                        if (pmtkPct <= 0) skorA = 0;
                        else if (pmtk >= 0.5) skorA = 4;
                        else skorA = Math.min(4, Math.max(1, 1 + 6 * pmtk));
                        return { pmtkPct, skorA };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora42-table">
                    <tr><td style="width:120px"><strong>PMTK</strong></td><td id="cv-pmtk" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora42" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal42 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions42 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA42() {
                        const { pmtkPct, skorA } = hitungSkorA42();
                        document.getElementById('cv-pmtk').textContent = pmtkPct > 0 ? pmtkPct.toFixed(2) + '%' : '-';
                        document.getElementById('cv-skora42').textContent = pmtkPct > 0 ? skorA.toFixed(2) : '-';
                        return { pmtkPct, skorA };
                    }

                    updateSkorA42();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Kelulusan Tepat Waktu', 'skor_b',
                        skorBOptions42, skorB_awal42
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final42">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal42() {
                        const { pmtkPct, skorA } = updateSkorA42();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (pmtkPct > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final42');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(2)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi PMTK dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal42);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal42);
                    });

                } else if (isElemen43) {
                    // Element 43: auto-compute Skor(a) from PKMS, radio Skor(b)
                    // Final: (3 × Skor(a) + Skor(b)) / 4
                    const v2id43 = {};
                    subItems.forEach(item => { v2id43[item.variabel] = item.id; });

                    function val43(v) {
                        const id = v2id43[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA43() {
                        const pkmsPct = val43('PKMS'); // 0-100
                        const pkms = pkmsPct / 100;
                        let skorA;
                        if (pkmsPct <= 0) skorA = 0;
                        else if (pkms >= 0.85) skorA = 4;
                        else if (pkms < 0.45) skorA = 1;
                        else skorA = Math.min(4, ((80 * pkms) - 24) / 11);
                        return { pkmsPct, skorA };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora43-table">
                    <tr><td style="width:120px"><strong>PKMS</strong></td><td id="cv-pkms" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora43" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal43 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions43 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA43() {
                        const { pkmsPct, skorA } = hitungSkorA43();
                        document.getElementById('cv-pkms').textContent = pkmsPct > 0 ? pkmsPct.toFixed(2) + '%' : '-';
                        document.getElementById('cv-skora43').textContent = pkmsPct > 0 ? skorA.toFixed(2) : '-';
                        return { pkmsPct, skorA };
                    }

                    updateSkorA43();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Keberhasilan Studi', 'skor_b',
                        skorBOptions43, skorB_awal43
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final43">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal43() {
                        const { pkmsPct, skorA } = updateSkorA43();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (pkmsPct > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final43');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(2)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi PKMS dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal43);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal43);
                    });

                } else if (isElemen45) {
                    // Element 45: PLB → base Skor(a), NL/NJ → respondent factor, radio Skor(b)
                    // Final: (3 × adjusted_Skor(a) + Skor(b)) / 4
                    const v2id45 = {};
                    subItems.forEach(item => { v2id45[item.variabel] = item.id; });

                    function val45(v) {
                        const id = v2id45[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungBaseSkorA45() {
                        const plb = val45('PLB'); // 0-100
                        let base;
                        if (plb <= 0) base = 0;
                        else if (plb >= 80) base = 4;
                        else if (plb >= 60) base = 3;
                        else if (plb >= 40) base = 2;
                        else base = 1;
                        return { plb, base };
                    }

                    function hitungResponden45() {
                        const nl = val45('NL');
                        const nj = val45('NJ');
                        let pj = 0, prmin = 0, faktor = 1;
                        if (nl > 0 && nj > 0) {
                            pj = (nj / nl) * 100;
                            prmin = nl >= 150 ? 30 : 50 - ((nl / 150) * 20);
                            faktor = pj >= prmin ? 1 : pj / prmin;
                        }
                        return { nl, nj, pj, prmin, faktor };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora45-table">
                    <tr><td style="width:120px"><strong>PLB</strong></td><td id="cv-plb45" class="fw-bold">-</td></tr>
                    <tr><td><strong>Base Skor(a)</strong></td><td id="cv-base45" class="fw-bold">-</td></tr>
                    <tr><td><strong>NL / NJ</strong></td><td id="cv-nlnj45" class="fw-bold">-</td></tr>
                    <tr><td><strong>PJ</strong></td><td id="cv-pj45" class="fw-bold">-</td></tr>
                    <tr><td><strong>Pr<sub>min</sub></strong></td><td id="cv-prmin45" class="fw-bold">-</td></tr>
                    <tr><td><strong>Faktor</strong></td><td id="cv-faktor45" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor(a) akhir</strong></td><td id="cv-skora45" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal45 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions45 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA45() {
                        const { plb, base } = hitungBaseSkorA45();
                        const { nl, nj, pj, prmin, faktor } = hitungResponden45();
                        const skorA = base > 0 ? base * faktor : 0;

                        document.getElementById('cv-plb45').textContent = plb > 0 ? plb.toFixed(2) + '%' : '-';
                        document.getElementById('cv-base45').textContent = base > 0 ? base.toFixed(2) : '-';
                        document.getElementById('cv-nlnj45').textContent = (nl > 0 && nj > 0) ? nl + ' / ' + nj : '-';
                        document.getElementById('cv-pj45').textContent = pj > 0 ? pj.toFixed(2) + '%' : '-';
                        document.getElementById('cv-prmin45').textContent = prmin > 0 ? prmin.toFixed(2) + '%' : '-';
                        document.getElementById('cv-faktor45').textContent = faktor < 1 ? faktor.toFixed(4) : (faktor > 0 ? '1' : '-');
                        document.getElementById('cv-skora45').textContent = skorA > 0 ? skorA.toFixed(4) : '-';

                        return { skorA };
                    }

                    updateSkorA45();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis', 'skor_b',
                        skorBOptions45, skorB_awal45
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final45">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal45() {
                        const { skorA } = updateSkorA45();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (skorA > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final45');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(4)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi PLB, NL, NJ dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal45);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal45);
                    });

                } else if (isElemen46) {
                    // Element 46: WTMP → base Skor(a), NL/NJ → respondent factor, radio Skor(b)
                    // Final: (3 × adjusted_Skor(a) + Skor(b)) / 4
                    const v2id46 = {};
                    subItems.forEach(item => { v2id46[item.variabel] = item.id; });

                    function val46(v) {
                        const id = v2id46[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungBaseSkorA46() {
                        const wtmp = val46('WTMP'); // months
                        let base;
                        if (wtmp <= 0) base = 0;
                        else if (wtmp < 6) base = 4;
                        else if (wtmp <= 12) base = (18 - wtmp) / 3;
                        else base = 1;
                        return { wtmp, base };
                    }

                    function hitungResponden46() {
                        const nl = val46('NL');
                        const nj = val46('NJ');
                        let pj = 0, prmin = 0, faktor = 1;
                        if (nl > 0 && nj > 0) {
                            pj = (nj / nl) * 100;
                            prmin = nl >= 150 ? 30 : 50 - ((nl / 150) * 20);
                            faktor = pj >= prmin ? 1 : pj / prmin;
                        }
                        return { nl, nj, pj, prmin, faktor };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora46-table">
                    <tr><td style="width:120px"><strong>WTMP</strong></td><td id="cv-wtmp46" class="fw-bold">-</td></tr>
                    <tr><td><strong>Base Skor(a)</strong></td><td id="cv-base46" class="fw-bold">-</td></tr>
                    <tr><td><strong>NL / NJ</strong></td><td id="cv-nlnj46" class="fw-bold">-</td></tr>
                    <tr><td><strong>PJ</strong></td><td id="cv-pj46" class="fw-bold">-</td></tr>
                    <tr><td><strong>Pr<sub>min</sub></strong></td><td id="cv-prmin46" class="fw-bold">-</td></tr>
                    <tr><td><strong>Faktor</strong></td><td id="cv-faktor46" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor(a) akhir</strong></td><td id="cv-skora46" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal46 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions46 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA46() {
                        const { wtmp, base } = hitungBaseSkorA46();
                        const { nl, nj, pj, prmin, faktor } = hitungResponden46();
                        const skorA = base > 0 ? base * faktor : 0;

                        document.getElementById('cv-wtmp46').textContent = wtmp > 0 ? wtmp.toFixed(1) + ' bln' : '-';
                        document.getElementById('cv-base46').textContent = base > 0 ? base.toFixed(2) : '-';
                        document.getElementById('cv-nlnj46').textContent = (nl > 0 && nj > 0) ? nl + ' / ' + nj : '-';
                        document.getElementById('cv-pj46').textContent = pj > 0 ? pj.toFixed(2) + '%' : '-';
                        document.getElementById('cv-prmin46').textContent = prmin > 0 ? prmin.toFixed(2) + '%' : '-';
                        document.getElementById('cv-faktor46').textContent = faktor < 1 ? faktor.toFixed(4) : (faktor > 0 ? '1' : '-');
                        document.getElementById('cv-skora46').textContent = skorA > 0 ? skorA.toFixed(4) : '-';

                        return { skorA };
                    }

                    updateSkorA46();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Waktu Tunggu', 'skor_b',
                        skorBOptions46, skorB_awal46
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final46">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal46() {
                        const { skorA } = updateSkorA46();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (skorA > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final46');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(4)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi WTMP, NL, NJ dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal46);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal46);
                    });

                } else if (isElemen47) {
                    // Element 47: PBS → base Skor(a), NL/NJ → respondent factor, radio Skor(b)
                    // Final: (3 × adjusted_Skor(a) + Skor(b)) / 4
                    const v2id47 = {};
                    subItems.forEach(item => { v2id47[item.variabel] = item.id; });

                    function val47(v) {
                        const id = v2id47[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungBaseSkorA47() {
                        const pbs = val47('PBS'); // 0-100
                        let base;
                        if (pbs <= 0) base = 0;
                        else if (pbs >= 60) base = 4;
                        else if (pbs <= 15) base = 1;
                        else base = pbs / 15; // linear from 1 at 15% to 4 at 60%
                        return { pbs, base };
                    }

                    function hitungResponden47() {
                        const nl = val47('NL');
                        const nj = val47('NJ');
                        let pj = 0, prmin = 0, faktor = 1;
                        if (nl > 0 && nj > 0) {
                            pj = (nj / nl) * 100;
                            prmin = nl >= 150 ? 30 : 50 - ((nl / 150) * 20);
                            faktor = pj >= prmin ? 1 : pj / prmin;
                        }
                        return { nl, nj, pj, prmin, faktor };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora47-table">
                    <tr><td style="width:120px"><strong>PBS</strong></td><td id="cv-pbs47" class="fw-bold">-</td></tr>
                    <tr><td><strong>Base Skor(a)</strong></td><td id="cv-base47" class="fw-bold">-</td></tr>
                    <tr><td><strong>NL / NJ</strong></td><td id="cv-nlnj47" class="fw-bold">-</td></tr>
                    <tr><td><strong>PJ</strong></td><td id="cv-pj47" class="fw-bold">-</td></tr>
                    <tr><td><strong>Pr<sub>min</sub></strong></td><td id="cv-prmin47" class="fw-bold">-</td></tr>
                    <tr><td><strong>Faktor</strong></td><td id="cv-faktor47" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor(a) akhir</strong></td><td id="cv-skora47" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal47 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions47 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA47() {
                        const { pbs, base } = hitungBaseSkorA47();
                        const { nl, nj, pj, prmin, faktor } = hitungResponden47();
                        const skorA = base > 0 ? base * faktor : 0;

                        document.getElementById('cv-pbs47').textContent = pbs > 0 ? pbs.toFixed(2) + '%' : '-';
                        document.getElementById('cv-base47').textContent = base > 0 ? base.toFixed(2) : '-';
                        document.getElementById('cv-nlnj47').textContent = (nl > 0 && nj > 0) ? nl + ' / ' + nj : '-';
                        document.getElementById('cv-pj47').textContent = pj > 0 ? pj.toFixed(2) + '%' : '-';
                        document.getElementById('cv-prmin47').textContent = prmin > 0 ? prmin.toFixed(2) + '%' : '-';
                        document.getElementById('cv-faktor47').textContent = faktor < 1 ? faktor.toFixed(4) : (faktor > 0 ? '1' : '-');
                        document.getElementById('cv-skora47').textContent = skorA > 0 ? skorA.toFixed(4) : '-';

                        return { skorA };
                    }

                    updateSkorA47();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Kesesuaian Bidang Kerja', 'skor_b',
                        skorBOptions47, skorB_awal47
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final47">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal47() {
                        const { skorA } = updateSkorA47();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (skorA > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final47');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(4)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi PBS, NL, NJ dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal47);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal47);
                    });

                } else if (isElemen48) {
                    // Element 48: TK1..TK9 → avg Skor(a), NL/NJ → respondent factor, radio Skor(b)
                    // Final: (3 × adjusted_Skor(a) + Skor(b)) / 4
                    const tkVars = ['TK1','TK2','TK3','TK4','TK5','TK6','TK7','TK8','TK9'];
                    const tkLabels = ['Etika','Keahlian bidang ilmu','Bahasa asing','TI','Komunikasi','Kerjasama','Pengembangan diri','Berpikir kritis','Kreativitas'];
                    const v2id48 = {};
                    subItems.forEach(item => { v2id48[item.variabel] = item.id; });

                    function val48(v) {
                        const id = v2id48[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA48() {
                        const tkValues = tkVars.map(v => val48(v));
                        const count = tkValues.filter(v => v > 0).length;
                        const sum = tkValues.reduce((a, b) => a + b, 0);
                        const base = count > 0 ? sum / count : 0;
                        return { tkValues, count, sum, base };
                    }

                    function hitungResponden48() {
                        const nl = val48('NL');
                        const nj = val48('NJ');
                        let pj = 0, prmin = 0, faktor = 1;
                        if (nl > 0 && nj > 0) {
                            pj = (nj / nl) * 100;
                            prmin = nl >= 150 ? 30 : 50 - ((nl / 150) * 20);
                            faktor = pj >= prmin ? 1 : pj / prmin;
                        }
                        return { nl, nj, pj, prmin, faktor };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora48-table">
                    <tr><td style="width:120px"><strong>Σ TKi</strong></td><td id="cv-sum48" class="fw-bold">-</td></tr>
                    <tr><td><strong>Rata-rata</strong></td><td id="cv-avg48" class="fw-bold">-</td></tr>
                    <tr><td><strong>Base Skor(a)</strong></td><td id="cv-base48" class="fw-bold">-</td></tr>
                    <tr><td><strong>NL / NJ</strong></td><td id="cv-nlnj48" class="fw-bold">-</td></tr>
                    <tr><td><strong>PJ</strong></td><td id="cv-pj48" class="fw-bold">-</td></tr>
                    <tr><td><strong>Pr<sub>min</sub></strong></td><td id="cv-prmin48" class="fw-bold">-</td></tr>
                    <tr><td><strong>Faktor</strong></td><td id="cv-faktor48" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor(a) akhir</strong></td><td id="cv-skora48" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal48 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions48 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA48() {
                        const { tkValues, count, sum, base } = hitungSkorA48();
                        const { nl, nj, pj, prmin, faktor } = hitungResponden48();
                        const skorA = base > 0 ? base * faktor : 0;

                        const tkiStr = tkValues.map((v, i) => v > 0 ? `TK${i+1}=${v.toFixed(2)}` : null).filter(Boolean).join(', ');
                        document.getElementById('cv-sum48').textContent = count > 0 ? sum.toFixed(2) + ' (' + tkiStr + ')' : '-';
                        document.getElementById('cv-avg48').textContent = count > 0 ? (sum / count).toFixed(4) : '-';
                        document.getElementById('cv-base48').textContent = base > 0 ? base.toFixed(4) : '-';
                        document.getElementById('cv-nlnj48').textContent = (nl > 0 && nj > 0) ? nl + ' / ' + nj : '-';
                        document.getElementById('cv-pj48').textContent = pj > 0 ? pj.toFixed(2) + '%' : '-';
                        document.getElementById('cv-prmin48').textContent = prmin > 0 ? prmin.toFixed(2) + '%' : '-';
                        document.getElementById('cv-faktor48').textContent = faktor < 1 ? faktor.toFixed(4) : (faktor > 0 ? '1' : '-');
                        document.getElementById('cv-skora48').textContent = skorA > 0 ? skorA.toFixed(4) : '-';

                        return { skorA };
                    }

                    updateSkorA48();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Kepuasan Pengguna', 'skor_b',
                        skorBOptions48, skorB_awal48
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final48">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal48() {
                        const { skorA } = updateSkorA48();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (skorA > 0 && skorB > 0) ? ((3 * skorA + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final48');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${skorA.toFixed(4)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi TK1–TK9, NL, NJ dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = skorA;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal48);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal48);
                    });

                } else if (isElemen53) {
                    // Element 53: Produktivitas Penelitian DTPS
                    // RI = NI/3/NDTPS, RN = NN/3/NDTPS, RL = NL/3/NDTPS
                    // a=0.05, b=0.3, c=1
                    const v2id53 = {};
                    subItems.forEach(item => { v2id53[item.variabel] = item.id; });

                    function val53(v) {
                        const id = v2id53[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    const A = 0.05, B = 0.3, C = 1;

                    function hitungSkorA53() {
                        const ni = val53('NI'), nn = val53('NN'), nl = val53('NL'), ndtps = val53('NDTPS');
                        let ri = 0, rn = 0, rl = 0;
                        if (ndtps > 0) {
                            ri = ni / 3 / ndtps;
                            rn = nn / 3 / ndtps;
                            rl = nl / 3 / ndtps;
                        }
                        let base;
                        if (ndtps <= 0) base = 0;
                        else if (ri >= A) base = 4;
                        else if (rn >= B) base = 3 + ri / A;
                        else if (ri > 0 && rn > 0) base = 2 + ri/A + rn/B - (ri*rn)/(A*B);
                        else if (ri > 0) base = 2 + ri / A;
                        else if (rn > 0) base = 2 + rn / B;
                        else if (rl >= C) base = 2;
                        else base = 1;
                        return { ni, nn, nl, ndtps, ri, rn, rl, base };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora53-table">
                    <tr><td style="width:120px"><strong>NDTPS</strong></td><td id="cv-ndtps53" class="fw-bold">-</td></tr>
                    <tr><td><strong>NI/NN/NL</strong></td><td id="cv-counts53" class="fw-bold">-</td></tr>
                    <tr><td><strong>RI</strong></td><td id="cv-ri53" class="fw-bold">-</td></tr>
                    <tr><td><strong>RN</strong></td><td id="cv-rn53" class="fw-bold">-</td></tr>
                    <tr><td><strong>RL</strong></td><td id="cv-rl53" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora53" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal53 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions53 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA53() {
                        const { ni, nn, nl, ndtps, ri, rn, rl, base } = hitungSkorA53();
                        document.getElementById('cv-ndtps53').textContent = ndtps > 0 ? ndtps : '-';
                        document.getElementById('cv-counts53').textContent = (ni+nn+nl > 0) ? ni+'/'+nn+'/'+nl : '-';
                        document.getElementById('cv-ri53').textContent = ri > 0 ? ri.toFixed(4) : (ndtps > 0 ? '0' : '-');
                        document.getElementById('cv-rn53').textContent = rn > 0 ? rn.toFixed(4) : (ndtps > 0 ? '0' : '-');
                        document.getElementById('cv-rl53').textContent = rl > 0 ? rl.toFixed(4) : (ndtps > 0 ? '0' : '-');
                        document.getElementById('cv-skora53').textContent = base > 0 ? base.toFixed(4) : '-';
                        return { base };
                    }

                    updateSkorA53();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Produktivitas Penelitian', 'skor_b',
                        skorBOptions53, skorB_awal53
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final53">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal53() {
                        const { base } = updateSkorA53();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (base > 0 && skorB > 0) ? ((3 * base + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final53');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${base.toFixed(4)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi NI, NN, NL, NDTPS dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = base;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal53);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal53);
                    });

                } else if (isElemen54) {
                    // Element 54: NPM/NPD → PPDM → Skor(a), radio Skor(b)
                    // Final: (3 × Skor(a) + Skor(b)) / 4
                    const v2id54 = {};
                    subItems.forEach(item => { v2id54[item.variabel] = item.id; });

                    function val54(v) {
                        const id = v2id54[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA54() {
                        const npm = val54('NPM'), npd = val54('NPD');
                        let ppdm = 0, base = 0;
                        if (npd > 0) {
                            ppdm = npm / npd; // decimal 0-1
                            if (ppdm >= 0.75) base = 4;
                            else base = Math.min(4, 2 + 8 * ppdm);
                        }
                        return { npm, npd, ppdm, base };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora54-table">
                    <tr><td style="width:120px"><strong>NPM/NPD</strong></td><td id="cv-npmnpd54" class="fw-bold">-</td></tr>
                    <tr><td><strong>PPDM</strong></td><td id="cv-ppdm54" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora54" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal54 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions54 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA54() {
                        const { npm, npd, ppdm, base } = hitungSkorA54();
                        document.getElementById('cv-npmnpd54').textContent = (npm > 0 || npd > 0) ? npm + ' / ' + npd : '-';
                        document.getElementById('cv-ppdm54').textContent = ppdm > 0 ? (ppdm * 100).toFixed(2) + '%' : (npd > 0 ? '0%' : '-');
                        document.getElementById('cv-skora54').textContent = base > 0 ? base.toFixed(4) : '-';
                        return { base };
                    }

                    updateSkorA54();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Pelibatan Mahasiswa', 'skor_b',
                        skorBOptions54, skorB_awal54
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final54">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal54() {
                        const { base } = updateSkorA54();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (base > 0 && skorB > 0) ? ((3 * base + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final54');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${base.toFixed(4)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi NPM, NPD dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = base;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal54);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal54);
                    });

                } else if (isElemen55) {
                    // Element 55: Publikasi Karya Ilmiah DTPS
                    const v2id55 = {};
                    subItems.forEach(item => { v2id55[item.variabel] = item.id; });

                    function val55(v) {
                        const id = v2id55[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    const A55 = 0.1, B55 = 1, C55 = 2;

                    function hitungSkorA55() {
                        const na1=val55('NA1'),na2=val55('NA2'),na3=val55('NA3'),na4=val55('NA4');
                        const nb1=val55('NB1'),nb2=val55('NB2'),nb3=val55('NB3');
                        const nc1=val55('NC1'),nc2=val55('NC2'),nc3=val55('NC3');
                        const ndtps = val55('NDTPS');
                        let ri=0, rn=0, rw=0;
                        if (ndtps > 0) {
                            rw = (na1 + nb1 + nc1) / ndtps;
                            rn = (na2 + na3 + nb2 + nc2) / ndtps;
                            ri = (na4 + nb3 + nc3) / ndtps;
                        }
                        let base;
                        if (ndtps <= 0) base = 0;
                        else if (ri >= A55) base = 4;
                        else if (rn >= B55) base = 3 + ri / A55;
                        else if (ri > 0 && rn > 0) base = 2 + ri/A55 + rn/B55 - (ri*rn)/(A55*B55);
                        else if (ri > 0) base = 2 + ri / A55;
                        else if (rn > 0) base = 2 + rn / B55;
                        else if (rw >= C55) base = 2;
                        else base = 1;
                        return { ri, rn, rw, ndtps, base };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora55-table">
                    <tr><td style="width:120px"><strong>NDTPS</strong></td><td id="cv-ndtps55" class="fw-bold">-</td></tr>
                    <tr><td><strong>RW</strong></td><td id="cv-rw55" class="fw-bold">-</td></tr>
                    <tr><td><strong>RN</strong></td><td id="cv-rn55" class="fw-bold">-</td></tr>
                    <tr><td><strong>RI</strong></td><td id="cv-ri55" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora55" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal55 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions55 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA55() {
                        const { ri, rn, rw, ndtps, base } = hitungSkorA55();
                        document.getElementById('cv-ndtps55').textContent = ndtps > 0 ? ndtps : '-';
                        document.getElementById('cv-rw55').textContent = ndtps > 0 ? rw.toFixed(4) : '-';
                        document.getElementById('cv-rn55').textContent = ndtps > 0 ? rn.toFixed(4) : '-';
                        document.getElementById('cv-ri55').textContent = ndtps > 0 ? ri.toFixed(4) : '-';
                        document.getElementById('cv-skora55').textContent = base > 0 ? base.toFixed(4) : '-';
                        return { base };
                    }

                    updateSkorA55();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Publikasi Ilmiah', 'skor_b',
                        skorBOptions55, skorB_awal55
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final55">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal55() {
                        const { base } = updateSkorA55();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (base > 0 && skorB > 0) ? ((3 * base + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final55');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${base.toFixed(4)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi NA1–NA4, NB1–NB3, NC1–NC3, NDTPS dan pilih Skor (b)';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = base;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal55);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal55);
                    });

                } else if (isElemen56) {
                    // Element 56: S4+S3+S2+S1+INT / NDTPS → PPDTPS → Skor(a), radio Skor(b)
                    const v2id56 = {};
                    subItems.forEach(item => { v2id56[item.variabel] = item.id; });

                    function val56(v) {
                        const id = v2id56[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA56() {
                        const s4 = val56('S4_DTPS'), s3 = val56('S3_DTPS'), s2 = val56('S2_DTPS'),
                              s1 = val56('S1_DTPS'), int = val56('INT_DTPS'), ndtps = val56('NDTPS');
                        const ndtps_pub = s4 + s3 + s2 + s1 + int;
                        let ppdtps = 0, base = 0;
                        if (ndtps > 0) {
                            ppdtps = ndtps_pub / ndtps;
                            if (ppdtps >= 0.20) base = 4;
                            else if (ppdtps >= 0.15) base = 3;
                            else if (ppdtps >= 0.10) base = 2;
                            else base = 1;
                        }
                        return { ndtps_pub, ndtps, ppdtps, base, s4, s3, s2, s1, int };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora56-table">
                    <tr><td style="width:120px"><strong>NDTPS_PUB</strong></td><td id="cv-ndpub56" class="fw-bold">- <small class="text-muted">(S4+S3+S2+S1+INT)</small></td></tr>
                    <tr><td><strong>NDTPS</strong></td><td id="cv-ndtps56" class="fw-bold">-</td></tr>
                    <tr><td><strong>PPDTPS</strong></td><td id="cv-ppdtps56" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora56" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal56 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions56 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA56() {
                        const { ndtps_pub, ndtps, ppdtps, base } = hitungSkorA56();
                        document.getElementById('cv-ndpub56').innerHTML = ndtps_pub > 0 ? ndtps_pub + ' <small class="text-muted">(S4+S3+S2+S1+INT)</small>' : '0';
                        document.getElementById('cv-ndtps56').textContent = ndtps > 0 ? ndtps : '-';
                        document.getElementById('cv-ppdtps56').textContent = ndtps > 0 ? (ppdtps * 100).toFixed(2) + '%' : '-';
                        document.getElementById('cv-skora56').textContent = base > 0 ? base : (ndtps > 0 ? '1' : '-');
                        return { base };
                    }

                    updateSkorA56();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Publikasi DTPS', 'skor_b',
                        skorBOptions56, skorB_awal56
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final56">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal56() {
                        const { base } = updateSkorA56();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (base > 0 && skorB > 0) ? ((3 * base + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final56');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${base}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi S4, S3, S2, S1, INT, NDTPS dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = base;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal56);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal56);
                    });

                } else if (isElemen57) {
                    // Element 57: NAS/NDTPS → RSA → Skor(a), radio Skor(b)
                    const v2id57 = {};
                    subItems.forEach(item => { v2id57[item.variabel] = item.id; });

                    function val57(v) {
                        const id = v2id57[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA57() {
                        const nas = val57('NAS'), ndtps = val57('NDTPS');
                        let rsa = 0, base = 0;
                        if (ndtps > 0) {
                            rsa = nas / ndtps;
                            if (rsa >= 9) base = 4;
                            else if (rsa >= 6) base = 3;
                            else if (rsa >= 3) base = 2;
                            else base = 1;
                        }
                        return { nas, ndtps, rsa, base };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora57-table">
                    <tr><td style="width:120px"><strong>NAS/NDTPS</strong></td><td id="cv-ras57" class="fw-bold">-</td></tr>
                    <tr><td><strong>RSA</strong></td><td id="cv-rsa57" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora57" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal57 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions57 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA57() {
                        const { nas, ndtps, rsa, base } = hitungSkorA57();
                        document.getElementById('cv-ras57').textContent = (nas > 0 || ndtps > 0) ? nas + ' / ' + ndtps : '-';
                        document.getElementById('cv-rsa57').textContent = rsa > 0 ? rsa.toFixed(4) : (ndtps > 0 ? '0' : '-');
                        document.getElementById('cv-skora57').textContent = base > 0 ? base : (ndtps > 0 ? '1' : '-');
                        return { base };
                    }

                    updateSkorA57();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Sitasi Artikel', 'skor_b',
                        skorBOptions57, skorB_awal57
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final57">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal57() {
                        const { base } = updateSkorA57();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (base > 0 && skorB > 0) ? ((3 * base + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final57');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${base}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi NAS, NDTPS dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = base;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal57);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal57);
                    });

                } else if (isElemen59) {
                    // Element 59: Produktivitas PkM DTPS (NI/NN/NL/NDTPS → RI/RN/RL → Skor(a))
                    const A59 = 0.05, B59 = 0.3, C59 = 1;
                    const v2id59 = {};
                    subItems.forEach(item => { v2id59[item.variabel] = item.id; });

                    function val59(v) {
                        const id = v2id59[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA59() {
                        const ni = val59('NI'), nn = val59('NN'), nl = val59('NL'), ndtps = val59('NDTPS');
                        let ri = 0, rn = 0, rl = 0, base = 0;
                        if (ndtps > 0) {
                            ri = ni / 3 / ndtps;
                            rn = nn / 3 / ndtps;
                            rl = nl / 3 / ndtps;
                            if (ri >= A59) base = 4;
                            else if (rn >= B59) base = 3 + ri / A59;
                            else if (ri > 0 && rn > 0) base = 2 + ri/A59 + rn/B59 - (ri*rn)/(A59*B59);
                            else if (ri > 0) base = 2 + ri / A59;
                            else if (rn > 0) base = 2 + rn / B59;
                            else if (rl >= C59) base = 2;
                            else base = 1;
                        }
                        return { ri, rn, rl, ndtps, base };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora59-table">
                    <tr><td style="width:120px"><strong>NDTPS</strong></td><td id="cv-ndtps59" class="fw-bold">-</td></tr>
                    <tr><td><strong>RL</strong></td><td id="cv-rl59" class="fw-bold">-</td></tr>
                    <tr><td><strong>RN</strong></td><td id="cv-rn59" class="fw-bold">-</td></tr>
                    <tr><td><strong>RI</strong></td><td id="cv-ri59" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora59" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal59 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions59 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA59() {
                        const { ri, rn, rl, ndtps, base } = hitungSkorA59();
                        document.getElementById('cv-ndtps59').textContent = ndtps > 0 ? ndtps : '-';
                        document.getElementById('cv-rl59').textContent = ndtps > 0 ? rl.toFixed(4) : '-';
                        document.getElementById('cv-rn59').textContent = ndtps > 0 ? rn.toFixed(4) : '-';
                        document.getElementById('cv-ri59').textContent = ndtps > 0 ? ri.toFixed(4) : '-';
                        document.getElementById('cv-skora59').textContent = base > 0 ? base.toFixed(4) : (ndtps > 0 ? '1' : '-');
                        return { base };
                    }

                    updateSkorA59();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Produktivitas PkM', 'skor_b',
                        skorBOptions59, skorB_awal59
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final59">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal59() {
                        const { base } = updateSkorA59();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (base > 0 && skorB > 0) ? ((3 * base + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final59');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${base.toFixed(4)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi NI, NN, NL, NDTPS dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = base;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal59);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal59);
                    });

                } else if (isElemen60) {
                    // Element 60: NPkM/NPkDTPS → PPkDM → Skor(a), radio Skor(b)
                    const v2id60 = {};
                    subItems.forEach(item => { v2id60[item.variabel] = item.id; });

                    function val60(v) {
                        const id = v2id60[v];
                        if (!id) return 0;
                        const el = document.querySelector(`input[name="variabel[${id}]"]`);
                        if (el) return parseFloat(el.value) || 0;
                        const saved = userSubItemMap[id];
                        return saved ? parseFloat(saved.nilai) || 0 : 0;
                    }

                    function hitungSkorA60() {
                        const npkm = val60('NPkM'), npkdtps = val60('NPkDTPS');
                        let ppkdm = 0, base = 0;
                        if (npkdtps > 0) {
                            ppkdm = npkm / npkdtps;
                            if (ppkdm >= 0.75) base = 4;
                            else base = Math.min(4, 2 + 8 * ppkdm);
                        }
                        return { npkm, npkdtps, ppkdm, base };
                    }

                    container.insertAdjacentHTML('beforeend', `
                <table class="table table-sm table-bordered mt-2 mb-0 bg-light" id="auto-skora60-table">
                    <tr><td style="width:120px"><strong>NPkM/NPkDTPS</strong></td><td id="cv-ratio60" class="fw-bold">-</td></tr>
                    <tr><td><strong>PPkDM</strong></td><td id="cv-ppkdm60" class="fw-bold">-</td></tr>
                    <tr class="table-primary"><td><strong>Skor (a)</strong></td><td id="cv-skora60" class="fw-bold">-</td></tr>
                </table>`);

                    const skorB_awal60 = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;
                    const skorBOptions60 = (pilihan && pilihan.options) ? pilihan.options : {};

                    function updateSkorA60() {
                        const { npkm, npkdtps, ppkdm, base } = hitungSkorA60();
                        document.getElementById('cv-ratio60').textContent = (npkm > 0 || npkdtps > 0) ? npkm + ' / ' + npkdtps : '-';
                        document.getElementById('cv-ppkdm60').textContent = ppkdm > 0 ? (ppkdm * 100).toFixed(2) + '%' : (npkdtps > 0 ? '0%' : '-');
                        document.getElementById('cv-skora60').textContent = base > 0 ? base.toFixed(4) : '-';
                        return { base };
                    }

                    updateSkorA60();

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor (b) — Analisis Pelibatan Mahasiswa PkM', 'skor_b',
                        skorBOptions60, skorB_awal60
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-final60">
                        Belum lengkap
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="0">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="0">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeFinal60() {
                        const { base } = updateSkorA60();
                        const skorB = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (base > 0 && skorB > 0) ? ((3 * base + skorB) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-final60');
                        if (jawabanAkhir > 0) {
                            live.innerHTML = `Skor(a): <strong>${base.toFixed(4)}</strong> | Skor(b): <strong>${skorB}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(4)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(4)}</strong>`;
                        } else {
                            live.innerHTML = 'Isi NPkM, NPkDTPS dan pilih Skor (b) untuk hasil akhir';
                        }
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        document.getElementById('skor_a_hidden').value = base;
                        document.getElementById('skor_b_hidden').value = skorB;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.variabel-input').forEach(el => {
                        el.addEventListener('input', computeFinal60);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeFinal60);
                    });

                } else if (isDualRadio) {
                    // Dual radio (element 10-like): two radio groups, final = (3*A + B)/4
                    var skor_a_awal = btn.dataset.skor_a ? parseInt(btn.dataset.skor_a) : 0;
                    var skor_b_awal = btn.dataset.skor_b ? parseInt(btn.dataset.skor_b) : 0;

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        pilihan[0].label || 'Skor (a)', 'skor_a',
                        pilihan[0].options, skor_a_awal
                    ));

                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        pilihan[1].label || 'Skor (b)', 'skor_b',
                        pilihan[1].options, skor_b_awal
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-2">
                    <span class="badge bg-success" id="live-dual">
                        Belum dipilih
                    </span>
                </div>`);

                    container.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="skor_a" id="skor_a_hidden" value="${skor_a_awal}">
                <input type="hidden" name="skor_b" id="skor_b_hidden" value="${skor_b_awal}">
                <input type="hidden" name="jawaban" id="jawaban_hidden" value="${jawaban}">`);

                    function computeDual() {
                        const sa = parseInt(document.querySelector('input[name="skor_a"]:checked')?.value || 0);
                        const sb = parseInt(document.querySelector('input[name="skor_b"]:checked')?.value || 0);
                        const jawabanAkhir = (sa && sb) ? ((3 * sa + sb) / 4) : 0;
                        const nilaiAkhir = jawabanAkhir * poin;

                        const live = document.getElementById('live-dual');
                        if (sa && sb) {
                            live.innerHTML = `Skor(a): <strong>${sa}</strong> | Skor(b): <strong>${sb}</strong> | Akhir: <strong>${jawabanAkhir.toFixed(2)}</strong> | Nilai: <strong>${nilaiAkhir.toFixed(2)}</strong>`;
                        } else if (sa) {
                            live.innerHTML = `Skor(a): <strong>${sa}</strong> — pilih juga Skor(b)`;
                        } else if (sb) {
                            live.innerHTML = `Skor(b): <strong>${sb}</strong> — pilih juga Skor(a)`;
                        } else {
                            live.innerHTML = 'Belum dipilih';
                        }

                        document.getElementById('skor_a_hidden').value = sa;
                        document.getElementById('skor_b_hidden').value = sb;
                        document.getElementById('jawaban_hidden').value = jawabanAkhir;
                        const nt = document.getElementById('nilai_total');
                        if (nt) nt.value = nilaiAkhir;
                    }

                    document.querySelectorAll('.skor-radio-skor_a').forEach(el => {
                        el.addEventListener('change', computeDual);
                    });
                    document.querySelectorAll('.skor-radio-skor_b').forEach(el => {
                        el.addEventListener('change', computeDual);
                    });

                    setTimeout(computeDual, 50);

                } else {
                    // Single radio group (original behavior)
                    container.insertAdjacentHTML('beforeend', renderRadioGroup(
                        'Pilih Skor', 'jawaban', pilihanFinal, parseInt(jawaban)
                    ));

                    container.insertAdjacentHTML('beforeend', `
                <div class="mt-3">
                    <span class="badge bg-primary" id="live-skor">
                        Belum dipilih
                    </span>
                </div>`);

                    const liveSkor = container.querySelector('#live-skor');

                    document.querySelectorAll('.skor-radio-jawaban').forEach(radio => {
                        if (radio.checked) {
                            let hasil = parseFloat(radio.value) * parseFloat(poin);
                            liveSkor.innerHTML = `Skor dipilih: <strong>${radio.value}</strong> | Nilai: <strong>${hasil}</strong>`;
                        }
                        radio.addEventListener('change', function() {
                            let hasil = parseFloat(this.value) * parseFloat(poin);
                            liveSkor.innerHTML = `Skor dipilih: <strong>${this.value}</strong> | Nilai: <strong>${hasil}</strong>`;
                            document.getElementById('nilai_total').value = hasil;
                        });
                    });
                }

                // =======================
                // 🔥 BUKTI + FIELD LAIN
                // =======================
                container.insertAdjacentHTML('beforeend', `

    <div class="mb-3 mt-3">
        <label class="form-label"><strong>Link Bukti</strong></label>
        <div class="input-group">
            <input type="url" class="form-control" name="link_bukti"
                value="${link_bukti}" placeholder="Masukkan link">

            ${link_bukti ? `<a href="${link_bukti}" target="_blank" class="btn btn-outline-primary">↗</a>` : ''}
        </div>
    </div>

    ${isFakultas ? `
    <div class="mb-3">
        <label for="temuan" class="form-label"><strong>Temuan (Opsional)</strong></label>
        <textarea class="form-control" id="temuan" name="temuan" rows="3" placeholder="Masukkan temuan">${temuan}</textarea>
    </div>

    <div class="mb-3">
        <label for="saran" class="form-label"><strong>Saran (Opsional)</strong></label>
        <textarea class="form-control" id="saran" name="saran" rows="3" placeholder="Masukkan saran">${saran}</textarea>
    </div>
    ` : ''}

    <input type="hidden" name="nilai_total" id="nilai_total" value="${nilai_total}">
    <input type="hidden" name="id_matriks_led" id="id_matriks_led" value="${id_matriks_led}">
    <input type="hidden" name="kepemilikan_kriteria" value="{{ $for }}">
    <input type="hidden" name="id_users" value="{{ auth()->user()->id }}">
    <input type="hidden" name="id_user_jurusan" value="{{ $userJurusan->id }}">
    <input type="hidden" name="tahun" value="{{ $tahun }}">

    ${window.isAMISubmitted ? '' : '<button type="submit" class="btn btn-sm btn-success">Simpan</button>'}
`);

            if (window.isAMISubmitted) {
                container.querySelectorAll('input, textarea, select, button').forEach(el => {
                    el.disabled = true;
                });
            }

                document.getElementById("id_matriks_led").value = id_matriks_led;

                // Initial compute for dual-score items (must run AFTER common section)
                if (isElemen7) computeFinal7();
                else if (isElemen11) computeFinal11();
                else if (isElemen14) computeFinal14();
                else if (isElemen15) computeFinal15();
                else if (isElemen16) computeFinal16();
                else if (isElemen19) computeFinal19();
                else if (isElemen20) computeFinal20();
                else if (isElemen21) computeFinal21();
                else if (isElemen22) computeFinal22();
                else if (isElemen23) computeFinal23();
                else if (isElemen33) computeFinal33();
                else if (isElemen40) computeFinal40();
                else if (isElemen41) computeFinal41();
                else if (isElemen42) computeFinal42();
                else if (isElemen43) computeFinal43();
                else if (isElemen45) computeFinal45();
                else if (isElemen46) computeFinal46();
                else if (isElemen47) computeFinal47();
                else if (isElemen48) computeFinal48();
                else if (isElemen53) computeFinal53();
                else if (isElemen54) computeFinal54();
                else if (isElemen55) computeFinal55();
                else if (isElemen56) computeFinal56();
                else if (isElemen57) computeFinal57();
                else if (isElemen59) computeFinal59();
                else if (isElemen60) computeFinal60();
                else if (isDualRadio) computeDual();

                // Auto-save on form changes (debounced) — register once
                if (!container._autoSaveRegistered) {
                    container._autoSaveRegistered = true;
                    let saveTimer;
                    container.addEventListener('change', () => {
                        clearTimeout(saveTimer);
                        saveTimer = setTimeout(saveCurrentForm, 600);
                    });
                    container.addEventListener('input', () => {
                        clearTimeout(saveTimer);
                        saveTimer = setTimeout(saveCurrentForm, 600);
                    });
                }


            });
        });
    </script>

    {{-- Active state --}}
    <script>
        document.querySelectorAll(".nav-item-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                document.querySelectorAll(".nav-item-btn").forEach(item => {
                    item.classList.remove("active");
                });
                btn.classList.add("active");
                localStorage.setItem('lastElement', btn.dataset.id);
            });
        });
    </script>

    <script>
        window.addEventListener("load", function() {
            const overlay = document.getElementById('loading-overlay');

            overlay.classList.add('fade-out');
            setTimeout(() => overlay.remove(), 600);

            const last = localStorage.getItem('lastElement');
            const selector = last ? '[data-id="' + last + '"]' : '.nav-item-btn';

            const btnToClick = document.querySelector(selector);

            if (btnToClick) {
                btnToClick.click();
                btnToClick.scrollIntoView({
                    behavior: "auto",
                    block: "center"
                });
            }
        });
    </script>

    {{-- Search --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("search-elemen");
            const container = document.getElementById("nav-container");

            searchInput.addEventListener("input", function() {
                const keyword = this.value.toLowerCase().trim();
                const buttons = container.querySelectorAll(".nav-item-btn");

                if (keyword === "") return;

                let firstMatch = null;

                buttons.forEach(btn => {
                    const text = (btn.innerText + ' ' + (btn.title || '')).toLowerCase();

                    if (text.includes(keyword)) {
                        if (!firstMatch) firstMatch = btn;
                        btn.classList.add("search-match");
                    } else {
                        btn.classList.remove("search-match");
                    }
                });

                if (firstMatch) {
                    firstMatch.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });
                }
            });
        });
    </script>

    {{-- Filter --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.getElementById('filterColor').addEventListener('change', function() {
                let filter = this.value;

                document.querySelectorAll('.nav-item-btn').forEach(btn => {
                    let color = btn.dataset.color;

                    if (filter === "" || filter === color) {
                        btn.style.display = "flex";
                    } else {
                        btn.style.display = "none";
                    }
                });

            });

        });
    </script>

    {{-- Prev/Next --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('btnPrev').addEventListener('click', function() {
                const buttons = document.querySelectorAll('.nav-item-btn');
                let activeIdx = -1;
                buttons.forEach((btn, i) => {
                    if (btn.classList.contains('active')) activeIdx = i;
                });
                if (activeIdx > 0) {
                    buttons[activeIdx - 1].click();
                    buttons[activeIdx - 1].scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });

            document.getElementById('btnNext').addEventListener('click', function() {
                const buttons = document.querySelectorAll('.nav-item-btn');
                let activeIdx = -1;
                buttons.forEach((btn, i) => {
                    if (btn.classList.contains('active')) activeIdx = i;
                });
                if (activeIdx >= 0 && activeIdx < buttons.length - 1) {
                    buttons[activeIdx + 1].click();
                    buttons[activeIdx + 1].scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        });
    </script>

    @endif

@endsection
