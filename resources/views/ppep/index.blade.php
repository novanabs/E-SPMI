<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPEPP — Siklus Penjaminan Mutu Internal FKIP ULM</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/ulm.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    *,::before,::after {margin:0;padding:0;box-sizing:border-box}

    body {
        font-family:'Inter',sans-serif;
        background:linear-gradient(135deg,rgba(37,99,235,.92),rgba(15,23,42,.96));
        min-height:100vh;color:#fff;overflow-x:hidden
    }

    .page {
        min-height:100vh;display:flex;flex-direction:column;
        align-items:center;justify-content:center;text-align:center;
        padding:60px 24px;position:relative;overflow:hidden
    }
    .page::before {
        content:'';position:absolute;
        width:500px;height:500px;border-radius:50%;
        background:rgba(255,255,255,.05);
        top:-220px;right:-160px
    }
    .page::after {
        content:'';position:absolute;
        width:320px;height:320px;border-radius:50%;
        background:rgba(255,255,255,.04);
        bottom:-140px;left:-100px
    }

    .content {position:relative;z-index:2;max-width:640px;width:100%}

    .logo-box {
        width:110px;height:110px;border-radius:24px;
        background:rgba(255,255,255,.12);backdrop-filter:blur(10px);
        display:flex;align-items:center;justify-content:center;
        margin:0 auto 28px
    }
    .logo-box img {width:70px}

    .badge {
        display:inline-flex;align-items:center;gap:8px;
        background:rgba(255,255,255,.12);
        padding:10px 18px;border-radius:999px;
        font-size:13px;font-weight:700;margin-bottom:28px
    }

    .content h1 {
        font-size:clamp(40px,8vw,64px);font-weight:800;
        line-height:1.15;margin-bottom:20px;
        letter-spacing:-1.5px
    }

    .content .desc {
        font-size:16px;line-height:1.9;opacity:.9;
        margin-bottom:44px
    }

    /* ── TOGGLE BUTTON ── */
    .btn-group {display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap}

    .toggle-btn {
        background:rgba(255,255,255,.12);backdrop-filter:blur(10px);
        border:1px solid rgba(255,255,255,.12);
        color:#fff;border-radius:16px;
        min-height:56px;padding:0 44px;
        font-size:15px;font-weight:700;cursor:pointer;
        transition:.3s;display:inline-flex;align-items:center;gap:10px
    }
    .toggle-btn:hover {background:rgba(255,255,255,.18);transform:translateY(-2px)}
    .toggle-btn .arr {transition:transform .4s}
    .toggle-btn.open .arr {transform:rotate(180deg)}

    .login-page-btn {
        background:rgba(255,255,255,.10);backdrop-filter:blur(10px);
        border:1px solid rgba(255,255,255,.10);color:#fff;
        border-radius:16px;min-height:56px;padding:0 36px;
        font-size:15px;font-weight:700;text-decoration:none;
        display:inline-flex;align-items:center;gap:8px;transition:.3s
    }
    .login-page-btn:hover {background:rgba(255,255,255,.18);transform:translateY(-2px);color:#fff}

    /* ── CARDS ── */
    .cards-area {
        display:none;max-width:1080px;margin:0 auto;padding:0 24px 80px
    }
    .cards-area.show {display:block;animation:fade .6s ease}
    @keyframes fade {
        from{opacity:0;transform:translateY(30px)}
        to{opacity:1;transform:translateY(0)}
    }

    .cards-area h2 {font-size:22px;font-weight:800;margin-bottom:28px;text-align:center}

    .grid {
        display:grid;
        grid-template-columns:repeat(auto-fill,minmax(250px,1fr));
        gap:18px
    }

    .card {
        background:rgba(255,255,255,.10);backdrop-filter:blur(12px);
        border:1px solid rgba(255,255,255,.08);border-radius:18px;
        padding:32px 20px 24px;text-decoration:none;color:#fff;
        transition:all .35s cubic-bezier(.34,1.56,.64,1);
        display:flex;flex-direction:column;align-items:center;text-align:center
    }
    .card:hover {
        transform:translateY(-6px);
        background:rgba(255,255,255,.18);
        border-color:rgba(255,255,255,.16)
    }

    .card .ico {
        width:60px;height:60px;border-radius:14px;
        display:flex;align-items:center;justify-content:center;
        font-size:28px;margin-bottom:16px;
        background:rgba(255,255,255,.08);
        transition:transform .35s cubic-bezier(.34,1.56,.64,1)
    }
    .card:hover .ico {transform:scale(1.1);background:rgba(255,255,255,.14)}

    .card .name {font-size:16px;font-weight:700;margin-bottom:4px}
    .card .type {
        font-size:12px;font-weight:600;color:rgba(255,255,255,.40);
        text-transform:uppercase;letter-spacing:.4px;margin-bottom:16px
    }
    .card .go {
        font-size:13px;font-weight:700;
        display:inline-flex;align-items:center;gap:6px;
        transition:gap .3s;color:#93b4f5
    }
    .card:hover .go {gap:10px}

    footer {
        text-align:center;padding:32px 24px;
        color:rgba(255,255,255,.25);font-size:13px;
        border-top:1px solid rgba(255,255,255,.05)
    }

    @media(max-width:640px) {
        .page {padding:48px 16px}
        .grid {grid-template-columns:1fr 1fr;gap:12px}
    }
    @media(max-width:420px) {
        .grid {grid-template-columns:1fr}
    }
</style>
</head>
<body>

<div class="page">
    <div class="content">
        <div class="logo-box">
            <img src="{{ asset('img/ulm.png') }}" alt="ULM">
        </div>
        <div class="badge">
            <i class="bi bi-shield-check"></i>
            Internal Quality Assurance System
        </div>
        <h1>PPEPP<br>FKIP ULM</h1>
        <p class="desc">
            Siklus Penjaminan Mutu Internal — monitoring dokumen
            Penetapan, Pelaksanaan, Evaluasi, Pengendalian, dan Peningkatan
            mutu pendidikan di lingkungan FKIP Universitas Lambung Mangkurat.
        </p>
        <div class="btn-group">
            @guest
            <a href="{{ route('login') }}" class="login-page-btn">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </a>
            @endguest
            <button class="toggle-btn" id="toggleBtn">
            FKIP +21 Jurusan <span class="arr">↓</span>
            </button>
        </div>
    </div>
</div>

<div class="cards-area" id="cardsWrap">
    <h2>Pilih Unit Kerja</h2>
    <div class="grid">
        @php $sorted = $entities->sortBy(fn($e) => $e->role === 'admin_FKIP' ? 0 : 1) @endphp
        @foreach ($sorted as $entity)
            @php $isFkip = $entity->role === 'admin_FKIP' @endphp
            <a href="{{ route('ppepp.show', $entity->id) }}" class="card">
                <div class="ico">{{ $isFkip ? '🏛️' : '📚' }}</div>
                <div class="name">{{ $isFkip ? 'FKIP ULM' : $entity->homebase }}</div>
                <div class="type">{{ $isFkip ? 'Fakultas' : 'Program Studi' }}</div>
                <span class="go">Lihat PPEPP <i class="bi bi-arrow-right"></i></span>
            </a>
        @endforeach
    </div>
</div>

<footer>&copy; {{ date('Y') }} E-SPMI FKIP ULM — Quality Assurance Information System</footer>

<script>
document.getElementById('toggleBtn').addEventListener('click',function(){
    const w=document.getElementById('cardsWrap'),s=w.classList.toggle('show');
    this.classList.toggle('open',s);this.querySelector('.arr').textContent=s?'↑':'↓';
    if(s){setTimeout(()=>w.scrollIntoView({behavior:'smooth',block:'start'}),120);
    w.querySelectorAll('.card').forEach((c,i)=>{c.style.opacity='0';c.style.transform='translateY(20px)';
    requestAnimationFrame(()=>{c.style.transition=`all .45s cubic-bezier(.34,1.56,.64,1) ${i*.06}s`;c.style.opacity='1';c.style.transform='none'})})}
});
</script>
</body>
</html>
