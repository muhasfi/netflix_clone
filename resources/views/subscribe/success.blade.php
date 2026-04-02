{{-- ============================================================ --}}
{{-- success.blade.php                                           --}}
{{-- ============================================================ --}}
@extends('layouts.subscribe')

@section('title', 'Pembayaran Berhasil')
@section('page-title', 'Berhasil')

@section('content')
<div class="cf-success-wrap">
    <div class="cf-success-icon">
        <i class="fa-solid fa-check"></i>
    </div>
    <div class="cf-success-title">Yay! Pembayaran Berhasil</div>
    <p class="cf-success-sub">Langgananmu sudah aktif. Selamat menikmati ribuan film & series tanpa batas!</p>
    <a href="/" class="btn-cf-start">
        <i class="fa-solid fa-play me-2"></i>Mulai Nonton
    </a>
</div>
@endsection