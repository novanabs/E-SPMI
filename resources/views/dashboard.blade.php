@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <h1>Dashboard Statistik FKIP ULM</h1>
    <div class="row stats">
        <div class="col-6 card">
            <h2>Statistik Akreditasi</h2>
            <canvas id="akreditasiChart"></canvas>
        </div>
        <div class="col-6 card">
            <h2>Data Dosen</h2>
            <canvas id="dosenChart"></canvas>
        </div>
        <!-- <div class="col-4 card">
                            <h2>Data Mahasiswa</h2>
                            <canvas id="mahasiswaChart"></canvas>
                        </div> -->
    </div>

    <script>
        // Dummy data, ganti dengan data asli jika tersedia
        const akreditasiData = {
            labels: [
                "Unggul",
                "Baik Sekali",
                "Baik",
                "Belum Terakreditasi",
            ],
            datasets: [{
                label: "Jumlah Prodi",
                data: [21, 0, 0, 0],
                backgroundColor: [
                    "#4e79a7",
                    "#f28e2b",
                    "#e15759",
                    "#76b7b2",
                ],
            }, ],
        };

        const dosenData = {
            labels: [
                "Guru Besar",
                "Lektor Kepala",
                "Lektor",
                "Asisten Ahli",
                "Tenaga Pengajar",
            ],
            datasets: [{
                label: "Jumlah Dosen",
                data: [10, 20, 40, 35, 3],
                backgroundColor: [
                    "#59a14f",
                    "#edc948",
                    "#b07aa1",
                    "#ff9da7",
                ],
            }, ],
        };

        const mahasiswaData = {
            labels: ["2019", "2020", "2021", "2022", "2023"],
            datasets: [{
                label: "Jumlah Mahasiswa",
                data: [1200, 1300, 1250, 1400, 1500],
                backgroundColor: "#4e79a7",
                borderColor: "#4e79a7",
                fill: false,
                tension: 0.1,
            }, ],
        };

        new Chart(document.getElementById("akreditasiChart"), {
            type: "doughnut",
            data: akreditasiData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom"
                    }
                },
            },
        });

        new Chart(document.getElementById("dosenChart"), {
            type: "bar",
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
                },
            },
        });

        new Chart(document.getElementById("mahasiswaChart"), {
            type: "line",
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
                },
            },
        });
    </script>

@endsection
