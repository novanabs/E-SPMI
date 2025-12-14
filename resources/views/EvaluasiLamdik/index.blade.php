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

                    <div class="card-header py-2">
                        <h5 class="mb-0">Hasil Akreditasi</h5>
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
                            <p class="mb-0 me-2">Peringkat:</p>
                            <p class="mb-0" id="peringkat"></p>
                        </div>

                        <a class="btn btn-primary btn-sm mt-3"
                            href="{{ route('evaluasi_lamdik.show', auth()->user()->id) }}">
                            Bandingkan
                        </a>

                    </div>
                </div>
            </div>


            <!-- Row kedua di kiri -->
            <div class="card shadow-sm">
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
                            data-nilai_total="{{ $item->userMatrik->nilai_total ?? 0 }}">

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

    {{-- Hitung Akreditasi --}}
    <script>
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
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let total = 0;

            document.querySelectorAll(".nav-item-btn").forEach(btn => {
                let nilai_total_users_matriks = parseFloat(btn.dataset.nilai_total);
                total += nilai_total_users_matriks;
                console.log(total);
            });

            document.getElementById("total_nilai_semua").innerText = total;

            let hasil = hitungAkreditasi(total);

            document.getElementById("status").innerText = hasil.status;
            document.getElementById("peringkat").innerText = hasil.peringkat;
        });
    </script>

    <script></script>

    <script>
        document.querySelectorAll(".nav-item-btn").forEach(btn => {
            btn.addEventListener("click", () => {

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
                console.log("jawaban:", nilai_total);
                console.log(typeof nilai_total); // number

                console.log("jawaban:", jawaban);




                const jsonString = btn.dataset.pilihan;
                let pilihan = JSON.parse(JSON.parse(jsonString));
                let harkat_penskoran = btn.dataset.harkat_penskoran;


                let container = document.getElementById('kriteriaForm');

                // console.log(pilihan == null)
                // console.log(typeof(harkat_penskoran))
                // console.log(harkat_penskoran == "")

                if (pilihan === null) {
                    // Reset isi form
                    container.innerHTML = `
                @csrf
                <div class="mt-3 mb-3">
                    <label class="form-label"><strong>Harkat Penskoran</strong></label>
                </div>
            `;

                    container.insertAdjacentHTML('beforeend', `<pre class='harkat_penskoran'>` +
                        harkat_penskoran + `</pre>`);

                    container.insertAdjacentHTML('beforeend', `
                <div class="mb-3">
                    <label for="skor" class="form-label"><strong>Skor (1,2,3,4)</strong></label>
                    <input type="number" class="form-control" id="skor" name="jawaban" value='${parseInt(jawaban)}'
                        placeholder="Masukkan skor" required>
                </div>

                <div class="mb-3">
                    <label for="bukti" class="form-label"><strong>Link Bukti (Opsional)</strong></label>
                    <div class="input-group">
        <input type="url" class="form-control" id="bukti" name="link_bukti"
            value="${link_bukti}" placeholder="Masukkan link bukti">

           ${link_bukti ? `<a href="${link_bukti}" target="_blank" class="btn btn-outline-primary">↗</a>` : ''}

    </div>
                </div>

               <div class="mb-3">
    <label for="temuan" class="form-label" hidden><strong>Temuan (Opsional)</strong></label>
    <textarea class="form-control" id="temuan" name="temuan" rows="3"
        placeholder="Masukkan temuan" hidden>${temuan}</textarea>
</div>

<div class="mb-3">
    <label for="saran" class="form-label" hidden><strong>Saran (Opsional)</strong></label>
    <textarea class="form-control" id="saran" name="saran" rows="3"
        placeholder="Masukkan saran" hidden>${saran}</textarea>
</div>


                <input type="hidden" name="nilai_total" id="nilai_total" value="${nilai_total}">
                <input type="hidden" name="id_matriks_led" id="id_matriks_led">
                <input type="hidden" name="kepemilikan_kriteria" id="kepemilikan_kriteria" value="{{ $for }}">
                <input type="hidden" name="id_users" value="{{ auth()->user()->id }}">

                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
            `);

                    const skorInput = document.getElementById("skor");
                    const nilaiTotalInput = document.getElementById("nilai_total");

                    skorInput.addEventListener("input", function() {
                        let skor = parseFloat(this.value);
                        let poinValue = parseFloat(poin);

                        if (!isNaN(skor) && !isNaN(poinValue)) {
                            nilaiTotalInput.value = poinValue * skor;
                        } else {
                            nilaiTotalInput.value = "";
                        }
                    });


                } else if (pilihan != null && harkat_penskoran != "") {
                    container.innerHTML = `
                @csrf
                <div class="mt-3 mb-3">
                    <label class="form-label"><strong>Harkat Penskoran</strong></label>
                </div>
            `;




                    let wrapper = container.querySelector(".mb-3");

                    wrapper.insertAdjacentHTML('beforeend', `
    <pre class="harkat_penskoran">${harkat_penskoran}</pre>
`);
                    wrapper.insertAdjacentHTML('beforeend', `
    <label class="form-label"><strong>Pilihan Penilaian</strong></label>
`);

                    // --- Generate pilihan penilaian ---
                    Object.keys(pilihan)
                        .sort((a, b) => b - a) // urut skor terbesar
                        .forEach(skor => {

                            let id = "kriteria_" + skor;

                            let isChecked = (parseInt(jawaban) === parseInt(skor)) ? "checked" : "";


                            let html = `
                        <div class="form-check">
                            <input class="form-check-input skor-radio" 
                                   type="radio" required 
                                   name="jawaban" 
                                   value="${skor}" 
                                   id="${id}" ${isChecked}>
                            <label class="form-check-label" for="${id}">
                                <strong>Skor ${skor}.</strong> ${pilihan[skor]}
                            </label>
                        </div>
                    `;

                            wrapper.insertAdjacentHTML('beforeend', html);
                        });

                    // --- Input bukti + nilai akhir ---
                    container.insertAdjacentHTML('beforeend', `
                <div class="mb-3 mt-3">
                    <label for="bukti" class="form-label"><strong>Link Bukti (Opsional)</strong></label>
                    <div class="input-group">
        <input type="url" class="form-control" id="bukti" name="link_bukti"
            value="${link_bukti}" placeholder="Masukkan link bukti">

            ${link_bukti ? `<a href="${link_bukti}" target="_blank" class="btn btn-outline-primary">↗</a>` : ''}

    </div>
                </div>

                <div class="mb-3">
    <label for="temuan" class="form-label" hidden><strong>Temuan (Opsional)</strong></label>
    <textarea class="form-control" id="temuan" name="temuan" rows="3"
        placeholder="Masukkan temuan" hidden>${temuan}</textarea>
</div>

<div class="mb-3">
    <label for="saran" class="form-label" hidden><strong>Saran (Opsional)</strong></label>
    <textarea class="form-control" id="saran" name="saran" rows="3"
        placeholder="Masukkan saran" hidden>${saran}</textarea>
</div>


                <input type="hidden" name="nilai_total" id="nilai_total" value="${nilai_total}">
                <input type="hidden" name="id_matriks_led" id="id_matriks_led">
                <input type="hidden" name="kepemilikan_kriteria" id="kepemilikan_kriteria" value="{{ $for }}">
                <input type="hidden" name="id_users" value="{{ auth()->user()->id }}">

                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
            `);

                    // --- Hitung nilai total ketika skor dipilih ---
                    document.querySelectorAll(".skor-radio").forEach(radio => {
                        radio.addEventListener("change", function() {
                            let skorDipilih = parseInt(this.value);
                            let nilaitotal = poin * skorDipilih;

                            document.getElementById("nilai_total").value = nilaitotal;

                            console.log("Nilai total:", nilaiAkhir);
                        });
                    });


                } else {

                    // Reset isi form
                    container.innerHTML = `
                @csrf
                <div class="mt-3 mb-3">
                    <label class="form-label"><strong>Pilihan Penilaian</strong></label>
                </div>
            `;

                    let wrapper = container.querySelector(".mb-3");

                    // --- Generate pilihan penilaian ---
                    Object.keys(pilihan)
                        .sort((a, b) => b - a) // urut skor terbesar
                        .forEach(skor => {

                            let id = "kriteria_" + skor;

                            let isChecked = (parseInt(jawaban) === parseInt(skor)) ? "checked" : "";


                            let html = `
                        <div class="form-check">
                            <input class="form-check-input skor-radio" 
                                   type="radio" required 
                                   name="jawaban" 
                                   value="${skor}" 
                                   id="${id}" ${isChecked}>
                            <label class="form-check-label" for="${id}">
                                <strong>Skor ${skor}.</strong> ${pilihan[skor]}
                            </label>
                        </div>
                    `;

                            wrapper.insertAdjacentHTML('beforeend', html);
                        });



                    // --- Input bukti + nilai akhir ---
                    container.insertAdjacentHTML('beforeend', `
                <div class="mb-3 mt-3">
                    <label for="bukti" class="form-label"><strong>Link Bukti (Opsional)</strong></label>
                    <div class="input-group">
        <input type="url" class="form-control" id="bukti" name="link_bukti"
            value="${link_bukti}" placeholder="Masukkan link bukti">

            ${link_bukti ? `<a href="${link_bukti}" target="_blank" class="btn btn-outline-primary">↗</a>` : ''}

    </div>
                </div>

                <div class="mb-3">
    <label for="temuan" class="form-label" hidden><strong>Temuan (Opsional)</strong></label>
    <textarea class="form-control" id="temuan" name="temuan" rows="3"
        placeholder="Masukkan temuan" hidden>${temuan}</textarea>
</div>

<div class="mb-3">
    <label for="saran" class="form-label" hidden><strong>Saran (Opsional)</strong></label>
    <textarea class="form-control" id="saran" name="saran" rows="3"
        placeholder="Masukkan saran" hidden>${saran}</textarea>
</div>


                <input type="hidden" name="nilai_total" id="nilai_total" value="${nilai_total}">
                <input type="hidden" name="id_matriks_led" id="id_matriks_led">
                <input type="hidden" name="kepemilikan_kriteria" id="kepemilikan_kriteria" value="{{ $for }}">
                <input type="hidden" name="id_users" value="{{ auth()->user()->id }}">

                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
            `);
                    document.getElementById("id_matriks_led").value = id_matriks_led;

                    // --- Hitung nilai total ketika skor dipilih ---
                    document.querySelectorAll(".skor-radio").forEach(radio => {
                        radio.addEventListener("change", function() {
                            let skorDipilih = parseInt(this.value);
                            let nilaitotal = poin * skorDipilih;

                            document.getElementById("nilai_total").value = nilaitotal;

                        });
                    });


                }

                document.getElementById("id_matriks_led").value = id_matriks_led;




            });
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
                console.log('ID tersimpan:', btn.dataset.id);
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
                console.log("Memuat elemen:", selector);
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
                    console.log("filter:", filter);
                    console.log("color:", color);

                    if (filter === "" || filter === color) {
                        btn.style.display = "flex";
                        console.log('if pertama')
                    } else {
                        btn.style.display = "none";
                        console.log('if kedua')
                    }
                });

            });

        });
    </script>





@endsection
