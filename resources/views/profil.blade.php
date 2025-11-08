@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <!-- ISI KONTEN -->
    <h2 style="margin-bottom: 16px; color: #2c3e50;">Profil Unit Penjaminan Mutu (UPM) FKIP ULM</h2>
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMQeLR2GCLAJXrarzyIkz-PWjd5xenPeOhqQ&s"
        alt="Logo UPM FKIP ULM" style="width:120px; float:right; margin-left:24px; margin-bottom:16px;">
    <p>
        <strong>Unit Penjaminan Mutu (UPM)</strong> Fakultas Keguruan dan Ilmu Pendidikan Universitas Lambung Mangkurat
        (FKIP ULM) merupakan unit yang bertanggung jawab dalam pelaksanaan penjaminan mutu akademik di lingkungan FKIP
        ULM.
    </p>
    <p>
        UPM FKIP ULM berperan dalam merancang, melaksanakan, memantau, dan mengevaluasi sistem penjaminan mutu internal
        untuk memastikan seluruh proses pendidikan, penelitian, dan pengabdian kepada masyarakat berjalan sesuai standar
        yang telah ditetapkan.
    </p>
    <h3 style="margin-top:24px; color: #34495e;">Visi</h3>
    <p>
        Menjadi unit penjaminan mutu yang unggul dalam mendukung tercapainya FKIP ULM sebagai fakultas pendidikan yang
        berstandar nasional dan internasional.
    </p>
    <h3 style="margin-top:24px; color: #34495e;">Misi</h3>
    <ul>
        <li>Mengembangkan sistem penjaminan mutu internal yang efektif dan berkelanjutan.</li>
        <li>Meningkatkan budaya mutu di lingkungan FKIP ULM.</li>
        <li>Melakukan monitoring dan evaluasi secara berkala terhadap pelaksanaan standar mutu.</li>
        <li>Mendukung peningkatan akreditasi program studi di FKIP ULM.</li>
    </ul>
    <h3 style="margin-top:24px; color: #34495e;">Struktur Organisasi</h3>
    <p>
        UPM FKIP ULM terdiri dari Ketua, Sekretaris, dan beberapa anggota yang berasal dari berbagai program studi di
        FKIP ULM.
    </p>
    <h3 style="margin-top:24px; color: #34495e;">Kontak</h3>
    <p>
        Email: upm.fkip@ulm.ac.id<br>
        Alamat: Gedung FKIP ULM, Jl. Brigjen H. Hasan Basry, Banjarmasin, Kalimantan Selatan
    </p>

    <script>
        // Dummy data, ganti dengan data asli jika tersedia
        const akreditasiData = {
            labels: ['Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi'],
            datasets: [{
                label: 'Jumlah Prodi',
                data: [21, 0, 0, 0],
                backgroundColor: ['#4e79a7', '#f28e2b', '#e15759', '#76b7b2'],
            }]
        };

        const dosenData = {
            labels: ['Guru Besar', 'Lektor Kepala', 'Lektor', 'Asisten Ahli', 'Tenaga Pengajar'],
            datasets: [{
                label: 'Jumlah Dosen',
                data: [10, 20, 40, 35, 3],
                backgroundColor: ['#59a14f', '#edc948', '#b07aa1', '#ff9da7'],
            }]
        };

        const mahasiswaData = {
            labels: ['2019', '2020', '2021', '2022', '2023'],
            datasets: [{
                label: 'Jumlah Mahasiswa',
                data: [1200, 1300, 1250, 1400, 1500],
                backgroundColor: '#4e79a7',
                borderColor: '#4e79a7',
                fill: false,
                tension: 0.1
            }]
        };

        new Chart(document.getElementById('akreditasiChart'), {
            type: 'doughnut',
            data: akreditasiData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        new Chart(document.getElementById('dosenChart'), {
            type: 'bar',
            data: dosenData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(document.getElementById('mahasiswaChart'), {
            type: 'line',
            data: mahasiswaData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <!--end::Script-->

@endsection
