@extends('layouts.app')

@push('styles')
<style>
    /* ── SHOW HERO ── */
    .cf-show-hero {
        position: relative;
        min-height: 480px;
        display: flex;
        align-items: flex-end;
        padding: 0 4% 40px;
        background: #050510;
        overflow: hidden;
    }
    .cf-show-hero-bg {
        position: absolute; inset: 0;
        background: linear-gradient(135deg, #05050f, #180510, #080514);
        opacity: 1;
    }
    .cf-show-hero-gradient {
        position: absolute; inset: 0;
        background:
            linear-gradient(to right, rgba(0,0,0,0.92) 40%, rgba(0,0,0,0.3) 80%, transparent),
            linear-gradient(to top, rgba(0,0,0,0.9) 15%, transparent 50%);
    }
    .cf-show-poster-wrap {
        position: absolute;
        right: 4%; top: 28px;
        width: clamp(120px, 18vw, 200px);
        z-index: 1;
    }
    .cf-show-poster-wrap img {
        width: 100%; border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.7);
        border: 1px solid rgba(255,255,255,0.08);
    }
    .cf-show-content { position: relative; z-index: 1; max-width: 600px; }
    .cf-show-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(36px, 6vw, 60px);
        line-height: 1.05;
        color: #fff;
        margin-bottom: 10px;
    }
    .cf-show-meta { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin-bottom: 12px; }
    .cf-tag { font-size: 12px; color: #bbb; border: 1px solid rgba(255,255,255,0.18); padding: 3px 10px; border-radius: 20px; }
    .cf-tag-red { background: rgba(229,9,20,0.15); border-color: rgba(229,9,20,0.35); color: #f99; }
    .cf-stars { display: flex; gap: 3px; align-items: center; }
    .cf-star-icon { color: #f5c518; font-size: 13px; }
    .cf-show-desc { font-size: 14px; color: #aaa; line-height: 1.65; margin-bottom: 22px; }
    .cf-show-actions { display: flex; gap: 10px; flex-wrap: wrap; }
    .btn-cf-sm-play {
        display: inline-flex; align-items: center; gap: 7px;
        background: #fff; color: #000;
        border: none; border-radius: 7px;
        padding: 10px 22px; font-size: 14px; font-weight: 700;
        cursor: pointer; text-decoration: none;
        transition: background .2s;
    }
    .btn-cf-sm-play:hover { background: rgba(255,255,255,0.85); color: #000; }
    .btn-cf-ghost {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(255,255,255,0.1);
        color: #fff; border: 1px solid rgba(255,255,255,0.18);
        border-radius: 7px;
        padding: 10px 18px; font-size: 14px;
        cursor: pointer; text-decoration: none;
        transition: background .2s;
    }
    .btn-cf-ghost:hover { background: rgba(255,255,255,0.18); color: #fff; }

    @media (max-width: 576px) {
        .cf-show-poster-wrap { display: none; }
        .cf-show-hero { min-height: 360px; }
    }

    /* ── DETAIL SECTION ── */
    .cf-show-body { padding: 0 4%; }
    .cf-detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        padding: 28px 0;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .cf-detail-item {}
    .cf-detail-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 6px; }
    .cf-detail-value { font-size: 14px; color: #ddd; }

    /* ── VIDEO PLAYER ── */
    .cf-video-wrap {
        margin: 28px 0 12px;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 16/9;
        background: #000;
        box-shadow: 0 16px 48px rgba(0,0,0,0.6);
    }
    .cf-video-wrap iframe { width: 100%; height: 100%; border: none; display: block; }

    .cf-video-tools {
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 8px;
        margin-bottom: 32px;
    }
    .cf-tool-btn {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 20px;
        padding: 7px 14px;
        font-size: 12px; color: #bbb;
        cursor: pointer;
        transition: background .2s, color .2s;
    }
    .cf-tool-btn:hover { background: rgba(255,255,255,0.12); color: #fff; }
    .cf-tool-btn-rate {
        background: rgba(229,9,20,0.1);
        border-color: rgba(229,9,20,0.25);
        color: #f88;
    }
    .cf-tool-btn-rate:hover { background: rgba(229,9,20,0.2); color: #fff; }

    /* ── RATING BOX ── */
    .cf-rating-box {
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; gap: 6px;
        background: rgba(245,197,24,0.06);
        border: 1px solid rgba(245,197,24,0.2);
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        margin-bottom: 20px;
    }
    .cf-rating-number { font-family: 'Bebas Neue', sans-serif; font-size: 52px; color: #f5c518; line-height: 1; }
    .cf-rating-label { font-size: 12px; color: #888; }

    /* ── DARK MODE OVERLAY ── */
    .overlay-dark {
        position: fixed; top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.85);
        z-index: 1050; display: none;
    }
    .movie-focus { position: relative; z-index: 1060; }

    /* ── RELATED / SIMILAR ── */
    .cf-similar-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
    }
    .cf-sim-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: transform .2s;
    }
    .cf-sim-card:hover { transform: scale(1.04); }
    .cf-sim-card img { width: 100%; aspect-ratio: 2/3; object-fit: cover; display: block; }
</style>
@endpush

@section('content')
    <!-- BREADCRUMB -->
    <div class="cf-breadcrumb" style="padding-top: 80px; padding-left: 4%; padding-right: 4%;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background:none;padding:0;margin:0 0 8px;">
                <li class="breadcrumb-item"><a href="/" style="color:#888;font-size:13px;text-decoration:none;">Home</a></li>
                <li class="breadcrumb-item active" style="color:#ccc;font-size:13px;">{{ $movie->title }}</li>
            </ol>
        </nav>
    </div>

    <!-- HERO -->
    <div class="cf-show-hero">
        <div class="cf-show-hero-bg"></div>
        <div class="cf-show-hero-gradient"></div>

        <div class="cf-show-poster-wrap">
            <img src="{{ $movie->poster }}" alt="{{ $movie->title }}">
        </div>

        <div class="cf-show-content">
            <div class="cf-show-meta" style="margin-bottom:8px;">
                <span class="cf-tag cf-tag-red">Film</span>
            </div>
            <h1 class="cf-show-title">{{ $movie->title }}</h1>
            <div class="cf-show-meta">
                <div class="cf-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star cf-star-icon" style="{{ $i <= round($movie->average_rating / 2) ? '' : 'opacity:0.2' }}"></i>
                    @endfor
                </div>
                <span style="font-size:13px;color:#bbb;">{{ $movie->average_rating }}/10</span>
                <span class="cf-tag">{{ $movie->release_date->format('d M Y') }}</span>
                <span class="cf-tag">{{ $movie->formatted_duration }}</span>
                @foreach ($movie->categories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" class="cf-tag" style="text-decoration:none;color:#bbb;">{{ $cat->title }}</a>
                @endforeach
            </div>
            <p class="cf-show-desc">{{ $movie->description }}</p>
            <div class="cf-show-actions">
                <a href="#video" class="btn-cf-sm-play"><i class="fa-solid fa-play"></i> Tonton</a>
                <button class="btn-cf-ghost"><i class="fa-solid fa-plus"></i> My List</button>
                <button class="btn-cf-ghost"><i class="fa-solid fa-thumbs-up"></i> Suka</button>
            </div>
        </div>
    </div>

    <!-- DETAIL BODY -->
    <div class="cf-show-body">
        <div class="cf-detail-grid">
            <div class="cf-detail-item">
                <div class="cf-detail-label">Sutradara</div>
                <div class="cf-detail-value">{{ $movie->director }}</div>
            </div>
            <div class="cf-detail-item">
                <div class="cf-detail-label">Penulis</div>
                <div class="cf-detail-value">{{ $movie->writers }}</div>
            </div>
            <div class="cf-detail-item">
                <div class="cf-detail-label">Bintang</div>
                <div class="cf-detail-value">{{ $movie->stars }}</div>
            </div>
            <div class="cf-detail-item">
                <div class="cf-rating-box">
                    <div class="cf-rating-number">{{ $movie->average_rating }}</div>
                    <div class="cf-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star cf-star-icon" style="{{ $i <= round($movie->average_rating / 2) ? '' : 'opacity:0.2' }}"></i>
                        @endfor
                    </div>
                    <div class="cf-rating-label">Rating / 10</div>
                </div>
            </div>
        </div>

        <!-- VIDEO -->
        <div id="video" class="cf-video-wrap" style="margin-top:28px;">
            <iframe src="{{ $streamingUrl }}" title="{{ $movie->title }}" allowfullscreen></iframe>
        </div>

        <div class="cf-video-tools">
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <span class="cf-tool-btn" id="light-toggle">
                    <i class="fa-regular fa-lightbulb"></i> Matikan Lampu
                </span>
                <span class="cf-tool-btn">
                    <i class="fa-solid fa-film"></i> Trailer
                </span>
            </div>
            <span class="cf-tool-btn cf-tool-btn-rate">
                <i class="fa-solid fa-star"></i> Beri Rating
            </span>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lightToggle = document.querySelector('#light-toggle');
        const overlay = document.createElement('div');
        overlay.className = 'overlay-dark';
        document.body.appendChild(overlay);

        const videoWrap = document.querySelector('.cf-video-wrap');

        lightToggle.addEventListener('click', function() {
            const isOn = overlay.style.display === 'block';
            overlay.style.display = isOn ? 'none' : 'block';
            if (videoWrap) videoWrap.classList.toggle('movie-focus', !isOn);
            this.innerHTML = isOn
                ? '<i class="fa-regular fa-lightbulb"></i> Matikan Lampu'
                : '<i class="fa-solid fa-lightbulb"></i> Nyalakan Lampu';
        });

        overlay.addEventListener('click', function() {
            overlay.style.display = 'none';
            if (videoWrap) videoWrap.classList.remove('movie-focus');
            lightToggle.innerHTML = '<i class="fa-regular fa-lightbulb"></i> Matikan Lampu';
        });
    });
</script>
@endpush