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
                    {{ $userJurusan->homebase ?? auth()->user()->homebase }}
                </strong><br>
            </td>
            <td width="15%"></td>
        </tr>
    </table>

    <hr>

    <h3 style="text-align:center">HASIL AUDIT MUTU INTERNAL</h3>

    <br>

    <table width="50%" style="margin-bottom:15px">
        <tr>
            <td><strong>Tanggal Audit</strong></td>
            <td>: {{ $tanggal }}</td>
        </tr>
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

    {{-- CHART RADAR PER ASPEK --}}
    <br>
    {{-- <h4 style="text-align:center; margin:0 0 10px 0;">Grafik Capaian Per Aspek</h4> --}}
    <table width="100%" border="1" cellpadding="6" cellspacing="0"
        style="border-collapse:collapse; font-family:Arial; font-size:14px">
        <tr style="background:#f2f2f2; text-align:center">
            <th width="40%">Penilaian Mandiri Jurusan</th>
            <th width="40%">{{ $showAuditor ? 'Penilaian Auditor' : 'Penilaian UPM' }}</th>
            <th width="20%">Selisih</th>
        </tr>
        <tr>
            <td valign="top">
                Nilai Akreditasi : <strong>{{ number_format($totalJurusan, 2) }}</strong><br>
                Status : <strong>{{ $statusJurusan }}</strong><br>
                Masa Berlaku : <strong>{{ $masaJurusan }}</strong>
            </td>

            <td valign="top">
                Nilai Akreditasi : <strong>{{ number_format($totalAuditor, 2) }}</strong><br>
                Status : <strong>{{ $statusAuditor }}</strong><br>
                Masa Berlaku : <strong>{{ $masaAuditor }}</strong>
            </td>

            <td align="center" valign="middle">
                <strong>{{ number_format($selisih, 2) }}</strong>
            </td>
        </tr>
    </table>

    
    <div style="text-align:center;">
        <img src="{{ $radarChart }}" width="520" height="480" alt="Radar Chart">
    </div>
</div>
