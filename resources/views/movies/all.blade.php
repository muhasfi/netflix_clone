{{-- ============================================================ --}}
{{-- all.blade.php                                               --}}
{{-- ============================================================ --}}
@extends('layouts.app')

@push('styles')
<style>
    .cf-page-header {
        padding: 100px 4% 24px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        margin-bottom: 28px;
    }
    .cf-page-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 32px; color: #fff;
    }
    .cf-movie-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 14px;
        padding: 0 4%;
    }
    @media (max-width: 480px) {
        .cf-movie-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    }
    .cf-movie-item {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
        position: relative;
    }
    .cf-movie-item:hover { transform: scale(1.04); box-shadow: 0 8px 32px rgba(0,0,0,0.5); }
    .cf-movie-item img { width: 100%; aspect-ratio: 2/3; object-fit: cover; display: block; }
    .cf-movie-item .badge-rating {
        position: absolute; top: 8px; right: 8px;
        background: rgba(0,0,0,0.8) !important;
        border: 1px solid rgba(255,255,255,0.1);
        font-size: 11px;
    }
    .cf-load-more-wrap { text-align: center; padding: 36px 0 48px; }
    .btn-cf-loadmore {
        display: inline-flex; align-items: center; gap: 8px;
        background: transparent;
        border: 1px solid rgba(255,255,255,0.15);
        color: #ccc; border-radius: 8px;
        padding: 12px 32px; font-size: 14px;
        cursor: pointer; font-family: 'Inter', sans-serif;
        transition: background .2s, border-color .2s, color .2s;
    }
    .btn-cf-loadmore:hover { background: rgba(255,255,255,0.07); border-color: rgba(255,255,255,0.3); color: #fff; }
</style>
@endpush

@section('content')
<div class="cf-page-header">
    <div class="cf-page-title">Semua Film</div>
</div>

<div class="cf-movie-grid" id="movie-list">
    <x-movie-list :movies="$movies" />
</div>

<div class="cf-load-more-wrap">
    <button class="btn-cf-loadmore" id="load-more" data-page="2">
        <i class="fa-solid fa-rotate-right"></i> Muat Lebih Banyak
    </button>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.querySelector('#load-more');
        btn.addEventListener('click', function() {
            const page = btn.getAttribute('data-page');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memuat...';
            fetch(`/movies?page=${page}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(data => {
                    document.querySelector('#movie-list').insertAdjacentHTML('beforeend', data.html);
                    btn.setAttribute('data-page', parseInt(page) + 1);
                    if (!data.next_page) { btn.style.display = 'none'; }
                    else { btn.innerHTML = '<i class="fa-solid fa-rotate-right"></i> Muat Lebih Banyak'; }
                })
                .catch(err => { console.error(err); btn.innerHTML = '<i class="fa-solid fa-rotate-right"></i> Muat Lebih Banyak'; });
        });
    });
</script>
@endpush


{{-- ============================================================ --}}
{{-- search.blade.php – SIMPAN SEBAGAI FILE TERPISAH              --}}
{{-- ============================================================ --}}
{{--
@extends('layouts.app')

@push('styles')
<style>
    /* (sama seperti all.blade.php di atas, bisa di-share via partial) */
    .cf-page-header { padding: 100px 4% 24px; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 28px; }
    .cf-page-title { font-family: 'Bebas Neue', sans-serif; font-size: 32px; color: #fff; }
    .cf-search-keyword { font-size: 15px; color: #888; margin-top: 4px; }
    .cf-keyword-accent { color: #e5e5e5; }
    .cf-movie-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 14px; padding: 0 4%; }
    .cf-movie-item { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; overflow: hidden; cursor: pointer; transition: transform .2s; position: relative; }
    .cf-movie-item:hover { transform: scale(1.04); }
    .cf-movie-item img { width: 100%; aspect-ratio: 2/3; object-fit: cover; display: block; }
    .cf-movie-item .badge-rating { position: absolute; top: 8px; right: 8px; background: rgba(0,0,0,0.8) !important; border: 1px solid rgba(255,255,255,0.1); font-size: 11px; }
    .cf-no-results { text-align: center; padding: 80px 0; color: #555; font-size: 15px; }
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
                <span class="badge badge-rating rounded-pill text-bg-dark">
                    <img class="star-rating" src="assets/img/star-rating.png" alt="" style="width:12px;height:12px;">
                    {{ $movie->average_rating }}
                </span>
            </a>
        </div>
    @empty
        <div class="cf-no-results" style="grid-column:1/-1;">
            <i class="fa-solid fa-film" style="font-size:40px;display:block;margin-bottom:14px;opacity:0.3;"></i>
            Tidak ada film yang cocok dengan pencarian kamu.
        </div>
    @endforelse
</div>
@endsection
--}}