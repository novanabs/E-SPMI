<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2 class="text-center">
        BERITA ACARA HASIL AMI <br>
        JURUSAN {{ strtoupper($jurusan->homebase) }} <br>
        TAHUN {{ $tahun }}
    </h2>

    <table style="margin-bottom:20px">
        <tr>
            <td width="30%">Fakultas</td>
            <td>Keguruan dan Ilmu Pendidikan</td>
        </tr>

        <tr>
            <td>Jurusan</td>
            <td>{{ $jurusan->homebase }}</td>
        </tr>

        <tr>
            <td>Tanggal Audit</td>
            <td>
                {{ $auditHeader?->tanggal_audit?->format('d-m-Y') }}
            </td>
        </tr>

        <tr>
            <td>Auditor I</td>
            <td>{{ $auditors->get(0)?->user?->name }}</td>
        </tr>

        <tr>
            <td>Auditor II</td>
            <td>{{ $auditors->get(1)?->user?->name }}</td>
        </tr>

        <tr>
            <td>Catatan Umum</td>
            <td>{{ $auditHeader?->catatan_umum }}</td>
        </tr>
    </table>

    @php
        $namaKriteria = array_keys($perAspekJurusan);

        $kriteriaMap = $auditKriterias->keyBy('id');

        $skorA = $perAspekAuditor[$jurusan->id] ?? [];
    @endphp

    <table border="1" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="25%">Kriteria</th>
                <th width="10%">Skor Jurusan</th>
                <th width="10%">Skor Auditor</th>
                <th width="10%">Selisih</th>
                <th width="20%">Temuan</th>
                <th width="20%">Rekomendasi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($namaKriteria as $index => $nama)
                @php
                    $kriteriaId = $index + 1;

                    $sJ = $perAspekJurusan[$nama] ?? 0;
                    $sA = $skorA[$nama] ?? 0;
                    $selisih = $sJ - $sA;

                    $kriteria = $kriteriaMap[$kriteriaId] ?? null;
                    $audit = $kriteria?->auditKriterias?->first();
                @endphp

                <tr>
                    <td align="center">{{ $kriteriaId }}</td>

                    <td>{{ $nama }}</td>

                    <td align="center">
                        {{ number_format($sJ, 2) }}
                    </td>

                    <td align="center">
                        {{ number_format($sA, 2) }}
                    </td>

                    <td align="center">
                        {{ number_format($selisih, 2) }}
                    </td>

                    <td>
                        {{ $audit?->temuan ?: '-' }}
                    </td>

                    <td>
                        {{ $audit?->rekomendasi ?: '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2" align="right"><strong>Total</strong></td>

                <td align="center">
                    <strong>{{ number_format(array_sum($perAspekJurusan), 2) }}</strong>
                </td>

                <td align="center">
                    <strong>{{ number_format(array_sum($skorA), 2) }}</strong>
                </td>

                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>

    <br><br><br>

    <table style="border:none">
        <tr>
            <td style="border:none;text-align:left">
                Banjarmasin, {{ now()->translatedFormat('d F Y') }}

                <br><br>

                Ketua Jurusan {{ $jurusan->homebase }}

                <br><br><br><br><br>

                {{ $jurusan->name }} <br>
                NIP. {{ $jurusan->nip }}
            </td>

            <td style="border:none;text-align:center">
                Auditor I
                <br><br><br><br><br><br><br>
                <b>{{ $auditors->get(0)?->user?->name }}</b><br>
                NIP. {{ $auditors->get(0)?->user?->nip }}
            </td>

            <td style="border:none;text-align:center">
                Auditor II
                <br><br><br><br><br><br><br>
                <b>{{ $auditors->get(1)?->user?->name }}</b><br>
                NIP. {{ $auditors->get(1)?->user?->nip }}
            </td>


        </tr>
    </table>

</body>

</html>
