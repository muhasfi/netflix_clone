<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Codeflix</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.6.0-web/css/all.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cf-red: #E50914;
            --cf-red-dim: rgba(229,9,20,0.15);
            --cf-dark: #0f0f0f;
            --cf-card: #181818;
            --cf-surface: #222;
            --cf-border: rgba(255,255,255,0.08);
            --cf-muted: #999;
            --cf-text: #e5e5e5;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--cf-dark);
            color: var(--cf-text);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .cf-navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 0 4%;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(180deg, rgba(0,0,0,0.95) 0%, transparent 100%);
            transition: background 0.3s;
        }
        .cf-navbar.scrolled { background: rgba(0,0,0,0.97); }
        .cf-navbar-left { display: flex; align-items: center; gap: 32px; }
        .cf-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 28px;
            color: var(--cf-red);
            letter-spacing: 2px;
            text-decoration: none;
            flex-shrink: 0;
        }
        .cf-logo img {
            width: 70px;
            height: auto;
        }
        .cf-nav-links { display: flex; gap: 20px; list-style: none; }
        .cf-nav-links a { color: #ccc; font-size: 13px; text-decoration: none; transition: color .2s; }
        .cf-nav-links a:hover { color: #fff; }
        .cf-nav-links .dropdown-toggle::after { display: none; }
        .cf-nav-links .dropdown-menu {
            background: rgba(15,15,15,0.98);
            border: 1px solid var(--cf-border);
            border-radius: 8px;
            padding: 8px 0;
            min-width: 200px;
        }
        .cf-nav-links .dropdown-item {
            color: #ccc; font-size: 13px; padding: 8px 16px;
        }
        .cf-nav-links .dropdown-item:hover { background: var(--cf-surface); color: #fff; }
        .cf-nav-right { display: flex; align-items: center; gap: 20px; }
        .cf-search-form { display: flex; align-items: center; position: relative; }
        .cf-search-input {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 6px;
            color: #fff;
            font-size: 13px;
            padding: 7px 36px 7px 12px;
            width: 200px;
            font-family: 'Inter', sans-serif;
            transition: width .3s, background .2s;
        }
        .cf-search-input:focus { outline: none; background: rgba(255,255,255,0.12); width: 240px; }
        .cf-search-input::placeholder { color: var(--cf-muted); }
        .cf-search-icon { position: absolute; right: 10px; color: var(--cf-muted); font-size: 13px; cursor: pointer; }
        .cf-icon-btn { background: none; border: none; color: #ccc; font-size: 18px; cursor: pointer; padding: 4px; position: relative; }
        .cf-icon-btn:hover { color: #fff; }
        .cf-avatar {
            width: 34px; height: 34px; border-radius: 6px;
            background: var(--cf-red);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 600; cursor: pointer;
            text-decoration: none; color: #fff;
        }
        .cf-dropdown .dropdown-menu {
            background: rgba(15,15,15,0.98);
            border: 1px solid var(--cf-border);
            border-radius: 8px;
            right: 0; left: auto;
            min-width: 160px;
        }
        .cf-dropdown .dropdown-item { color: #ccc; font-size: 13px; padding: 9px 16px; }
        .cf-dropdown .dropdown-item:hover { background: var(--cf-surface); color: #fff; }
        .cf-notification-menu { min-width: 280px !important; }
        .cf-notif-item { display: flex; align-items: flex-start; gap: 10px; padding: 10px 16px; border-bottom: 1px solid var(--cf-border); }
        .cf-notif-item:last-child { border-bottom: none; }
        .cf-notif-img { width: 44px; height: 44px; border-radius: 6px; object-fit: cover; flex-shrink: 0; background: var(--cf-surface); }
        .cf-notif-text { font-size: 12px; color: #ccc; line-height: 1.4; }
        .cf-notif-date { font-size: 11px; color: var(--cf-muted); margin-top: 2px; }
        .cf-hamburger { display: none; background: none; border: none; color: #fff; font-size: 20px; cursor: pointer; }

        /* MOBILE NAV */
        .cf-mobile-menu {
            display: none;
            position: fixed;
            top: 64px; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.97);
            z-index: 999;
            padding: 24px;
            overflow-y: auto;
        }
        .cf-mobile-menu.open { display: block; }
        .cf-mobile-links { list-style: none; }
        .cf-mobile-links li { border-bottom: 1px solid var(--cf-border); }
        .cf-mobile-links a { display: block; padding: 14px 0; color: #ccc; font-size: 15px; text-decoration: none; }
        .cf-mobile-search { width: 100%; background: var(--cf-surface); border: 1px solid var(--cf-border); border-radius: 8px; color: #fff; font-size: 14px; padding: 10px 14px; margin-bottom: 20px; font-family: 'Inter', sans-serif; }

        /* ── MAIN CONTENT ── */
        .cf-main { padding-top: 64px; }

        /* ── FOOTER ── */
        .cf-footer {
            padding: 32px 4%;
            border-top: 1px solid var(--cf-border);
            text-align: center;
            color: var(--cf-muted);
            font-size: 13px;
            margin-top: 48px;
        }

        /* ── SWIPER CARDS ── */
        .cf-section { padding: 0 4% 32px; }
        .cf-section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 22px;
            letter-spacing: 1px;
            color: var(--cf-text);
            margin-bottom: 14px;
        }
        .swiper-slide .card {
            background: var(--cf-card);
            border: 1px solid var(--cf-border);
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: transform .25s, box-shadow .25s;
            position: relative;
        }
        .swiper-slide .card:hover { transform: scale(1.04); box-shadow: 0 8px 32px rgba(0,0,0,0.6); }
        .swiper-slide .card img { width: 100%; aspect-ratio: 2/3; object-fit: cover; display: block; }
        .badge-rating {
            position: absolute; top: 8px; right: 8px;
            background: rgba(0,0,0,0.8) !important;
            border: 1px solid rgba(255,255,255,0.1);
            font-size: 11px; display: flex; align-items: center; gap: 4px;
        }
        .star-rating { width: 12px; height: 12px; }
        .swiper-button-next, .swiper-button-prev { color: #fff !important; }
        .swiper-button-next::after, .swiper-button-prev::after { font-size: 20px !important; }
        .swiper-pagination-bullet { background: var(--cf-muted) !important; }
        .swiper-pagination-bullet-active { background: var(--cf-red) !important; }

        @media (max-width: 768px) {
            .cf-nav-links, .cf-search-form { display: none; }
            .cf-hamburger { display: block; }
            .cf-logo img { height: 26px; }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- NAVBAR -->
    <nav class="cf-navbar" id="cf-navbar">
        <div class="cf-navbar-left">

            <button class="cf-hamburger" id="cf-hamburger">
                <i class="fa-solid fa-bars"></i>
            </button>

            <a href="/" class="cf-logo">
                <img src="{{ asset('assets/img/codeflix_logo.png') }}">
            </a>

            <ul class="cf-nav-links">
                <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('movies.index') }}" class="{{ request()->is('movies*') ? 'active' : '' }}">Movies</a></li>
            </ul>
        </div>

        <div class="cf-nav-right">

            <!-- SEARCH -->
            <form action="{{ route('movies.search') }}" method="GET" class="cf-search-box">
                <input type="text" name="q" value="{{ request('q') }}" class="cf-search-input" placeholder="Cari film...">
                <i class="fa-solid fa-magnifying-glass cf-search-icon" onclick="this.closest('form').submit()"></i>
            </form>

            <!-- NOTIF -->
            <i class="fa-solid fa-bell cf-icon-btn"></i>

            <!-- USER -->
            <div class="cf-avatar">A</div>
        </div>
    </nav>

    <!-- MOBILE MENU -->
    <div class="cf-mobile-menu" id="cf-mobile-menu">
        <form role="search" method="GET" action="{{ route('movies.search') }}">
            <input class="cf-mobile-search" type="search" name="q" value="{{ request('q') }}" placeholder="Cari film...">
        </form>
        <ul class="cf-mobile-links">
            <li><a href="{{ route('movies.index') }}">Movie</a></li>
            <li><a href="#">Kategori</a></li>
            <li><a href="#"><i class="fa-solid fa-circle-user me-2"></i>Profile</a></li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                </a>
            </li>
        </ul>
    </div>

    <main class="cf-main">
        @yield('content')
    </main>

    <footer class="cf-footer">
        <p>&copy; <script>document.write(new Date().getFullYear())</script> Codeflix. All rights reserved.</p>
    </footer>

    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Hamburger toggle
        document.getElementById('cf-hamburger').addEventListener('click', function() {
            document.getElementById('cf-mobile-menu').classList.toggle('open');
        });
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('cf-navbar');
            nav.classList.toggle('scrolled', window.scrollY > 40);
        });
        // Swiper
        document.querySelectorAll('.swiper').forEach(el => {
            new Swiper(el, {
                speed: 400,
                spaceBetween: 12,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
                navigation: {
                    nextEl: el.querySelector('.swiper-button-next'),
                    prevEl: el.querySelector('.swiper-button-prev'),
                },
                breakpoints: {
                    0:   { slidesPerView: 2, spaceBetween: 10 },
                    576: { slidesPerView: 3, spaceBetween: 12 },
                    768: { slidesPerView: 4, spaceBetween: 14 },
                    1024:{ slidesPerView: 5, spaceBetween: 16 },
                },
            });
        });
    </script>
    @stack('scripts')
</body>
</html>