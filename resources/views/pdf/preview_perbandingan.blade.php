<div style="font-family: Arial, sans-serif; font-size: 14px">
    <table width="100%" style="margin-bottom:10px" hidden>
        <tr>
            <td width="15%" valign="top">
                <img src="{{ $logo }}" width="80" alt="Logo ULM">
            </td>
            <td align="center" valign="middle">
                <strong>
                    UNIVERSITAS LAMBUNG MANGKURAT
                </strong><br>
                <strong>
                    FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN
                </strong><br>
                <strong style="text-transform: uppercase">

                </strong><br>
            </td>
            <td width="15%"></td>
        </tr>
    </table>

    <h3 style="text-align:center">HASIL AMI JURUSAN {{ strtoupper(auth()->user()->homebase) }}</h3>

    <br>

    <table width="50%" style="margin-bottom:15px">
        <tr>
            <td><strong>Tanggal Audit</strong></td>
            <td>: {{ $tanggal }}</td>
        </tr>
        {{-- <tr>
            <td><strong>Dibuat oleh</strong></td>
            <td>: {{ $generated_by }}</td>
        </tr> --}}
        @if ($showAuditor)
            <tr>
                <td><strong>Auditor 1</strong></td>
                <td>: {{ $auditorNameMap['Auditor 1'] ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Auditor 2</strong></td>
                <td>: {{ $auditorNameMap['Auditor 2'] ?? '-' }}</td>
            </tr>
        @endif
    </table>
    <table width="100%" border="1" cellpadding="6" cellspacing="0"
        style="border-collapse:collapse; font-family:Arial; font-size:14px">
        <tr style="background:#f2f2f2; text-align:center">
            <th width="40%">Penilaian Mandiri Jurusan</th>
            <th width="40%">{{ $showAuditor ? 'Penilaian Auditor' : 'Penilaian UPM' }}</th>
            <th width="20%">Selisih</th>
        </tr>
        <tr>
            <td valign="top">
                Nilai AMI : <strong>{{ number_format($totalJurusan, 2) }}</strong><br>
                Status : <strong>{{ $statusJurusan }}</strong><br>
                Masa Berlaku : <strong>{{ $masaJurusan }}</strong>
            </td>

            <td valign="top">
                Nilai AMI : <strong>{{ number_format($totalAuditor, 2) }}</strong><br>
                Status : <strong>{{ $statusAuditor }}</strong><br>
                Masa Berlaku : <strong>{{ $masaAuditor }}</strong>
            </td>

            <td align="center" valign="middle">
                <strong>{{ number_format($selisih, 2) }}</strong>
            </td>
        </tr>
    </table>
    {{-- CHART RADAR PER ASPEK --}}

    {{-- <h4 style="text-align:center; margin:0 0 10px 0;">Grafik Capaian Per Aspek</h4> --}}
    <div style="text-align:center;">
        <img src="{{ $radarChart }}" width="520" height="480" alt="Radar Chart">
    </div>
    <br>



    <br>

    <table width="100%" border="1" cellpadding="6" cellspacing="0"
        style="border-collapse:collapse; font-family:Arial, sans-serif; font-size:13px">

        <thead style="background:#f2f2f2; text-align:center">
            <tr>
                <th width="4%">No</th>
                <th>Elemen</th>
                <th width="7%">Nilai Jurusan</th>
                <th width="7%">{{ $showAuditor ? 'Nilai Auditor' : 'Nilai UPM' }}</th>
                <th width="7%">Selisih</th>
                <th>Temuan</th>
                <th>Saran</th>
            </tr>
        </thead>

        <tbody>
            @php
                $no = 0;
                $prevKriteria = null;
            @endphp
            @foreach ($elemen as $item)
                @php
                    $kriteriaName = $item->kriteria->name ?? '-';
                    $nilaiJurusan = data_get($item, 'userMatrik.nilai_total');
                    $nilaiAuditor = $showAuditor
                        ? $auditorScores->get($item->id)?->nilai_total ?? null
                        : data_get($item, 'userMatrikByUser.nilai_total');

                    $selisih =
                        !is_null($nilaiJurusan) && !is_null($nilaiAuditor) && $nilaiJurusan > 0 && $nilaiAuditor > 0
                            ? abs($nilaiJurusan - $nilaiAuditor)
                            : null;

                    // Build combined temuan/saran for auditor display
                    $temuanHtml = '-';
                    $saranHtml = '-';
                    if ($showAuditor) {
                        $tsItems = $auditorTemuanSaran->get($item->id) ?? collect();
                        if ($tsItems->isNotEmpty()) {
                            $partsTemuan = [];
                            $partsSaran = [];
                            foreach ($tsItems as $ts) {
                                $label = $auditorLabelMap[$ts->id_users] ?? 'Auditor';
                                if (!empty($ts->temuan)) {
                                    $partsTemuan[] = '<strong>' . $label . ' :</strong> ' . e($ts->temuan);
                                }
                                if (!empty($ts->saran)) {
                                    $partsSaran[] = '<strong>' . $label . ' :</strong> ' . e($ts->saran);
                                }
                            }
                            if (!empty($partsTemuan)) {
                                $temuanHtml = implode('<br>', $partsTemuan);
                            }
                            if (!empty($partsSaran)) {
                                $saranHtml = implode('<br>', $partsSaran);
                            }
                        }
                    }
                @endphp

                @if ($kriteriaName !== $prevKriteria)
                    @php $prevKriteria = $kriteriaName; @endphp
                    <tr style="background:#e9ecef;">
                        <td colspan="7" style="padding:8px 10px; font-weight:bold; font-size:14px;">
                            {{ $kriteriaName }}
                        </td>
                    </tr>
                @endif

                @php $no++; @endphp
                <tr>
                    <td align="center" valign="top">{{ $no }}</td>

                    <td valign="top">
                        {{ $item->elemen }}
                    </td>

                    <td align="center">
                        {{ $nilaiJurusan && $nilaiJurusan > 0 ? number_format($nilaiJurusan, 2) : '-' }}
                    </td>

                    <td align="center">
                        {{ $nilaiAuditor && $nilaiAuditor > 0 ? number_format($nilaiAuditor, 2) : '-' }}
                    </td>

                    <td align="center">
                        {{ $selisih !== null ? number_format($selisih, 2) : '-' }}
                    </td>

                    <td valign="top" style="font-size:12px">
                        {!! $showAuditor ? $temuanHtml : (data_get($item, 'userMatrikByUser.temuan') ?: '-') !!}
                    </td>

                    <td valign="top" style="font-size:12px">
                        {!! $showAuditor ? $saranHtml : (data_get($item, 'userMatrikByUser.saran') ?: '-') !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- SIGNATURE BLOCK --}}
    <table width="100%" style="margin-top:60px; font-size:14px">
        <tr>
            @php
                $auditor1Name = $auditorNameMap['Auditor 1'] ?? '';
                $auditor1Nip = $auditorNipMap['Auditor 1'] ?? '';
                $auditor2Name = $auditorNameMap['Auditor 2'] ?? '';
                $auditor2Nip = $auditorNipMap['Auditor 2'] ?? '';
            @endphp

            @if ($showAuditor)
                <td align="left" valign="top" width="33%">
                    ________________, {{ $tanggal }}<br><br>
                    <strong>Mengetahui,</strong><br>
                    <strong>Ketua Jurusan {{ $userJurusan->homebase }}</strong>
                    <br><br><br><br><br><br>
                    <strong>{{ $userJurusan->name ?? '_______________________________' }}</strong><br>
                    NIP. {{ $userJurusan->nip ?? '' }}
                </td>
                @if ($auditor1Name)
                    <td align="left" valign="top" width="33%">
                        <br><br><br>
                        <strong>Auditor 1</strong>
                        <br><br><br><br><br><br>
                        <strong>{{ $auditor1Name }}</strong><br>
                        NIP. {{ $auditor1Nip }}
                    </td>
                @endif
                @if ($auditor2Name)
                    <td align="left" valign="top" width="33%">
                        <br><br><br>
                        <strong>Auditor 2</strong>
                        <br><br><br><br><br><br>
                        <strong>{{ $auditor2Name }}</strong><br>
                        NIP. {{ $auditor2Nip }}
                    </td>
                @endif
            @else
                <td width="60%"></td>
                <td align="left" valign="top">
                    ________________, {{ $tanggal }}<br><br>
                    <strong>Mengetahui,</strong><br>
                    <strong>{{ $userJurusan->jabatan }} {{ $userJurusan->homebase }}</strong>
                    <br><br><br><br><br><br>
                    <strong>{{ $userJurusan->name ?? '_______________________________' }}</strong><br>
                    NIP. {{ $userJurusan->nip ?? '' }}
                </td>
            @endif
        </tr>
    </table>

</div>
