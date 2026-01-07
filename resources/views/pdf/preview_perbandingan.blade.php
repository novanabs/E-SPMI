<div style="font-family: Arial, sans-serif; font-size: 14px">
    <table width="100%" style="margin-bottom:10px">
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
                    {{ auth()->user()->homebase }}
                </strong><br>
            </td>
            <td width="15%"></td>
        </tr>
    </table>

    <hr>


    <h3 style="text-align:center">PERBANDINGAN HASIL AKREDITASI</h3>

    <br>

    <table width="100%" style="margin-bottom:15px">
        <tr>
            <td><strong>Dibuat oleh</strong></td>
            <td>: {{ $generated_by }}</td>
            <td><strong>Tanggal</strong></td>
            <td>: {{ $tanggal }}</td>
        </tr>
    </table>

    <table width="100%" border="1" cellpadding="6" cellspacing="0"
        style="border-collapse:collapse; font-family:Arial; font-size:14px">
        <tr style="background:#f2f2f2; text-align:center">
            <th width="40%">Penilaian Mandiri Jurusan</th>
            <th width="40%">Penilaian UPM</th>
            <th width="20%">Selisih</th>
        </tr>
        <tr>
            <td valign="top">
                Nilai Akreditasi : <strong>{{ number_format($totalJurusan, 2) }}</strong><br>
                Status : {{ $statusJurusan }}<br>
                Peringkat : {{ $peringkatJurusan }}
            </td>

            <td valign="top">
                Nilai Akreditasi : <strong>{{ number_format($totalUpm, 2) }}</strong><br>
                Status : {{ $statusUpm }}<br>
                Peringkat : {{ $peringkatUpm }}
            </td>

            <td align="center" valign="middle">
                <strong>{{ number_format($selisih, 2) }}</strong>
            </td>
        </tr>
    </table>



    <br>

    <table width="100%" border="1" cellpadding="6" cellspacing="0"
        style="border-collapse:collapse; font-family:Arial, sans-serif; font-size:13px">

        <thead style="background:#f2f2f2; text-align:center">
            <tr>
                <th width="4%">No</th>
                <th width="15%">Kriteria</th>
                <th>Elemen</th>
                <th width="10%">Nilai Jurusan</th>
                <th width="10%">Nilai UPM</th>
                <th width="8%">Selisih</th>
                <th width="12%">Temuan</th>
                <th width="12%">Saran</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($elemen as $index => $item)
                @php
                    $nilaiJurusan = data_get($item, 'userMatrik.nilai_total');
                    $nilaiUpm = data_get($item, 'userMatrikByUser.nilai_total');

                    $selisih = !is_null($nilaiJurusan) && !is_null($nilaiUpm) ? abs($nilaiJurusan - $nilaiUpm) : null;
                @endphp

                <tr>
                    <td align="center">{{ $index + 1 }}</td>

                    <td valign="top">
                        {{ $item->kriteria->name ?? '-' }}
                    </td>

                    <td valign="top">
                        {{ $item->elemen }}
                    </td>

                    <td align="center">
                        {{ $nilaiJurusan ?? '-' }}
                    </td>

                    <td align="center">
                        {{ $nilaiUpm ?? '-' }}
                    </td>

                    <td align="center">
                        {{ $selisih ?? '-' }}
                    </td>

                    <td valign="top">
                        {{ data_get($item, 'userMatrikByUser.temuan') ?? '-' }}
                    </td>

                    <td valign="top">
                        {{ data_get($item, 'userMatrikByUser.saran') ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
