@extends('layouts.app')

@section('title', 'Evaluasi Lamdik')

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





    <div class="row">
        <div class="col-md-9">
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

        <div class="col-md-3">
            <div class="card shadow-sm" style="max-height: 50vh; overflow-y: auto;">
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

                        {{-- Tombol navigasi --}}
                        <button class="list-group-item list-group-item-action nav-item-btn d-flex"
                            data-id="{{ $item->id }}" data-title="{{ $item->nomor }}. {{ $item->elemen }}"
                            data-content="{{ $item->indikator }}" data-pilihan='@json($item->option_pilihan_ganda)'
                            data-poin="{{ $item->poin }}" data-harkat_penskoran="{{ $item->harkat_penskoran }}"
                            data-jenis="{{ $item->jenis }}" {{-- Ini data dari users matrik --}}
                            data-link_bukti="{{ $item->userMatrik->link_bukti ?? '' }}"
                            data-temuan="{{ $item->userMatrik->temuan ?? '' }}"
                            data-saran="{{ $item->userMatrik->saran ?? '' }}"
                            data-jawaban="{{ $item->userMatrik->jawaban ?? '' }} ">

                            <span class="me-2" style="width: 30px;">{{ $item->nomor }}.</span>
                            <span>{{ $item->elemen }} ({{ $item->poin }})</span>
                        </button>
                    @endforeach



                    <!-- Anda dapat mengulangi header kriteria + elemen sesuai kebutuhan -->
                </div>
            </div>
        </div>
    </div>

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
                    <input type="url" class="form-control" id="bukti" name="link_bukti" value="${link_bukti}"
                        placeholder="Masukkan link bukti">
                </div>

               <div class="mb-3">
    <label for="temuan" class="form-label"><strong>Temuan (Opsional)</strong></label>
    <textarea class="form-control" id="temuan" name="temuan" rows="3"
        placeholder="Masukkan temuan">${temuan}</textarea>
</div>

<div class="mb-3">
    <label for="saran" class="form-label"><strong>Saran (Opsional)</strong></label>
    <textarea class="form-control" id="saran" name="saran" rows="3"
        placeholder="Masukkan saran">${saran}</textarea>
</div>


                <input type="hidden" name="nilai_total" id="nilai_total">
                <input type="hidden" name="id_matriks_led" id="id_matriks_led">
                <input type="hidden" name="kepemilikan_kriteria" id="kepemilikan_kriteria" value="{{ $for }}">
                <input type="hidden" name="id_users" value="{{ auth()->user()->id }}">

                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
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
                    <input type="url" class="form-control" id="bukti" name="link_bukti" value="${link_bukti}"
                        placeholder="Masukkan link bukti">
                </div>

                <div class="mb-3">
    <label for="temuan" class="form-label"><strong>Temuan (Opsional)</strong></label>
    <textarea class="form-control" id="temuan" name="temuan" rows="3"
        placeholder="Masukkan temuan">${temuan}</textarea>
</div>

<div class="mb-3">
    <label for="saran" class="form-label"><strong>Saran (Opsional)</strong></label>
    <textarea class="form-control" id="saran" name="saran" rows="3"
        placeholder="Masukkan saran">${saran}</textarea>
</div>


                <input type="hidden" name="nilai_total" id="nilai_total">
                <input type="hidden" name="id_matriks_led" id="id_matriks_led">
                <input type="hidden" name="kepemilikan_kriteria" id="kepemilikan_kriteria" value="{{ $for }}">
                <input type="hidden" name="id_users" value="{{ auth()->user()->id }}">

                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
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
                    <input type="url" class="form-control" id="bukti" name="link_bukti" value="${link_bukti}"
                        placeholder="Masukkan link bukti">
                </div>

                <div class="mb-3">
    <label for="temuan" class="form-label"><strong>Temuan (Opsional)</strong></label>
    <textarea class="form-control" id="temuan" name="temuan" rows="3"
        placeholder="Masukkan temuan">${temuan}</textarea>
</div>

<div class="mb-3">
    <label for="saran" class="form-label"><strong>Saran (Opsional)</strong></label>
    <textarea class="form-control" id="saran" name="saran" rows="3"
        placeholder="Masukkan saran">${saran}</textarea>
</div>


                <input type="hidden" name="nilai_total" id="nilai_total">
                <input type="hidden" name="id_matriks_led" id="id_matriks_led">
                <input type="hidden" name="kepemilikan_kriteria" id="kepemilikan_kriteria" value="{{ $for }}">
                <input type="hidden" name="id_users" value="{{ auth()->user()->id }}">

                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
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
                console.log("Memuat elemen:", selector);
            }
        });
    </script>




@endsection
