<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            --cf-muted: #888;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background-color: var(--cf-dark);
            font-family: 'Inter', sans-serif;
            color: #e5e5e5;
            display: flex;
            flex-direction: column;
        }

        /* Cinematic background */
        .auth-bg {
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 80% 20%, rgba(229,9,20,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 20% 80%, rgba(20,20,60,0.4) 0%, transparent 60%),
                #0f0f0f;
            z-index: 0;
        }

        .auth-grid-overlay {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .auth-wrapper {
            position: relative; z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        /* Logo */
        .auth-logo {
            margin-bottom: 32px;
            text-align: center;
        }
        .auth-logo img { height: 36px; }
        .auth-logo-text {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 32px;
            color: var(--cf-red);
            letter-spacing: 3px;
        }

        /* Card */
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: rgba(20,20,20,0.9);
            border: 1px solid var(--cf-border);
            border-radius: 14px;
            padding: 36px 36px 28px;
            backdrop-filter: blur(12px);
        }

        .auth-heading {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 28px;
            color: #fff;
            margin-bottom: 4px;
        }
        .auth-subheading {
            font-size: 13px;
            color: var(--cf-muted);
            margin-bottom: 28px;
        }

        /* Form */
        .cf-form-group { margin-bottom: 16px; }
        .cf-label {
            display: block;
            font-size: 12px;
            color: var(--cf-muted);
            margin-bottom: 6px;
            font-weight: 500;
        }
        .cf-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            padding: 11px 14px;
            font-family: 'Inter', sans-serif;
            transition: border-color .2s, background .2s;
        }
        .cf-input:focus {
            outline: none;
            border-color: rgba(229,9,20,0.5);
            background: rgba(255,255,255,0.07);
        }
        .cf-input::placeholder { color: #555; }
        .cf-input.is-invalid { border-color: rgba(229,9,20,0.7); }

        .btn-cf-primary {
            width: 100%;
            background: var(--cf-red);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .2s, transform .1s;
            margin-top: 4px;
        }
        .btn-cf-primary:hover { background: #c40812; }
        .btn-cf-primary:active { transform: scale(0.99); }

        .auth-divider {
            display: flex; align-items: center; gap: 12px;
            margin: 20px 0;
        }
        .auth-divider hr {
            flex: 1; border: none;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .auth-divider span { font-size: 12px; color: var(--cf-muted); }

        .btn-cf-social {
            width: 100%;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            color: #ccc;
            font-size: 14px;
            padding: 11px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .2s, border-color .2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-cf-social:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.2); }

        .auth-footer-text {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: var(--cf-muted);
        }
        .auth-footer-text a { color: #fff; text-decoration: none; }
        .auth-footer-text a:hover { color: var(--cf-red); }

        .alert-cf {
            background: rgba(229,9,20,0.12);
            border: 1px solid rgba(229,9,20,0.3);
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            color: #f99;
            margin-bottom: 16px;
        }
        .alert-cf ul { padding-left: 16px; margin: 0; }
        .alert-cf-success {
            background: rgba(25,188,155,0.1);
            border-color: rgba(25,188,155,0.3);
            color: #5ee8c8;
        }

        /* Remember / forgot row */
        .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .cf-checkbox { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--cf-muted); cursor: pointer; }
        .cf-checkbox input[type="checkbox"] { accent-color: var(--cf-red); width: 14px; height: 14px; }
        .auth-forgot { font-size: 12px; color: var(--cf-red); text-decoration: none; }
        .auth-forgot:hover { text-decoration: underline; }

        @media (max-width: 480px) {
            .auth-card { padding: 28px 20px 24px; }
        }
    </style>
</head>

<body>
    <div class="auth-bg"></div>
    <div class="auth-grid-overlay"></div>
    <div class="auth-wrapper">
        <div class="auth-logo">
            <img src="{{ asset('assets/img/codeflix_logo.png') }}" alt="Codeflix">
        </div>
        <div class="auth-card">
            <div class="auth-heading">@yield('page-title')</div>
            <div class="auth-subheading">@yield('page-subtitle', 'Masuk untuk melanjutkan menonton')</div>

            @if ($errors->any())
                <div class="alert-cf">
                    <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            @if (session('status'))
                <div class="alert-cf alert-cf-success">{{ session('status') }}</div>
            @endif

            @yield('content')

            <div class="auth-footer-text">@yield('footer-text')</div>
        </div>
    </div>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @yield('scripts')
</body>
</html>