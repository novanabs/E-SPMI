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
                } elseif ($item->nomor == 5) {
                    $subItems = json_decode($item->matriks->subItemElemen, true);
                    $userValues = json_decode($item->matriks->userSubItemElements, true);

                    $nilaiMap = [];
                    foreach ($userValues as $val) {
                        $nilaiMap[$val['id_sub_item_elemen']] = $val['nilai'];
                    }

                    $NM = $NKM3 = $NKM5 = 0;

                    foreach ($subItems as $sub) {
                        $id = $sub['id'];
                        $var = $sub['variabel'];
                        $nilai = $nilaiMap[$id] ?? 0;

                        if ($var == 'NM') {
                            $NM = $nilai;
                        }
                        if ($var == 'NKM_3') {
                            $NKM3 = $nilai;
                        }
                        if ($var == 'NKM_5') {
                            $NKM5 = $nilai;
                        }
                    }

                    if ($NM > 0) {
                        $persen3 = ($NKM3 / $NM) * 100;
                        $persen5 = ($NKM5 / $NM) * 100;

                        // 🔥 3 Tahun
                        if ($persen3 >= 15) {
                            $bg3 = 'bg-success text-white';
                        }

                        // 🔥 5 Tahun
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

                    $NDTPS = $NDTPUB3 = $NDTPUB5 = 0;

                    foreach ($subItems as $sub) {
                        $id = $sub['id'];
                        $var = $sub['variabel'];
                        $nilai = $nilaiMap[$id] ?? 0;

                        if ($var == 'NDTPS') {
                            $NDTPS = $nilai;
                        }
                        if ($var == 'NDTPUB_3') {
                            $NDTPUB3 = $nilai;
                        }
                        if ($var == 'NDTPUB_5') {
                            $NDTPUB5 = $nilai;
                        }
                    }

                    if ($NDTPS > 0) {
                        $persen3 = ($NDTPUB3 / $NDTPS) * 100;
                        $persen5 = ($NDTPUB5 / $NDTPS) * 100;

                        // 🔥 3 Tahun
                        if ($persen3 >= 20) {
                            $bg3 = 'bg-success text-white';
                        }

                        // 🔥 5 Tahun
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
                        Elemen {{ $item->nomor }}
                    </div>

                    {{-- BODY --}}
                    <div class="card-body">

                        {{-- ELEMEN --}}
                        <h6 class="fw-bold mb-2">Elemen</h6>
                        <p class="mb-3">
                            {{ $item->elemen ?? '-' }} <br>
                            <small class="text-muted">
                                {{ $item->matriks->elemen ?? '-' }}
                            </small>
                        </p>

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
