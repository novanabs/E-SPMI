@extends('layouts.app')

@section('title', 'Evaluasi Lamdik')

@section('content')

    <div class="row">
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 id="content-title" class="mb-0">Pilih Navigasi di Sebelah Kanan</h4>
                </div>
                <div class="card-body">
                    <p class="fw-bold">Poin : <span id="content-poin"></span></p>
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
                            data-poin="{{ $item->poin }}">

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
                document.getElementById("content-title").innerText = btn.dataset.title;
                document.getElementById("content-body").innerText = btn.dataset.content;
                var id_matriks_led = btn.dataset.id
                var poin = parseFloat(btn.dataset.poin);
                document.getElementById("content-poin").innerText = poin;

                const jsonString = btn.dataset.pilihan;
                let pilihan = JSON.parse(JSON.parse(jsonString)); // double decode

                let container = document.getElementById('kriteriaForm');

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

                        let html = `
                        <div class="form-check">
                            <input class="form-check-input skor-radio" 
                                   type="radio" 
                                   name="jawaban" 
                                   value="${skor}" 
                                   id="${id}">
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
                    <input type="url" class="form-control" id="bukti" name="link_bukti"
                        placeholder="Masukkan link bukti jika ada">
                </div>

                <input type="hidden" name="nilai_total" id="nilai_total">
                <input type="hidden" name="id_matriks_led" id="id_matriks_led">

                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            `);
                document.getElementById("id_matriks_led").value = id_matriks_led;

                // --- Hitung nilai total ketika skor dipilih ---
                document.querySelectorAll(".skor-radio").forEach(radio => {
                    radio.addEventListener("change", function() {
                        let skorDipilih = parseInt(this.value);
                        let nilaitotal = poin * skorDipilih;

                        document.getElementById("nilai_total").value = nilaitotal;

                        console.log("Nilai total:", nilaiAkhir);
                    });
                });

            });
        });
    </script>


@endsection
