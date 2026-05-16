@extends('layouts.app')

@section('title', 'Profil')

@section('content')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* =========================
   HERO
========================= */

.profile-hero {
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
    border-radius: 24px;
    padding: 36px;
    color: white;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(15,23,42,0.12);
}

.profile-hero::before {
    content: "";
    position: absolute;
    width: 280px;
    height: 280px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
    top: -120px;
    right: -80px;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.12);
    padding: 10px 16px;
    border-radius: 999px;
    margin-bottom: 18px;
    font-size: 13px;
    font-weight: 700;
}

.hero-title {
    font-size: 34px;
    font-weight: 800;
    line-height: 1.3;
    margin-bottom: 14px;
}

.hero-desc {
    max-width: 760px;
    line-height: 1.8;
    opacity: .9;
    font-size: 15px;
}

.hero-logo {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 24px;
    background: white;
    padding: 14px;
    box-shadow: 0 12px 28px rgba(0,0,0,0.15);
}

/* =========================
   CARD
========================= */

.content-card {
    background: white;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 10px 30px rgba(15,23,42,0.06);
    margin-bottom: 24px;
}

.section-title {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.section-title i {
    color: #2563eb;
}

.content-text {
    color: #475569;
    line-height: 1.9;
    font-size: 15px;
}

/* =========================
   VISION MISSION
========================= */

.vision-box {
    background: rgba(59,130,246,0.08);
    border-left: 5px solid #2563eb;
}

.mission-list {
    margin: 0;
    padding-left: 18px;
}

.mission-list li {
    margin-bottom: 14px;
    color: #475569;
    line-height: 1.8;
}

/* =========================
   CONTACT
========================= */

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 18px;
}

.contact-icon {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    background: rgba(59,130,246,0.1);
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.contact-label {
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 4px;
}

.contact-value {
    color: #64748b;
}

/* =========================
   CHART CARD
========================= */

.chart-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
}

.chart-card {
    background: white;
    border-radius: 24px;
    padding: 24px;
    box-shadow: 0 10px 30px rgba(15,23,42,0.06);
}

.chart-title {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 20px;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width: 768px){

    .profile-hero {
        padding: 26px;
    }

    .hero-title {
        font-size: 26px;
    }

    .hero-logo {
        width: 90px;
        height: 90px;
        margin-top: 20px;
    }

    .content-card {
        padding: 22px;
    }

}

</style>

<!-- HERO -->

<div class="profile-hero">

    <div class="row align-items-center">

        <div class="col-lg-9">

            <div class="hero-content">

                <div class="hero-badge">

                    <i class="fas fa-shield-halved"></i>
                    Sistem Penjaminan Mutu Internal

                </div>

                <div class="hero-title">
                    Profil Unit Penjaminan Mutu (UPM) FKIP ULM
                </div>

                <div class="hero-desc">

                    Unit Penjaminan Mutu Fakultas Keguruan dan Ilmu Pendidikan
                    Universitas Lambung Mangkurat bertanggung jawab dalam
                    pelaksanaan sistem penjaminan mutu akademik secara
                    berkelanjutan untuk mendukung budaya mutu di lingkungan FKIP ULM.

                </div>

            </div>

        </div>

        <div class="col-lg-3 text-lg-end text-center">

            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMQeLR2GCLAJXrarzyIkz-PWjd5xenPeOhqQ&s"
                 alt="Logo UPM FKIP ULM"
                 class="hero-logo">

        </div>

    </div>

</div>

<!-- TENTANG -->

<div class="content-card">

    <div class="section-title">

        <i class="fas fa-building-columns"></i>
        Tentang UPM FKIP ULM

    </div>

    <div class="content-text">

        <p>
            <strong>Unit Penjaminan Mutu (UPM)</strong> Fakultas Keguruan dan Ilmu Pendidikan
            Universitas Lambung Mangkurat (FKIP ULM) merupakan unit yang bertanggung jawab
            dalam pelaksanaan penjaminan mutu akademik di lingkungan FKIP ULM.
        </p>

        <p>
            UPM FKIP ULM berperan dalam merancang, melaksanakan, memantau,
            dan mengevaluasi sistem penjaminan mutu internal untuk memastikan
            seluruh proses pendidikan, penelitian, dan pengabdian kepada masyarakat
            berjalan sesuai standar yang telah ditetapkan.
        </p>

    </div>

</div>

<!-- VISI -->

<div class="content-card vision-box">

    <div class="section-title">

        <i class="fas fa-eye"></i>
        Visi

    </div>

    <div class="content-text">

        Menjadi unit penjaminan mutu yang unggul dalam mendukung tercapainya
        FKIP ULM sebagai fakultas pendidikan yang berstandar nasional dan internasional.

    </div>

</div>

<!-- MISI -->

<div class="content-card">

    <div class="section-title">

        <i class="fas fa-bullseye"></i>
        Misi

    </div>

    <ul class="mission-list">

        <li>
            Mengembangkan sistem penjaminan mutu internal yang efektif dan berkelanjutan.
        </li>

        <li>
            Meningkatkan budaya mutu di lingkungan FKIP ULM.
        </li>

        <li>
            Melakukan monitoring dan evaluasi secara berkala terhadap pelaksanaan standar mutu.
        </li>

        <li>
            Mendukung peningkatan akreditasi program studi di FKIP ULM.
        </li>

    </ul>

</div>

<!-- STRUKTUR -->

<div class="content-card">

    <div class="section-title">

        <i class="fas fa-sitemap"></i>
        Struktur Organisasi

    </div>

    <div class="content-text">

        UPM FKIP ULM terdiri dari Ketua, Sekretaris, dan beberapa anggota
        yang berasal dari berbagai program studi di FKIP ULM.

    </div>

</div>

<!-- KONTAK -->

<div class="content-card">

    <div class="section-title">

        <i class="fas fa-address-book"></i>
        Kontak

    </div>

    <div class="contact-item">

        <div class="contact-icon">
            <i class="fas fa-envelope"></i>
        </div>

        <div>

            <div class="contact-label">
                Email
            </div>

            <div class="contact-value">
                upm.fkip@ulm.ac.id
            </div>

        </div>

    </div>

    <div class="contact-item">

        <div class="contact-icon">
            <i class="fas fa-location-dot"></i>
        </div>

        <div>

            <div class="contact-label">
                Alamat
            </div>

            <div class="contact-value">
                Gedung FKIP ULM, Jl. Brigjen H. Hasan Basry,
                Banjarmasin, Kalimantan Selatan
            </div>

        </div>

    </div>

</div>

<!-- CHART -->

<div class="chart-grid">

    <div class="chart-card">

        <div class="chart-title">
            Statistik Akreditasi
        </div>

        <canvas id="akreditasiChart"></canvas>

    </div>

    <div class="chart-card">

        <div class="chart-title">
            Statistik Dosen
        </div>

        <canvas id="dosenChart"></canvas>

    </div>

    <div class="chart-card">

        <div class="chart-title">
            Statistik Mahasiswa
        </div>

        <canvas id="mahasiswaChart"></canvas>

    </div>

</div>

<script>

const akreditasiData = {
    labels: ['Unggul', 'Baik Sekali', 'Baik', 'Belum Terakreditasi'],
    datasets: [{
        label: 'Jumlah Prodi',
        data: [21, 0, 0, 0],
        backgroundColor: [
            '#2563eb',
            '#f59e0b',
            '#ef4444',
            '#14b8a6'
        ],
    }]
};

const dosenData = {
    labels: [
        'Guru Besar',
        'Lektor Kepala',
        'Lektor',
        'Asisten Ahli',
        'Tenaga Pengajar'
    ],
    datasets: [{
        label: 'Jumlah Dosen',
        data: [10, 20, 40, 35, 3],
        backgroundColor: [
            '#2563eb',
            '#14b8a6',
            '#8b5cf6',
            '#f59e0b',
            '#ef4444'
        ],
        borderRadius: 12
    }]
};

const mahasiswaData = {
    labels: ['2019', '2020', '2021', '2022', '2023'],
    datasets: [{
        label: 'Jumlah Mahasiswa',
        data: [1200, 1300, 1250, 1400, 1500],
        borderColor: '#2563eb',
        backgroundColor: 'rgba(37,99,235,0.08)',
        fill: true,
        tension: 0.4
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

@endsection