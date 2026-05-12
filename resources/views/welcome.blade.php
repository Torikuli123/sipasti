<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIPASTI') }}</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: #0F172A;
            background: #F8FAFC;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: #F8FAFC;
        }

        button,
        input,
        select {
            font: inherit;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .page {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: min(1160px, calc(100% - 32px));
            margin: 0 auto;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 0;
            gap: 16px;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 14px;
        }

        .logo-mark {
            width: 42px;
            height: 42px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #0F172A 0%, #1D4ED8 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 1.05rem;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.05;
        }

        .logo-title {
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .logo-sub {
            color: #64748B;
            font-size: 0.82rem;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .menu a {
            color: #334155;
            font-weight: 600;
            transition: color .2s ease;
        }

        .menu a:hover {
            color: #0F172A;
        }

        .action-btn {
            border-radius: 999px;
            padding: 12px 22px;
            font-weight: 700;
            border: 1px solid transparent;
            background: #1D4ED8;
            color: #fff;
            transition: transform .2s ease, background .2s ease;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            background: #2563EB;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(340px, 0.95fr);
            gap: 32px;
            align-items: center;
            padding: 40px 0 52px;
        }

        .hero-copy {
            max-width: 560px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #1D4ED8;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .hero-title {
            margin: 0;
            font-size: clamp(3rem, 5vw, 4.6rem);
            line-height: 0.98;
            letter-spacing: -0.04em;
            color: #0F172A;
        }

        .hero-text {
            margin: 24px 0 32px;
            max-width: 560px;
            color: #475569;
            font-size: 1.03rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .hero-visual {
            display: grid;
            gap: 22px;
            justify-items: center;
        }

        .hero-card {
            width: 100%;
            background: #ffffff;
            border: 1px solid #E2E8F0;
            border-radius: 32px;
            padding: 32px;
            box-shadow: 0 28px 48px rgba(15, 23, 42, 0.08);
        }

        .hero-card__image {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 32px;
            display: grid;
            place-items: center;
            background: linear-gradient(180deg, #EFF6FF 0%, #FFFFFF 100%);
        }

        .hero-card__image span {
            width: 120px;
            height: 120px;
            border-radius: 28px;
            background: #1D4ED8;
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 2rem;
            font-weight: 800;
        }

        .features {
            padding-bottom: 52px;
        }

        .section-head {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 28px;
        }

        .section-title {
            margin: 0;
            font-size: 2.2rem;
            line-height: 1.05;
            font-weight: 800;
            color: #0F172A;
        }

        .section-description {
            margin: 0;
            max-width: 640px;
            color: #64748B;
            line-height: 1.8;
            font-size: 1rem;
        }

        .feature-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .feature-card {
            background: #ffffff;
            border: 1px solid #E2E8F0;
            border-radius: 28px;
            padding: 26px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            min-height: 204px;
        }

        .feature-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: rgba(59, 130, 246, 0.12);
            color: #1D4ED8;
            font-size: 1.1rem;
        }

        .feature-title {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: #0F172A;
        }

        .feature-text {
            margin: 0;
            color: #475569;
            line-height: 1.75;
            font-size: 0.95rem;
        }

        .footer {
            width: 100%;
            border-top: 1px solid #E2E8F0;
            padding: 20px 0 26px;
            background: #ffffff;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            width: min(1160px, calc(100% - 32px));
            margin: 0 auto;
            color: #64748B;
            font-size: 0.95rem;
        }

        .footer-links {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: #475569;
            font-weight: 600;
        }

        .footer-links a:hover {
            color: #0F172A;
        }

        @media (max-width: 960px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .feature-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .container {
                width: calc(100% - 24px);
            }
        }

        @media (max-width: 680px) {
            .navbar {
                flex-direction: column;
                align-items: stretch;
            }

            .menu {
                justify-content: center;
                flex-wrap: wrap;
                gap: 14px;
            }

            .hero-card {
                padding: 24px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="container">
            <header class="navbar">
                <a href="{{ route('home') }}" class="logo">
                    <span class="logo-mark">SP</span>
                    <span class="logo-text">
                        <span class="logo-title">SIPASTI</span>
                        <span class="logo-sub">Sistem Informasi Pencatatan Arsip Statis Terintegrasi</span>
                    </span>
                </a>
                <nav class="menu">
                    <a class="nav-item" href="#home">Beranda</a>
                    <a class="nav-item" href="#fitur">Fitur</a>
                    <a class="nav-item" href="#footer">Kontak</a>
                    <a class="action-btn" style="color : white;" href="{{ route('login') }}">Masuk</a>
                </nav>
            </header>
        </div>

        <main class="container" id="home">
            <section class="hero">
                <div class="hero-copy">
                    <p class="hero-eyebrow">SIPASTI Modern</p>
                    <h1 class="hero-title">Kelola Arsip Digital Lebih Mudah</h1>
                    <p class="hero-text">Simpan, akses, dan kelola dokumen penting dengan sistem pencatatan arsip statis
                        terintegrasi yang aman, cepat, dan handal.</p>
                    <div class="hero-buttons">
                        <a class="action-btn" href="{{ route('login') }}">Mulai Sekarang</a>
                        <a class="action-btn" style="background:#E2E8F0; color:#0F172A;"
                            href="{{ route('login') }}">Masuk</a>
                    </div>
                </div>
                <aside class="hero-visual">
                    <div class="hero-card"
                        style="padding: 0; overflow: hidden; border: none; background: transparent; box-shadow: 0 32px 64px rgba(15, 23, 42, 0.15);">
                        <img src="{{ asset('images/hero_archiving.png') }}" alt="SIPASTI Hero"
                            style="width: 100%; display: block; border-radius: 32px;">
                    </div>
                </aside>
            </section>
        </main>

        <section class="container features" id="fitur">
            <div class="section-head">
                <h2 class="section-title">Fitur Unggulan Kami</h2>
                <p class="section-description">Dirancang untuk memudahkan administrasi perkantoran modern dengan standar
                    keamanan tinggi.</p>
            </div>
            <div class="feature-grid">
                <article class="feature-card">
                    <div class="feature-icon">📁</div>
                    <h3 class="feature-title">Manajemen Arsip</h3>
                    <p class="feature-text">Akurasi dan struktur penyimpanan arsip yang rapi membuat dokumen selalu
                        mudah diakses.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon">🔍</div>
                    <h3 class="feature-title">Pencarian Cepat</h3>
                    <p class="feature-text">Temukan arsip berdasarkan kata kunci, nomor, atau judul dengan cepat.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">Keamanan Data</h3>
                    <p class="feature-text">Lindungi data arsip dengan kontrol akses dan keamanan yang handal.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon">📤</div>
                    <h3 class="feature-title">Export Laporan</h3>
                    <p class="feature-text">Ekspor arsip dan laporan ke Excel untuk audit, backup, dan analisis.</p>
                </article>
            </div>
        </section>

        <footer class="footer" id="footer">
            <div class="footer-inner">
                <span>© {{ date('Y') }} SIPASTI</span>
                <div class="footer-links">
                    <a href="#home">Beranda</a>
                    <a href="#fitur">Fitur</a>
                    <a href="#footer">Kontak</a>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>