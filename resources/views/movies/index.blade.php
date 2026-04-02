@extends('layouts.app')

@push('styles')
<style>
    /* ── HERO / JUMBOTRON ── */
    .cf-hero {
        position: relative;
        min-height: 88vh;
        display: flex;
        align-items: flex-end;
        padding: 0 4% 60px;
        overflow: hidden;
        background: linear-gradient(135deg, #05050f 0%, #100508 50%, #0a0a10 100%);
    }
    .cf-hero-bg-img {
        position: absolute;
        inset: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        opacity: 0.35;
    }
    .cf-hero-gradient {
        position: absolute; inset: 0;
        background:
            linear-gradient(to right, rgba(0,0,0,0.9) 35%, rgba(0,0,0,0.2) 70%, transparent 100%),
            linear-gradient(to top, rgba(0,0,0,0.9) 10%, transparent 50%);
    }
    .cf-hero-content { position: relative; z-index: 1; max-width: 520px; }
    .cf-hero-eyebrow {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(229,9,20,0.15);
        border: 1px solid rgba(229,9,20,0.35);
        border-radius: 4px;
        padding: 4px 10px;
        font-size: 11px; font-weight: 600;
        color: #f99; letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 14px;
    }
    .cf-hero-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(48px, 7vw, 80px);
        line-height: 1;
        color: #fff;
        margin-bottom: 16px;
    }
    .cf-hero-meta {
        display: flex; gap: 10px; align-items: center;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .cf-hero-rating {
        background: #f5c518; color: #000;
        padding: 2px 8px; border-radius: 4px;
        font-size: 12px; font-weight: 700;
    }
    .cf-hero-tag {
        font-size: 12px; color: #bbb;
        border: 1px solid rgba(255,255,255,0.2);
        padding: 2px 9px; border-radius: 20px;
    }
    .cf-hero-desc {
        font-size: 15px; color: #bbb; line-height: 1.65;
        margin-bottom: 28px;
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }
    .cf-hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }

    .btn-cf-play {
        display: inline-flex; align-items: center; gap: 8px;
        background: #fff; color: #000;
        border: none; border-radius: 8px;
        padding: 12px 28px;
        font-size: 15px; font-weight: 700;
        cursor: pointer; text-decoration: none;
        transition: background .2s;
    }
    .btn-cf-play:hover { background: rgba(255,255,255,0.85); color: #000; }

    .btn-cf-info {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 12px 24px;
        font-size: 15px; font-weight: 500;
        cursor: pointer; text-decoration: none;
        transition: background .2s;
    }
    .btn-cf-info:hover { background: rgba(255,255,255,0.22); color: #fff; }

    /* Poster float on right (desktop) */
    .cf-hero-poster {
        position: absolute;
        right: 6%; top: 50%;
        transform: translateY(-50%);
        width: 200px; z-index: 1;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.7);
        border: 1px solid rgba(255,255,255,0.08);
    }
    .cf-hero-poster img { width: 100%; display: block; }

    @media (max-width: 768px) {
        .cf-hero { min-height: 70vh; padding-bottom: 40px; align-items: flex-end; }
        .cf-hero-poster { display: none; }
        .cf-hero-title { font-size: 44px; }
    }

    /* ── BREADCRUMB ── */
    .cf-breadcrumb { padding: 16px 4% 0; }
    .cf-breadcrumb ol { background: none; padding: 0; margin: 0; }
    .cf-breadcrumb .breadcrumb-item a { color: var(--cf-muted, #999); font-size: 13px; text-decoration: none; }
    .cf-breadcrumb .breadcrumb-item.active { color: #fff; font-size: 13px; }
    .cf-breadcrumb .breadcrumb-item + .breadcrumb-item::before { color: #555; }
</style>
@endpush

@section('content')
    <!-- HERO -->
    <div class="cf-hero">
        <div class="cf-hero-bg-img" style="background: linear-gradient(135deg, #05050f 0%, #1a0a0a 60%);"></div>
        <div class="cf-hero-gradient"></div>

        {{-- Poster (dari film pertama jika ada) --}}
        @if($latestMovies->count() > 0)
        <div class="cf-hero-poster">
            <img src="{{ $latestMovies->first()->poster }}" alt="{{ $latestMovies->first()->title }}">
        </div>
        @endif

        <div class="cf-hero-content">
            <div class="cf-hero-eyebrow">◆ Baru Ditambahkan</div>
            @if($latestMovies->count() > 0)
                <h1 class="cf-hero-title">{{ $latestMovies->first()->title }}</h1>
                <div class="cf-hero-meta">
                    @if($latestMovies->first()->average_rating)
                        <span class="cf-hero-rating">{{ $latestMovies->first()->average_rating }} IMDb</span>
                    @endif
                    @if($latestMovies->first()->release_date)
                        <span class="cf-hero-tag">{{ $latestMovies->first()->release_date->format('Y') }}</span>
                    @endif
                    @foreach($latestMovies->first()->categories->take(2) as $cat)
                        <span class="cf-hero-tag">{{ $cat->title }}</span>
                    @endforeach
                </div>
                <p class="cf-hero-desc">{{ $latestMovies->first()->description }}</p>
                <div class="cf-hero-actions">
                    <a href="{{ route('movies.show', $latestMovies->first()->slug) }}" class="btn-cf-play">
                        <i class="fa-solid fa-play"></i> Tonton Sekarang
                    </a>
                    <a href="{{ route('movies.show', $latestMovies->first()->slug) }}" class="btn-cf-info">
                        <i class="fa-solid fa-circle-info"></i> Info
                    </a>
                </div>
            @else
                <h1 class="cf-hero-title">All New Simba</h1>
                <p class="cf-hero-desc">Simba adalah anak sebatang kara yang sedang mencari orang tuanya tetapi usaha nya terbatas.</p>
                <div class="cf-hero-actions">
                    <a href="#" class="btn-cf-play"><i class="fa-solid fa-play"></i> Tonton</a>
                </div>
            @endif
        </div>
    </div>

    <!-- NEW ADDED -->
    <div class="cf-section" style="padding-top: 32px;">
        <h3 class="cf-section-title">Baru Ditambahkan</h3>
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach ($latestMovies as $movie)
                    <div class="swiper-slide">
                        <div class="card">
                            <a href="{{ route('movies.show', $movie->slug) }}" style="display:block;position:relative;">
                                <img src="{{ $movie->poster }}" class="img-fluid" alt="{{ $movie->title }}">
                                <span class="badge badge-rating">
                                    <img class="star-rating" src="assets/img/star-rating.png" alt="">
                                    {{ $movie->average_rating }}
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>

    <!-- TRENDING -->
    <div class="cf-section">
        <h3 class="cf-section-title">Trending</h3>
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach ($popularMovies as $movie)
                    <div class="swiper-slide">
                        <div class="card">
                            <a href="{{ route('movies.show', $movie->slug) }}" style="display:block;position:relative;">
                                <img src="{{ $movie->poster }}" class="img-fluid" alt="{{ $movie->title }}">
                                <span class="badge badge-rating">
                                    <img class="star-rating" src="assets/img/star-rating.png" alt="">
                                    {{ $movie->average_rating }}
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
@endsection