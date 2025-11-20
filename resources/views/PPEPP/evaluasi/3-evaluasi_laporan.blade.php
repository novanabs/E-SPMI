@extends('layouts.app')

@section('title', 'Evaluasi Laporan')

@section('content')

    <h3 class="mb-4">Unggah Laporan per Aspek</h3>

    <!-- Aspek Pendidikan -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Aspek PENDIDIKAN</div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">1. Laporan Evaluasi (AMI)</label>
                <input type="file" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">2. Laporan Monev Jurusan (permintaan FKIP)</label>
                <input type="file" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">3. Laporan Survey</label>
                <input type="file" class="form-control">
            </div>
        </div>
    </div>

    <!-- Aspek Penelitian -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Aspek PENELITIAN</div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">1. Laporan Evaluasi (AMI)</label>
                <input type="file" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">2. Laporan Monev Jurusan (permintaan FKIP)</label>
                <input type="file" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">3. Laporan Survey</label>
                <input type="file" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">4. E-SPMI Pengendalian</label>
                <input type="file" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">5. E-SPMI Peningkatan</label>
                <input type="file" class="form-control">
            </div>
        </div>
    </div>

    <!-- Aspek Pengabdian -->
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">Aspek PENGABDIAN</div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">1. Laporan Evaluasi (AMI)</label>
                <input type="file" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">2. Laporan Monev Jurusan (permintaan FKIP)</label>
                <input type="file" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">3. Laporan Survey</label>
                <input type="file" class="form-control">
            </div>
        </div>
    </div>

    <button class="btn btn-primary">Simpan Data</button>


    <script>
        $(document).ready(function() {
            $('#akreditasiTable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>


@endsection
