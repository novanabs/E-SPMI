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
        HASIL AUDIT MUTU INTERNAL PRODI
    </h2>

    <table style="margin-bottom:20px">
        <tr>
            <td width="30%">Fakultas</td>
            <td>Keguruan dan Ilmu Pendidikan</td>
        </tr>

        <tr>
            <td>Program Studi</td>
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
            <td>{{ $auditor->get(0)?->user?->name }}</td>
        </tr>

        <tr>
            <td>Auditor II</td>
            <td>{{ $auditor->get(1)?->user?->name }}</td>
        </tr>

        <tr>
            <td>Catatan Umum</td>
            <td>{{ $auditHeader?->catatan_umum }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Kriteria</th>
                <th width="35%">Temuan Audit</th>
                <th width="35%">Saran & Rekomendasi</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($auditKriterias as $index => $kriteria)
                @php
                    $audit = $kriteria->auditKriterias->first();
                @endphp
                <tr>
                    <td align="center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $kriteria->name }}
                    </td>

                    <td>
                        {{ $audit && $audit->temuan ? $audit->temuan : '-' }}
                    </td>

                    <td>
                        {{ $audit && $audit->rekomendasi ? $audit->rekomendasi : '-' }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <br><br><br>

    <table style="border:none">
        <tr>
            <td style="border:none;text-align:center">
                Ketua Jurusan
                <br><br><br><br><br>
                {{ $jurusan->name }}
            </td>

            <td style="border:none;text-align:center">
                Auditor I
                <br><br><br><br><br>
                <b>{{ $auditor->get(0)?->user?->name }}</b>
            </td>

            <td style="border:none;text-align:center">
                Auditor II
                <br><br><br><br><br>
                <b>{{ $auditor->get(1)?->user?->name }}</b>
            </td>


        </tr>
    </table>

</body>

</html>
