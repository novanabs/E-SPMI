@extends('layouts.app')

@section('title', 'Syarat Unggul ' . (auth()->user()->homebase ?? ''))

@section('content')

    <div class="row">
        @foreach ($data as $item)
            @php
                $syarat = json_decode($item->syarat_tahun, true);

                // default
                $bg3 = '';
                $bg5 = '';

                /* =========================
       🔥 ELEMEN 1 (KHUSUS)
    ========================= */
                if ($item->nomor == 1) {
                    $subItems = json_decode($item->matriks->subItemElemen, true);
                    $userValues = json_decode($item->matriks->userSubItemElements, true);

                    $nilaiMap = [];
                    foreach ($userValues as $val) {
                        $nilaiMap[$val['id_sub_item_elemen']] = $val['nilai'];
                    }

                    $NDS3 = $NDL = $NDLK = $NDGB = 0;

                    foreach ($subItems as $sub) {
                        $id = $sub['id'];
                        $var = $sub['variabel'];
                        $nilai = $nilaiMap[$id] ?? 0;

                        if ($var == 'NDS3') {
                            $NDS3 = $nilai;
                        }
                        if ($var == 'NDL') {
                            $NDL = $nilai;
                        }
                        if ($var == 'NDLK') {
                            $NDLK = $nilai;
                        }
                        if ($var == 'NDGB') {
                            $NDGB = $nilai;
                        }
                    }

                    $totalLektor = $NDL + $NDLK + $NDGB;

                    // 3 tahun
                    if ($NDS3 >= 1 && $totalLektor >= 2) {
                        $bg3 = 'bg-success text-white';
                    }

                    // 5 tahun
                    if ($NDS3 >= 2 && $totalLektor >= 2 && $NDLK >= 1) {
                        $bg5 = 'bg-success text-white';
                    }
                } /* =========================
       🔥 ELEMEN 2,3,4
    ========================= */ elseif (
                    in_array($item->nomor, [2, 3, 4])
                ) {
                    $jawaban = (float) ($item->matriks->userMatrik->jawaban ?? 0);

                    if ($jawaban > 3) {
                        $bg3 = 'bg-success text-white';
                    }

                    if ($jawaban > 3.5) {
                        $bg5 = 'bg-success text-white';
                    }
                } /* =========================
   🔥 ELEMEN 5
========================= */ elseif ($item->nomor == 5) {
                    $subItems = json_decode($item->matriks->subItemElemen, true);
                    $userValues = json_decode($item->matriks->userSubItemElements, true);

                    $nilaiMap = [];

                    foreach ($userValues as $val) {
                        $nilaiMap[$val['id_sub_item_elemen']] = $val['nilai'];
                    }

                    $NM = 0;

                    // 🔥 Semua kategori publikasi mahasiswa
                    $S1 = $S2 = $S3 = $S4 = $S5 = $S6 = 0;
                    $INT = $ISBN = $PATEN = 0;

                    foreach ($subItems as $sub) {
                        $id = $sub['id'];
                        $var = $sub['variabel'];

                        $nilai = $nilaiMap[$id] ?? 0;

                        if ($var == 'NM') {
                            $NM = $nilai;
                        }

                        if ($var == 'SINTA1_MHS') {
                            $S1 = $nilai;
                        }
                        if ($var == 'SINTA2_MHS') {
                            $S2 = $nilai;
                        }
                        if ($var == 'SINTA3_MHS') {
                            $S3 = $nilai;
                        }
                        if ($var == 'SINTA4_MHS') {
                            $S4 = $nilai;
                        }
                        if ($var == 'SINTA5_MHS') {
                            $S5 = $nilai;
                        }
                        if ($var == 'SINTA6_MHS') {
                            $S6 = $nilai;
                        }

                        if ($var == 'INT_MHS') {
                            $INT = $nilai;
                        }
                        if ($var == 'ISBN_MHS') {
                            $ISBN = $nilai;
                        }
                        if ($var == 'PATEN_MHS') {
                            $PATEN = $nilai;
                        }
                    }

                    if ($NM > 0) {
                        /*
        =========================
        🔥 SYARAT 3 TAHUN
        Minimal Sinta 5
        =========================
        */
                        $total3 = $S1 + $S2 + $S3 + $S4 + $S5 + $INT + $ISBN + $PATEN;

                        $persen3 = ($total3 / $NM) * 100;

                        if ($persen3 >= 15) {
                            $bg3 = 'bg-success text-white';
                        }

                        /*
        =========================
        🔥 SYARAT 5 TAHUN
        Minimal Sinta 4
        =========================
        */
                        $total5 = $S1 + $S2 + $S3 + $S4 + $INT + $ISBN + $PATEN;

                        $persen5 = ($total5 / $NM) * 100;

                        if ($persen5 >= 25) {
                            $bg5 = 'bg-success text-white';
                        }
                    }
                }
                /* =========================
   🔥 ELEMEN 6
========================= */ elseif ($item->nomor == 6) {
                    $subItems = json_decode($item->matriks->subItemElemen, true);
                    $userValues = json_decode($item->matriks->userSubItemElements, true);

                    $nilaiMap = [];

                    foreach ($userValues as $val) {
                        $nilaiMap[$val['id_sub_item_elemen']] = $val['nilai'];
                    }

                    $NDTPS = 0;

                    $S1 = $S2 = $S3 = $S4 = 0;
                    $INT = $INTREP = 0;

                    foreach ($subItems as $sub) {
                        $id = $sub['id'];
                        $var = $sub['variabel'];

                        $nilai = $nilaiMap[$id] ?? 0;

                        if ($var == 'NDTPS') {
                            $NDTPS = $nilai;
                        }

                        if ($var == 'S1_DTPS') {
                            $S1 = $nilai;
                        }
                        if ($var == 'S2_DTPS') {
                            $S2 = $nilai;
                        }
                        if ($var == 'S3_DTPS') {
                            $S3 = $nilai;
                        }
                        if ($var == 'S4_DTPS') {
                            $S4 = $nilai;
                        }

                        if ($var == 'INT_DTPS') {
                            $INT = $nilai;
                        }
                        if ($var == 'INTREP_DTPS') {
                            $INTREP = $nilai;
                        }
                    }

                    if ($NDTPS > 0) {
                        /*
        =========================
        🔥 SYARAT 3 TAHUN
        Minimal Sinta 4 / Internasional
        =========================
        */
                        $total3 = $S1 + $S2 + $S3 + $S4 + $INT;

                        $persen3 = ($total3 / $NDTPS) * 100;

                        if ($persen3 >= 20) {
                            $bg3 = 'bg-success text-white';
                        }

                        /*
        =========================
        🔥 SYARAT 5 TAHUN
        Minimal Sinta 2 / Internasional Bereputasi
        =========================
        */
                        $total5 = $S1 + $S2 + $INTREP;

                        $persen5 = ($total5 / $NDTPS) * 100;

                        if ($persen5 >= 20) {
                            $bg5 = 'bg-success text-white';
                        }
                    }
                }
            @endphp

            <div class="col-md-12 mb-6 mb-3">
                <div class="card h-100 shadow-sm">

                    {{-- HEADER --}}
                    <div class="card-header fw-bold text-center">
                        Elemen {{ $item->nomor }} : {{ $item->elemen ?? '-' }} <br>
                        <small class="text-muted">
                            {{ $item->matriks->elemen ?? '-' }}
                        </small>
                    </div>

                    {{-- BODY --}}
                    <div class="card-body">


                        {{-- INDIKATOR --}}
                        <h6 class="fw-bold mb-2">Indikator</h6>
                        <p class="mb-3">
                            {{ $item->indikator }} <br>
                            <small class="text-muted">
                                Skor : {{ $item->matriks->userMatrik->jawaban ?? '-' }}
                            </small>
                        </p>

                        {{-- INDIKATOR --}}
                        <h6 class="fw-bold mb-2">Variabel</h6>
                        <p class="mb-3">
                            @php
                                $subItems = json_decode($item->matriks->subItemElemen, true);
                                $userValues = json_decode($item->matriks->userSubItemElements, true);

                                // mapping nilai berdasarkan id_sub_item_elemen
                                $nilaiMap = [];
                                foreach ($userValues as $val) {
                                    $nilaiMap[$val['id_sub_item_elemen']] = $val['nilai'];
                                }
                            @endphp

                        <div class="mt-2">
                            @foreach ($subItems as $sub)
                                <div class="d-flex justify-content-between border-bottom py-1">
                                    <div>
                                        <strong>{{ $sub['variabel'] }}</strong><br>
                                        <small class="text-muted">{{ $sub['deskripsi'] }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary">
                                            {{ $nilaiMap[$sub['id']] ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        </p>

                        {{-- SYARAT --}}
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border rounded p-2 h-100 {{ $bg3 }}">
                                    <small class="fw-bold d-block">3 Tahun</small>
                                    <small>
                                        {{ $syarat['3_tahun'] ?? '-' }}
                                    </small>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="border rounded p-2 h-100 {{ $bg5 }}">
                                    <small class="fw-bold d-block">5 Tahun</small>
                                    <small>
                                        {{ $syarat['5_Tahun'] ?? '-' }}
                                    </small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Elemen</th>
                <th>Indikator</th>
                <th>Syarat 3 Tahun</th>
                <th>Syarat 5 Tahun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                @php
                    $syarat = json_decode($item->syarat_tahun, true);
                @endphp
                <tr id="row-{{ $item->id }}">
                    <td>{{ $item->nomor }}</td>

                    <td>
                        {{ $item->elemen ?? '-' }}<br><br>
                        {{ $item->matriks->elemen ?? '-' }}
                    </td>

                    <td>
                        {{ $item->indikator }} <br>
                        <small class="text-muted">
                            {{ $item->matriks->userMatrik->jawaban ?? '-' }}
                        </small>
                    </td>

                    <td class="">

                        <div class="syarat-text">
                            {{ $syarat['3_tahun'] ?? '-' }}
                        </div>
                    </td>

                    <td class="">
                        <div class="syarat-text">
                            {{ $syarat['5_Tahun'] ?? '-' }}
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table> --}}



@endsection
