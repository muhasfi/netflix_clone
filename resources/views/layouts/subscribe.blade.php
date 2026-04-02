<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Codeflix</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.6.0-web/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cf-red: #E50914;
            --cf-dark: #0f0f0f;
            --cf-card: #181818;
            --cf-border: rgba(255,255,255,0.08);
            --cf-muted: #777;
        }
        * { box-sizing: border-box; }

        body {
            background: var(--cf-dark);
            color: #e5e5e5;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        /* ── NAV ── */
        .sub-nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 4%;
            border-bottom: 1px solid var(--cf-border);
        }
        .sub-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 26px; color: var(--cf-red);
            letter-spacing: 2px; text-decoration: none;
        }
        .sub-logo img { height: 28px; }
        .sub-step {
            font-size: 13px; color: var(--cf-muted);
        }

        /* ── PAGE TITLE ── */
        .sub-header {
            text-align: center;
            padding: 48px 4% 32px;
        }
        .sub-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 42px; color: #fff; margin-bottom: 8px;
        }
        .sub-subtitle { font-size: 14px; color: var(--cf-muted); max-width: 440px; margin: 0 auto; line-height: 1.6; }

        /* ── PLAN CARDS ── */
        .cf-plan-card {
            background: var(--cf-card);
            border: 1px solid var(--cf-border);
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            height: 100%;
            display: flex; flex-direction: column;
            transition: border-color .2s, transform .2s;
        }
        .cf-plan-card:hover { border-color: rgba(255,255,255,0.15); transform: translateY(-4px); }
        .cf-plan-popular {
            border-color: var(--cf-red);
            box-shadow: 0 0 32px rgba(229,9,20,0.15);
        }
        .cf-plan-popular:hover { border-color: var(--cf-red); }
        .cf-plan-badge {
            position: absolute; top: -1px; left: 50%; transform: translateX(-50%);
            background: var(--cf-red); color: #fff;
            font-size: 10px; font-weight: 700; letter-spacing: 1px;
            padding: 5px 16px; border-radius: 0 0 8px 8px;
        }
        .cf-plan-header {
            padding: 32px 24px 20px;
            border-bottom: 1px solid var(--cf-border);
            text-align: center;
        }
        .cf-plan-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 26px; color: #fff; margin-bottom: 10px;
        }
        .cf-plan-price {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 40px; color: var(--cf-red); line-height: 1;
        }
        .cf-plan-period { font-size: 13px; color: var(--cf-muted); margin-top: 4px; }
        .cf-plan-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
        .cf-plan-quality {
            display: inline-block;
            background: rgba(229,9,20,0.1);
            border: 1px solid rgba(229,9,20,0.25);
            color: #f88;
            font-size: 11px; font-weight: 600;
            padding: 3px 12px; border-radius: 20px;
            margin-bottom: 20px;
        }
        .cf-plan-features { list-style: none; padding: 0; margin: 0 0 24px; flex: 1; }
        .cf-plan-features li {
            display: flex; align-items: center; gap: 10px;
            font-size: 13px; color: #bbb;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }
        .cf-plan-features li:last-child { border-bottom: none; }
        .cf-feat-icon {
            width: 20px; height: 20px;
            background: rgba(229,9,20,0.12);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 9px; color: var(--cf-red);
        }
        .cf-plan-btn {
            display: block; width: 100%;
            padding: 12px; border-radius: 8px;
            font-size: 14px; font-weight: 600;
            text-align: center; text-decoration: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .2s, color .2s, border-color .2s;
            border: 1px solid transparent;
        }
        .cf-plan-btn-solid { background: var(--cf-red); color: #fff; border-color: var(--cf-red); }
        .cf-plan-btn-solid:hover { background: #c40812; color: #fff; }
        .cf-plan-btn-outline { background: transparent; color: #ccc; border-color: rgba(255,255,255,0.15); }
        .cf-plan-btn-outline:hover { background: rgba(255,255,255,0.07); color: #fff; border-color: rgba(255,255,255,0.3); }

        /* ── CHECKOUT CARD ── */
        .cf-checkout-card {
            max-width: 480px; margin: 0 auto;
            background: var(--cf-card);
            border: 1px solid var(--cf-border);
            border-radius: 16px;
            overflow: hidden;
        }
        .cf-checkout-header {
            background: rgba(229,9,20,0.08);
            border-bottom: 1px solid var(--cf-border);
            padding: 24px;
        }
        .cf-checkout-plan-name { font-family: 'Bebas Neue', sans-serif; font-size: 22px; color: #fff; }
        .cf-checkout-plan-price { font-size: 28px; color: var(--cf-red); font-weight: 600; }
        .cf-checkout-body { padding: 24px; }
        .cf-price-row {
            display: flex; justify-content: space-between; align-items: center;
            font-size: 14px; color: #bbb;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .cf-price-row:last-of-type { border-bottom: none; }
        .cf-price-row.total {
            font-size: 16px; font-weight: 700; color: #fff;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 16px; margin-top: 4px;
        }
        .cf-divider { border: none; border-top: 1px solid rgba(255,255,255,0.06); margin: 8px 0; }
        .cf-terms {
            display: flex; align-items: flex-start; gap: 10px;
            font-size: 12px; color: var(--cf-muted);
            margin: 20px 0 24px;
            line-height: 1.5;
        }
        .cf-terms input[type="checkbox"] { accent-color: var(--cf-red); margin-top: 2px; flex-shrink: 0; }
        .cf-terms a { color: #fff; text-decoration: none; }
        .cf-terms a:hover { color: var(--cf-red); }
        .btn-cf-pay {
            width: 100%;
            background: var(--cf-red); color: #fff;
            border: none; border-radius: 8px;
            padding: 14px; font-size: 15px; font-weight: 700;
            cursor: pointer; font-family: 'Inter', sans-serif;
            transition: background .2s;
        }
        .btn-cf-pay:hover { background: #c40812; }

        /* ── SUCCESS ── */
        .cf-success-wrap {
            text-align: center; padding: 60px 24px;
            max-width: 440px; margin: 0 auto;
        }
        .cf-success-icon {
            width: 80px; height: 80px; border-radius: 50%;
            background: rgba(25,188,155,0.12);
            border: 2px solid rgba(25,188,155,0.4);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
            font-size: 36px; color: #19bc9b;
        }
        .cf-success-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 36px; color: #fff; margin-bottom: 8px;
        }
        .cf-success-sub { font-size: 15px; color: var(--cf-muted); margin-bottom: 36px; }
        .btn-cf-start {
            display: inline-block;
            background: var(--cf-red); color: #fff;
            text-decoration: none; border-radius: 8px;
            padding: 14px 40px; font-size: 16px; font-weight: 700;
            font-family: 'Inter', sans-serif;
            transition: background .2s;
        }
        .btn-cf-start:hover { background: #c40812; color: #fff; }

        /* CONTAINER */
        .sub-container { padding: 0 4% 60px; }

        @media (max-width: 576px) {
            .sub-title { font-size: 32px; }
        }
    </style>
</head>

<body>
    <nav class="sub-nav">
        <a href="/" class="sub-logo">
            <img src="{{ asset('assets/img/codeflix_logo.png') }}" alt="Codeflix">
        </a>
        <span class="sub-step">@yield('page-title')</span>
    </nav>

    <div class="sub-header">
        <div class="sub-title">@yield('title')</div>
        <div class="sub-subtitle">@yield('subtitle', '')</div>
    </div>

    <div class="sub-container">
        @yield('content')
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @yield('scripts')
</body>
</html>