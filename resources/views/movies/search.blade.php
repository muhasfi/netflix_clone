{{-- ============================================================ --}}
{{-- search.blade.php                                            --}}
{{-- ============================================================ --}}
@extends('layouts.app')

@push('styles')
<style>
    .cf-page-header { padding: 100px 4% 24px; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 28px; }
    .cf-page-title { font-family: 'Bebas Neue', sans-serif; font-size: 32px; color: #fff; }
    .cf-search-keyword { font-size: 15px; color: #777; margin-top: 4px; }
    .cf-keyword-accent { color: #e5e5e5; }
    .cf-movie-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 14px; padding: 0 4%;
    }
    @media (max-width: 480px) { .cf-movie-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } }
    .cf-movie-item {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 10px; overflow: hidden;
        cursor: pointer; transition: transform .2s; position: relative;
    }
    .cf-movie-item:hover { transform: scale(1.04); }
    .cf-movie-item img { width: 100%; aspect-ratio: 2/3; object-fit: cover; display: block; }
    .cf-movie-item .badge-rating {
        position: absolute; top: 8px; right: 8px;
        background: rgba(0,0,0,0.8) !important;
        border: 1px solid rgba(255,255,255,0.1); font-size: 11px;
    }
    .cf-no-results { text-align: center; padding: 80px 0; color: #555; font-size: 15px; grid-column: 1/-1; }
</style>
@endpush

@section('content')
<div class="cf-page-header">
    <div class="cf-page-title">Hasil Pencarian</div>
    <div class="cf-search-keyword">Kata kunci: <span class="cf-keyword-accent">"{{ $keyword }}"</span></div>
</div>

<div class="cf-movie-grid">
    @forelse ($movies as $movie)
        <div class="cf-movie-item">
            <a href="{{ route('movies.show', $movie->slug) }}" style="display:block;position:relative;">
                <img src="{{ $movie->poster }}" alt="{{ $movie->title }}">
                <span class="badge rounded-pill text-bg-dark badge-rating">
                    <img class="star-rating" src="assets/img/star-rating.png" alt="" style="width:12px;height:12px;">
                    {{ $movie->average_rating }}
                </span>
            </a>
        </div>
    @empty
        <div class="cf-no-results">
            <i class="fa-solid fa-film" style="font-size:36px;display:block;margin-bottom:12px;opacity:0.25;"></i>
            Tidak ada film yang cocok dengan pencarian kamu.
        </div>
    @endforelse
</div>
@endsection