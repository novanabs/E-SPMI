<div style="font-family: Arial, sans-serif; font-size: 14px">

    <h3 style="text-align:center">
        BERITA ACARA HASIL AMI <br>
        JURUSAN {{ strtoupper(auth()->user()->homebase) }} <br>

    </h3>

    <br>

    <table width="100%" style="margin-bottom:15px">
        <tr>
            <td><strong>Dibuat oleh</strong></td>
            <td>: {{ $generated_by }}</td>
            <td><strong>Tanggal</strong></td>
            <td>: {{ $tanggal }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td>: {{ $status }}</td>
            <td><strong>Peringkat</strong></td>
            <td>: {{ $peringkat }}</td>
        </tr>
        <tr>
            <td><strong>Total Nilai</strong></td>
            <td colspan="3">: {{ number_format($nilai, 2) }}</td>
        </tr>
    </table>

    <table border="1" width="100%" cellpadding="6" cellspacing="0">
        <thead style="background:#f2f2f2">
            <tr>
                <th width="5%">No</th>
                <th>Elemen</th>
                <th width="8%">Bobot</th>
                <th width="8%">Skor</th>
                <th width="10%">Total</th>
            </tr>
        </thead>
        <tbody>

            @php
                $grouped = $elemen->groupBy(fn($item) => $item->kriteria->name ?? 'Tanpa Kriteria');
            @endphp

            @foreach ($grouped as $namaKriteria => $items)
                {{-- BARIS KRITERIA --}}
                <tr style="background:#e9ecef">
                    <td colspan="5">
                        <strong>KRITERIA: {{ $namaKriteria }}</strong>
                    </td>
                </tr>

                {{-- BARIS ELEMEN --}}
                @foreach ($items as $item)
                    <tr>
                        <td align="center">{{ $item->nomor }}</td>
                        <td>{{ $item->elemen }}</td>
                        <td align="center">{{ $item->poin }}</td>
                        <td align="center">
                            {{ $item->userMatrik->jawaban ?? '-' }}
                        </td>
                        <td align="center">
                            {{ $item->userMatrik ? number_format($item->userMatrik->jawaban * $item->poin, 2) : '-' }}
                        </td>
                    </tr>
                @endforeach
            @endforeach


        </tbody>
    </table>
    <br><br>

    <table width="100%" style="margin-top:50px; font-size:14px">
        <tr>
            <td width="60%"></td>
            <td align="center">
                ________________, {{ $tanggal }}<br>
                Ketua {{ auth()->user()->homebase ?? '' }}
                <br><br><br><br><br>

                <strong>
                    {{ auth()->user()->ketua ?? '_______________________________' }}
                </strong>
                <br>
                NIP. {{ auth()->user()->nip ?? '' }}
            </td>
        </tr>
    </table>


</div>
