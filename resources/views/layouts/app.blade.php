<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-ARSIP — Sistem Pengelolaan Arsip</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .nav-group {
            width: 100%;
        }
        .nav-group-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            border: none;
            background: transparent;
            color: #ffffff;
            padding: 1rem 1.1rem;
            cursor: pointer;
            font: inherit;
            text-align: left;
        }
        .nav-group-toggle .nav-label {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            color: inherit;
        }
        .nav-group-toggle .nav-label i {
            width: 1.25rem;
            text-align: center;
        }
        .nav-group-toggle .submenu-caret {
            transition: transform 0.2s ease;
            color: inherit;
        }
        .nav-group.open .nav-group-toggle .submenu-caret {
            transform: rotate(180deg);
        }
        .nav-submenu {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.25s ease, opacity 0.25s ease;
        }
        .nav-group.open .nav-submenu {
            max-height: 260px;
            opacity: 1;
        }
        .nav-subitem {
            display: block;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-size: 0.95rem;
        }
        .nav-subitem.active,
        .nav-subitem:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }
        .topbar .dropdown-menu-wrapper {
            position: relative;
        }
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 0.5rem);
            min-width: 220px;
            background: rgba(15, 23, 42, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.85rem;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.35);
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
            z-index: 20;
        }
        .dropdown-menu.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .dropdown-link,
        .dropdown-menu button.dropdown-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.85rem 1rem;
            color: #edf2f7;
            background: transparent;
            border: none;
            text-align: left;
            text-decoration: none;
            font-size: 0.95rem;
            cursor: pointer;
        }
        .dropdown-link:hover,
        .dropdown-menu button.dropdown-link:hover {
            background: rgba(255, 255, 255, 0.08);
        }
        .dropdown-menu .divider {
            height: 1px;
            margin: 0.2rem 0;
            background: rgba(255, 255, 255, 0.08);
        }
        .notification-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 0.5rem);
            width: 300px;
            max-height: 360px;
            background: rgba(15, 23, 42, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.85rem;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.35);
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
            z-index: 20;
        }
        .notification-menu.open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .notification-menu .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            color: #ffffff;
            font-weight: 600;
        }
        .notification-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.95rem 1rem;
            color: #e2e8f0;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .notification-item .dot {
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            margin-top: 0.25rem;
            background: #38bdf8;
            flex-shrink: 0;
        }
        .notification-item span {
            font-size: 0.95rem;
            line-height: 1.4;
        }
        .notification-menu .view-all {
            display: block;
            padding: 0.85rem 1rem;
            text-align: center;
            color: #93c5fd;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .notification-menu .view-all:hover {
            background: rgba(255, 255, 255, 0.06);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-name">E-ARSIP</span>
                    <span class="brand-sub">Catatan Institusional</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>

                <div class="nav-group {{ request()->routeIs('arsip.*') ? 'open' : '' }}">
                    <button type="button" class="nav-item nav-group-toggle" onclick="toggleSubmenu('arsipSubmenu')">
                        <span class="nav-label">
                            <i class="fas fa-folder-open"></i>
                            <span>Archival Reports</span>
                        </span>
                        <i class="fas fa-chevron-down submenu-caret"></i>
                    </button>
                    <div class="nav-submenu" id="arsipSubmenu">
                        <a href="{{ route('arsip.index') }}" class="nav-subitem {{ request()->routeIs('arsip.index') ? 'active' : '' }}">Lihat Arsip</a>
                        <a href="{{ route('arsip.create') }}" class="nav-subitem {{ request()->routeIs('arsip.create') ? 'active' : '' }}">Tambah Arsip</a>
                    </div>
                </div>

                <a href="{{ route('export.index') }}" class="nav-item {{ request()->routeIs('export.*') ? 'active' : '' }}">
                    <i class="fas fa-file-excel"></i>
                    <span>Export Excel</span>
                </a>
                <a href="{{ route('ai.index') }}" class="nav-item {{ request()->routeIs('ai.*') ? 'active' : '' }}">
                    <i class="fas fa-robot"></i>
                    <span>AI Recommendation</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Sistem Pengelolaan Arsip</h1>
                </div>
                <div class="topbar-center">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search archives, documents, or logs...">
                    </div>
                </div>
                <div class="topbar-right">
                    <div class="date-badge">
                        <i class="fas fa-calendar"></i>
                        <span id="currentDate"></span>
                    </div>
                    <div class="dropdown-menu-wrapper">
                        <button class="icon-btn" type="button" onclick="toggleMenu('notificationMenu')">
                            <i class="fas fa-bell"></i><span class="badge">5</span>
                        </button>
                        <div class="notification-menu" id="notificationMenu">
                            <div class="notification-header">
                                <span>Notifikasi</span>
                                <span class="badge">5</span>
                            </div>
                            <a href="#" class="notification-item">
                                <span class="dot"></span>
                                <span>Arsip baru ditambahkan</span>
                            </a>
                            <a href="#" class="notification-item">
                                <span class="dot"></span>
                                <span>Arsip berhasil diedit</span>
                            </a>
                            <a href="#" class="notification-item">
                                <span class="dot"></span>
                                <span>Arsip berhasil dihapus</span>
                            </a>
                            <a href="#" class="notification-item">
                                <span class="dot"></span>
                                <span>Export Excel berhasil</span>
                            </a>
                            <a href="#" class="notification-item">
                                <span class="dot"></span>
                                <span>Arsip menunggu review</span>
                            </a>
                            <a href="#" class="view-all">Lihat semua notifikasi</a>
                        </div>
                    </div>
                    <div class="dropdown-menu-wrapper">
                        <button class="icon-btn" type="button" onclick="toggleMenu('settingsMenu')">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-menu" id="settingsMenu">
                            <a href="{{ route('profile') }}" class="dropdown-link">Profil Admin</a>
                            <a href="{{ route('password.change') }}" class="dropdown-link">Ubah Password</a>
                            <a href="{{ route('settings.theme') }}" class="dropdown-link">Tema Tampilan</a>
                            <a href="{{ route('settings.notifications') }}" class="dropdown-link">Pengaturan Notifikasi</a>
                            <div class="divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-link">Logout</button>
                            </form>
                        </div>
                    </div>
                    <div class="user-avatar">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin User' }}&background=1a3a5c&color=fff" alt="User">
                        <div class="user-info">
                            <span class="user-name">{{ auth()->user()->name ?? 'Admin User' }}</span>
                            <span class="user-role">Administrator</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
    <script>
        // Set current date
        const now = new Date();
        const options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
        document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', options);

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        function toggleSubmenu(menuId) {
            const submenu = document.getElementById(menuId);
            if (!submenu) return;
            submenu.parentElement.classList.toggle('open');
        }

        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            if (!menu) return;
            menu.classList.toggle('open');
        }

        document.addEventListener('click', function(event) {
            ['notificationMenu', 'settingsMenu'].forEach(function(menuId) {
                const menu = document.getElementById(menuId);
                if (!menu) return;
                const wrapper = menu.parentElement;
                if (!wrapper.contains(event.target)) {
                    menu.classList.remove('open');
                }
            });
        });
    </script>
</body>
</html>
