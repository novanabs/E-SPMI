@extends('layouts.app')

@section('title', 'Evaluasi Diri ' . (auth()->user()->homebase ?? ''))

@section('content')


    <style>
        .harkat_penskoran {
            white-space: pre-wrap;
            /* pertahankan enter dan spasi */
            overflow-wrap: break-word;
            /* pecah kata panjang agar tidak overflow */
            word-break: break-word;
            /* pastikan tidak keluar layar */
            tab-size: 4;
            /* agar indent tab rapi */
            font-family: inherit;
            /* gunakan font yang sama dengan dokumen/tema kamu */
        }


        .nav-item-btn.active {
            background-color: #0d6efd33;

            /* biru muda transparan */
            border-left: 4px solid #0d6efd;
            font-weight: bold;
            color: #061f47 !important;
            /* warna teks biru */
        }

        /* HIJAU */
        .nav-item-btn.active.border-green {
            border-left: 4px solid #28a745;
            background-color: #28a74522;
            /* hijau muda transparan */
            color: #0d3b1d !important;
        }

        /* KUNING */
        .nav-item-btn.active.border-yellow {
            border-left: 4px solid #ffc107;
            background-color: #ffc10722;
            /* kuning muda transparan */
            color: #5c4800 !important;
        }

        /* MERAH */
        .nav-item-btn.active.border-red {
            border-left: 4px solid #dc3545;
            background-color: #dc354522;
            /* merah muda transparan */
            color: #4a0008 !important;
        }



        /* Loading */

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
            100% {
                transform: rotate(360deg);
            }
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

        /* Perbaiki bug accordion di AdminLTE */
        .accordion-button:not(.collapsed) {
            pointer-events: auto !important;
        }

        .container {
            max-width: 100% !important;
            padding-left: 10 !important;
            padding-right: 10 !important;
        }
    </style>

    @php
        $user = auth()->user();
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
        <!-- Kiri: col-9 berisi dua row -->
        <div class="col-md-9 d-flex flex-column">

            <div class="mb-3">
                <div class="card shadow-sm">
                    <div class="card-body py-2">

                        <div class="row">

                            <div class="card-header">
                                <h4 id="content-title" class="mb-0">Pilih Navigasi di Sebelah Kanan</h4>
                            </div>
                            <div class="card-body">
                                <p class="fw-bold">Bobot : <span id="content-poin"></span></p>
                                <span id="content-body"></span>
                                <form id="kriteriaForm" action="{{ route('evaluasi_lamdik.store') }}" method="POST">
                                </form>
                            </div>

                        </div>

                    </div>



                </div>
            </div>


            <!-- Row kedua di kiri -->
            <div class="card shadow-sm">

                <div class="card-header py-2 d-flex justify-content-between">
                    {{-- <h5 class="mb-0">Hasil Akreditasi {{ $syarat3 }}
                            {{ $syarat5 }}</h5> --}}
                    <h5 class="mb-0">Hasil Akreditasi</h5>
                    <button class="btn btn-sm btn-primary ms-auto" onclick="previewPdf()">
                        Export PDF
                    </button>
                </div>

                <div class="row mt-3">
                    <!-- KIRI: RADAR CHART -->
                    <div class="col-md-6">
                        <canvas id="radarChart"></canvas>
                    </div>

                    <!-- KANAN: HASIL -->
                    <div class="col-md-6 d-flex flex-column">

                        <div class="d-flex">
                            <p class="mb-1 me-2">Nilai Akreditasi:</p>
                            <p class="mb-1 fw-bold" id="total_nilai_semua"></p>
                        </div>

                        <div class="d-flex">
                            <p class="mb-1 me-2">Status Akreditasi:</p>
                            <p class="mb-1 fw-bold" id="status"></p>
                        </div>

                        <div class="d-flex">
                            <p class="mb-0 me-2">Masa Berlaku:</p>
                            <p class="mb-0 fw-bold" id="masa"></p>
                        </div>

                        @if (auth()->user()->role == 'admin_jurusan')
                            <a class="btn btn-primary btn-sm mt-3 mb-3"
                                href="{{ route('evaluasi_lamdik.show', auth()->user()->id) }}">
                                Bandingkan
                            </a>
                        @endif

                        @php
                            $currentKriteria1 = null;
                            $nomorKriteria = 0;
                            $peraspek = [];
                            $aktual = [];
                        @endphp

                        <div>
                            Aspek
                        </div>

                        @php
                            $peraspek = [];
                            $aktual = [];

                            foreach ($data as $item) {
                                $namaAspek = $item->kriteria->name;
                                $nilai_aktual = $item->userMatrik->nilai_total ?? 0;

                                if (!isset($peraspek[$namaAspek])) {
                                    $peraspek[$namaAspek] = 0;
                                    $aktual[$namaAspek] = 0;
                                }

                                $peraspek[$namaAspek] += $item->poin * 4;
                                $aktual[$namaAspek] += $nilai_aktual;
                            }
                        @endphp



                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Aspek</th>
                                    <th>Nilai Aktual</th>
                                    <th>Nilai Maks</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp

                                @foreach ($peraspek as $aspek => $nilaiMaks)
                                    @php
                                        $nilaiAkt = $aktual[$aspek] ?? 0;
                                        $persen = $nilaiMaks > 0 ? ($nilaiAkt / $nilaiMaks) * 100 : 0;

                                        $warna = 'text-danger'; // default merah

                                        if ($persen >= 80) {
                                            $warna = 'text-success';
                                        } elseif ($persen >= 60) {
                                            $warna = 'text-warning';
                                        }
                                    @endphp

                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td class="text-start">{{ $aspek }}</td>
                                        <td>{{ $nilaiAkt }}</td>
                                        <td>{{ $nilaiMaks }}</td>

                                        <td>
                                            <span class="fw-bold {{ $warna }}">
                                                {{ number_format($persen, 2) }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>



                <script>
                    // Ambil data dari Laravel
                    const maxData = @json($peraspek);
                    const actualData = @json($aktual);

                    const labels = [
                        'Aspek 1',
                        'Aspek 2',
                        'Aspek 3',
                        'Aspek 4',
                        'Aspek 5',
                        'Aspek 6',
                        'Aspek 7',
                        'Aspek 8',
                        'Aspek 9'
                    ];

                    // Ambil urutan data dari object Laravel
                    const keys = Object.keys(maxData);

                    // Hitung persentase
                    const dataValues = keys.map(key => {
                        const max = maxData[key] ?? 0;
                        const actual = actualData[key] ?? 0;

                        if (max === 0) return 0;
                        return (actual / max) * 100;
                    });

                    // Hitung rata-rata
                    const total = dataValues.length ?
                        dataValues.reduce((a, b) => a + b, 0) / dataValues.length :
                        0;

                    // // Tentukan status & peringkat
                    // let status = '';
                    // let peringkat = '';

                    // if (total >= 85) {
                    //     status = 'Sangat Baik';
                    //     peringkat = 'A';
                    // } else if (total >= 70) {
                    //     status = 'Baik';
                    //     peringkat = 'B';
                    // } else {
                    //     status = 'Cukup';
                    //     peringkat = 'C';
                    // }

                    // // Tampilkan ke HTML
                    // document.getElementById('total_nilai_semua').innerText = total.toFixed(2);
                    // document.getElementById('status').innerText = status;
                    // document.getElementById('peringkat').innerText = peringkat;

                    // Chart
                    const data = {
                        labels: labels,
                        datasets: [{
                            label: 'Capaian (%)',
                            data: dataValues,
                            fill: true,
                        }]
                    };

                    const config = {
                        type: 'radar',
                        data: data,
                        options: {
                            responsive: true,
                            scales: {
                                r: {
                                    min: 0,
                                    max: 100
                                }
                            }
                        }
                    };

                    new Chart(
                        document.getElementById('radarChart'),
                        config
                    );
                </script>
            </div>

        </div>

        <!-- Kanan: col 3 dengan tinggi penuh -->
        <div class="col-md-3">
            <label for="search-elemen" class="form-label fw-bold">Cari Elemen</label>
            <input type="text" id="search-elemen" class="form-control mb-3" placeholder="Ketik nama elemen...">

            <label for="filterColor" class="form-label fw-bold">Filter Warna</label>
            <select id="filterColor" class="form-select mb-3">
                <option value="">Semua</option>
                <option value="green">Hijau</option>
                <option value="yellow">Kuning</option>
                <option value="red">Merah</option>
                <option value="none">Belum Terisi</option>
            </select>

            <p class="fw-bold mb-1">
                Keterangan Warna
            </p>

            <div class="d-flex align-items-center mb-1">
                <div style="width: 15px; height: 15px; background:#28a745; border-radius:3px;" class="me-2"></div>
                <span>Skor <strong>4</strong> (Baik)</span>
            </div>

            <div class="d-flex align-items-center mb-1">
                <div style="width: 15px; height: 15px; background:#ffc107; border-radius:3px;" class="me-2"></div>
                <span>Skor <strong>3–2</strong> (Cukup)</span>
            </div>

            <div class="d-flex align-items-center">
                <div style="width: 15px; height: 15px; background:#dc3545; border-radius:3px;" class="me-2"></div>
                <span>Skor <strong>1</strong> (Kurang)</span>
            </div>

            {{-- Tombol navigasi next prev --}}
            <div class="card shadow-sm mb-3 mt-3 p-2">
                <div class="d-flex justify-content-between gap-2">
                    <button id="btnPrev" class="btn btn-secondary w-50"><i class="bi bi-chevron-double-left"></i></button>
                    <button id="btnNext" class="btn btn-secondary w-50"><i
                            class="bi bi-chevron-double-right"></i></button>
                </div>
            </div>

            <div class="card shadow-sm mb-3 mt-3" style="max-height: 50vh; overflow-y: auto;">
                <div class="card-header bg-primary text-white">
                    <strong>Navigasi Elemen</strong>
                </div>
                <div class="list-group list-group-flush" id="nav-container">

                    @php
                        $currentKriteria = null;
                    @endphp

                    @foreach ($data as $item)
                        {{-- Jika kriteria berubah, tampilkan header --}}
                        @if ($currentKriteria !== $item->kriteria->name)
                            @php
                                $currentKriteria = $item->kriteria->name;
                            @endphp

                            <div class="list-group-item bg-secondary text-white fw-bold">
                                {{ $currentKriteria }}
                            </div>
                        @endif

                        {{-- Atur warna navigasi --}}
                        @php
                            $jawaban = $item->userMatrik->jawaban ?? null;

                            // Background color
                            $color = match (true) {
                                $jawaban == 4 => 'list-group-item-success',
                                $jawaban < 4 && $jawaban > 1 => 'list-group-item-warning',
                                $jawaban == 1 => 'list-group-item-danger',
                                default => '',
                            };

                            // Border color
                            $borderClass = match (true) {
                                $jawaban == 4 => 'border-green',
                                $jawaban < 4 && $jawaban > 1 => 'border-yellow',
                                $jawaban == 1 => 'border-red',
                                default => 'border-none',
                            };
                        @endphp


                        {{-- Tombol navigasi --}}
                        <button
                            class="list-group-item list-group-item-action nav-item-btn border-none {{ $color }} {{ $borderClass }}"
                            data-id="{{ $item->id }}" data-title="{{ $item->nomor }}. {{ $item->elemen }}"
                            data-content="{{ $item->indikator }}" data-pilihan='@json($item->option_pilihan_ganda)'
                            data-poin="{{ $item->poin }}" data-harkat_penskoran="{{ $item->harkat_penskoran }}"
                            data-jenis="{{ $item->jenis }}" {{-- Ini data dari users matrik --}}
                            data-link_bukti="{{ $item->userMatrik->link_bukti ?? '' }}"
                            data-temuan="{{ $item->userMatrik->temuan ?? '' }}"
                            data-saran="{{ $item->userMatrik->saran ?? '' }}"
                            data-jawaban="{{ $item->userMatrik->jawaban ?? 0 }}"
                            data-color="{{ $jawaban == 4 ? 'green' : ($jawaban < 4 && $jawaban > 1 ? 'yellow' : ($jawaban == 1 ? 'red' : 'none')) }}"
                            data-nilai_total="{{ $item->userMatrik->nilai_total ?? 0 }}" {{-- Ambil data sub item --}}
                            data-subitem="{{ $item->subItemElemen }}"
                            data-usersubitems="{{ $item->userSubItemElements }}">

                            <span class="me-2" style="width: 30px;">{{ $item->nomor }}.</span>
                            <span>{{ $item->elemen }} ({{ $item->poin }}) => (Skor:
                                {{ $item->userMatrik->jawaban ?? 0 }},Total:
                                {{ $item->userMatrik->nilai_total ?? 0 }})</span>
                        </button>
                    @endforeach



                    <!-- Anda dapat mengulangi header kriteria + elemen sesuai kebutuhan -->
                </div>
            </div>




        </div>
    </div>

    <div class="modal fade" id="previewPdfModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Preview Laporan Evaluasi Diri {{ auth()->user()->homebase ?? '' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="previewPdfContent">
                    <div class="text-center text-muted">
                        Memuat preview...
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ url('/export/export-pdf') }}" target="_blank" class="btn btn-primary">
                        Export
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function previewPdf() {
            const modal = new bootstrap.Modal(document.getElementById('previewPdfModal'));
            const content = document.getElementById('previewPdfContent');
            // console.log('CONTENT:', content);
            modal.show();

            content.innerHTML = '<div class="text-center text-muted">Memuat preview...</div>';

            fetch('/export/preview')
                .then(res => res.text())
                .then(html => {
                    // console.log(html);
                    content.innerHTML = html;
                })
                .catch(() => {
                    content.innerHTML = '<div class="text-danger">Gagal memuat preview</div>';
                });


        }
    </script>

    {{-- Ini untuk syarat unggul --}}
    <script>
        let syarat3 = {{ $syarat3 ? 'true' : 'false' }};
        let syarat5 = {{ $syarat5 ? 'true' : 'false' }};
    </script>

    {{-- Hitung Akreditasi --}}
    {{-- <script>
        function hitungAkreditasi(NA) {
            let status = "";
            let peringkat = "";

            if (NA >= 361) {
                status = "Terakreditasi";
                peringkat = "Unggul";
            } else if (NA >= 301 && NA < 361) {
                status = "Terakreditasi";
                peringkat = "Baik Sekali";
            } else if (NA >= 200 && NA < 301) {
                status = "Terakreditasi";
                peringkat = "Baik";
            } else if (NA < 200) {
                status = "Tidak Terakreditasi";
                peringkat = "-";
            }

            return {
                status,
                peringkat
            };
        }
    </script> --}}

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

            } else if (NA >= 321 && NA < 361) {

                if (syarat3) {
                    status = "Terakreditasi Unggul";
                    masa = "3 Tahun";
                } else {
                    status = "Terakreditasi";
                    masa = "5 Tahun";
                }

            } else if (NA >= 200 && NA < 321) {

                status = "Terakreditasi";
                masa = "5 Tahun";

            } else {

                status = "Tidak Terakreditasi";
                masa = "-";
            }

            return {
                status,
                masa
            };
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let total = 0;

            // Ini data total mengambil dari button
            document.querySelectorAll(".nav-item-btn").forEach(btn => {
                let nilai_total_users_matriks = parseFloat(btn.dataset.nilai_total);
                total += nilai_total_users_matriks;
                // console.log(total);
            });

            document.getElementById("total_nilai_semua").innerText = total;

            let hasil = hitungAkreditasi(total, syarat3, syarat5);

            document.getElementById("status").innerText = hasil.status;
            document.getElementById("masa").innerText = hasil.masa;
        });
    </script>

    <script></script>

    <script>
        document.querySelectorAll(".nav-item-btn").forEach(btn => {
            btn.addEventListener("click", () => {

                localStorage.setItem('lastElement', btn.dataset.id);
                // console.log('ID tersimpan:', btn.dataset.id);
                console.log('Isi btn:', btn.dataset);

                // --- Isi konten utama ---
                var poin = parseFloat(btn.dataset.poin);
                // var kepemilikan_kriteria = document.getElementById('kepemilikan_kriteria').value;
                document.getElementById("content-title").innerText = btn.dataset.title;
                document.getElementById("content-body").innerText = btn.dataset.content;
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
                container.innerHTML = `
    @csrf
    <div class="mt-3 mb-3">
        <label class="form-label"><strong>Harkat Penskoran</strong></label>
    </div>
`;

                // HARKAT
                container.insertAdjacentHTML(
                    'beforeend',
                    `<pre class='harkat_penskoran'>${harkat_penskoran ?? '-'}</pre>`
                );

                // =======================
                // 🔥 SUB ITEM (VARIABEL)
                // =======================
                if (subItems && subItems.length > 0) {
                    subItems.forEach(item => {
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
                >
            </div>
        `);
                    });
                }

                // =======================
                // 🔥 PILIHAN SKOR (RADIO)
                // =======================
                container.insertAdjacentHTML('beforeend', `
    <div class="mb-3 mt-3">
        <label class="form-label"><strong>Pilih Skor</strong></label>
    </div>
`);

                let pilihanFinal = pilihan && Object.keys(pilihan).length > 0 ?
                    pilihan : {
                        1: "",
                        2: "",
                        3: "",
                        4: ""
                    }; // default kalau kosong

                Object.keys(pilihanFinal)
                    .sort((a, b) => b - a)
                    .forEach(skor => {

                        let id = "kriteria_" + skor;
                        let isChecked = (parseInt(jawaban) === parseInt(skor)) ? "checked" : "";

                        container.insertAdjacentHTML('beforeend', `
            <div class="form-check">
                <input class="form-check-input skor-radio"
                       type="radio"
                       name="jawaban"
                       value="${skor}"
                       id="${id}"
                       ${isChecked}>
                <label class="form-check-label" for="${id}">
                    <strong>Skor ${skor}</strong> ${pilihanFinal[skor] ?? ''}
                </label>
            </div>
        `);
                    });

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

    <input type="hidden" name="nilai_total" id="nilai_total" value="${nilai_total}">
    <input type="hidden" name="id_matriks_led" id="id_matriks_led" value="${id_matriks_led}">
    <input type="hidden" name="kepemilikan_kriteria" value="{{ $for }}">
    <input type="hidden" name="id_users" value="{{ auth()->user()->id }}">

    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
`);

                // =======================
                // 🔥 HITUNG NILAI TOTAL
                // =======================
                document.querySelectorAll(".skor-radio").forEach(radio => {
                    radio.addEventListener("change", function() {
                        let skor = parseInt(this.value);
                        document.getElementById("nilai_total").value = poin * skor;
                    });
                });

                document.getElementById("id_matriks_led").value = id_matriks_led;




            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const navItems = Array.from(document.querySelectorAll(".nav-item-btn"));
            const total = navItems.length;
            let currentIndex = 0;

            const btnPrev = document.getElementById("btnPrev");
            const btnNext = document.getElementById("btnNext");

            function activate(index) {
                if (index < 0 || index >= total) return;

                currentIndex = index;
                const activeBtn = navItems[currentIndex];

                activeBtn.click();

                activeBtn.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                    inline: "nearest"
                });

                updateButtonState();
            }
            navItems.forEach((btn, index) => {
                btn.addEventListener("click", () => {
                    currentIndex = index;
                    updateButtonState();
                });
            });

            btnNext.addEventListener("click", () => {
                if (currentIndex < total - 1) {
                    activate(currentIndex + 1);
                }
            });

            btnPrev.addEventListener("click", () => {
                if (currentIndex > 0) {
                    activate(currentIndex - 1);
                }
            });

            function updateButtonState() {
                btnPrev.disabled = currentIndex === 0;
                btnNext.disabled = currentIndex === total - 1;
            }

            const lastId = localStorage.getItem("lastElement");

            if (lastId) {
                const foundIndex = navItems.findIndex(
                    btn => btn.dataset.id === lastId
                );

                // console.log('Ini adalah ID yang disimpan', lastId)
                // console.log('Ini adalah index yang ditemukan', foundIndex)

                if (foundIndex !== -1) {
                    activate(foundIndex);
                    return;
                }
            }

            if (total > 0) {
                activate(0);
            }
        });
    </script>



    {{-- Ini yang membuat terklik --}}

    <script>
        document.querySelectorAll(".nav-item-btn").forEach(btn => {
            btn.addEventListener("click", () => {

                // HAPUS active dari semua nav
                document.querySelectorAll(".nav-item-btn").forEach(item => {
                    item.classList.remove("active");
                });

                // TAMBAHKAN active ke yang diklik
                btn.classList.add("active");

                // SIMPAN ID TERAKHIR
                localStorage.setItem('lastElement', btn.dataset.id);
                // console.log('ID tersimpan:', btn.dataset.id);
            });
        });
    </script>

    <script>
        window.addEventListener("load", function() {
            const overlay = document.getElementById('loading-overlay');

            overlay.classList.add('fade-out');
            setTimeout(() => overlay.remove(), 600);

            const last = localStorage.getItem('lastElement');
            const selector = last ? `[data-id="${last}"]` : ".nav-item-btn";

            const btnToClick = document.querySelector(selector);

            if (btnToClick) {
                btnToClick.click();
                btnToClick.scrollIntoView({
                    behavior: "auto",
                    block: "center"
                });
                // console.log("Memuat elemen:", selector);
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const searchInput = document.getElementById("search-elemen");
            const container = document.getElementById("nav-container");

            searchInput.addEventListener("input", function() {
                const keyword = this.value.toLowerCase().trim();
                const buttons = container.querySelectorAll(".nav-item-btn");

                if (keyword === "") return; // kalau kosong tidak usah scroll

                let firstMatch = null;

                buttons.forEach(btn => {
                    const text = btn.innerText.toLowerCase();

                    if (text.includes(keyword)) {
                        if (!firstMatch) firstMatch = btn;
                        // highlight hasil pencarian
                        btn.classList.add("search-match");
                    } else {
                        btn.classList.remove("search-match");
                    }
                });

                // Scroll ke item pertama yang cocok
                if (firstMatch) {
                    firstMatch.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });
                }
            });
        });
    </script>

    {{-- Filter warna --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.getElementById('filterColor').addEventListener('change', function() {
                let filter = this.value;

                document.querySelectorAll('.nav-item-btn').forEach(btn => {
                    let color = btn.dataset.color;
                    // console.log("filter:", filter);
                    // console.log("color:", color);

                    if (filter === "" || filter === color) {
                        btn.style.display = "flex";
                        // console.log('if pertama')
                    } else {
                        btn.style.display = "none";
                        // console.log('if kedua')
                    }
                });

            });

        });
    </script>





@endsection
