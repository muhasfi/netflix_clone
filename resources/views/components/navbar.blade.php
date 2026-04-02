<nav class="navbar fixed-top navbar-expand-lg cf-navbar">
    <div class="container-fluid">

        <!-- TOGGLER -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo03">
            <i class="text-white fa-solid fa-bars"></i>
        </button>

        <!-- LOGO -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/img/codeflix_logo.png') }}" alt="logo" style="height:32px;">
        </a>

        <!-- CONTENT -->
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">

            <!-- CATEGORY -->
            <x-category-nav />

            <!-- SEARCH -->
            <form class="d-flex ms-auto me-md-4 position-relative" role="search" method="GET" action="{{ route('movies.search') }}">
                <input class="form-control cf-search-box" type="search" name="q"
                    value="{{ request('q') }}" placeholder="Cari film..."
                    aria-label="Search">

                <i class="fa-solid fa-magnifying-glass cf-search-icon"
                    onclick="this.closest('form').submit();"></i>
            </form>

            <!-- ICON -->
            <ul class="nav-icon d-flex align-items-center gap-3 mb-0">

                <!-- NOTIF -->
                <li class="dropdown">
                    <a class="nav-link p-0" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-bell cf-icon"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end cf-dropdown">
                        <li class="dropdown-item text-muted small">Belum ada notifikasi</li>
                    </ul>
                </li>

                <!-- USER -->
                <li class="dropdown">
                    <a class="nav-link p-0" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user cf-icon"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end cf-dropdown">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fa-solid fa-circle-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

        </div>
    </div>
</nav>
<style>
    /* NAVBAR */
.cf-navbar {
    background: rgba(5,5,15,0.65);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-bottom: 1px solid rgba(255,255,255,0.06);
    padding: 12px 4%;
    transition: all .3s ease;
    z-index: 999;
}

.cf-navbar.scrolled {
    background: rgba(5,5,15,0.95);
    box-shadow: 0 10px 40px rgba(0,0,0,0.6);
}

/* SEARCH */
.cf-search-box {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    color: #fff;
    padding-right: 40px;
}

.cf-search-box::placeholder {
    color: #aaa;
}

.cf-search-box:focus {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.2);
    color: #fff;
    box-shadow: none;
}

/* SEARCH ICON */
.cf-search-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
    cursor: pointer;
}

/* ICON */
.cf-icon {
    font-size: 18px;
    color: #ddd;
    transition: .2s;
}

.cf-icon:hover {
    color: #fff;
}

/* DROPDOWN */
.cf-dropdown {
    background: rgba(15,15,25,0.95);
    border: 1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
}

.cf-dropdown .dropdown-item {
    color: #ccc;
}

.cf-dropdown .dropdown-item:hover {
    background: rgba(255,255,255,0.08);
    color: #fff;
}
</style>

{{-- SCRIPT --}}
@push('scripts')
<script>
document.addEventListener('scroll', function () {
    const nav = document.querySelector('.cf-navbar');
    if (window.scrollY > 40) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
});
</script>
@endpush