{{-- ============================================================ --}}
{{-- plans.blade.php                                             --}}
{{-- ============================================================ --}}
{{-- @extends('layouts.subscribe') --}}

@extends('layouts.subscribe')

@section('title', 'Pilih Paket')
@section('page-title', 'Pilih Paket')

@section('content')
<div class="mt-4 row justify-content-center gy-4">
    @foreach ($plans as $plan)
        <div class="col-12 col-md-4">
            <div class="cf-plan-card {{ $loop->iteration == 2 ? 'cf-plan-popular' : '' }}">
                @if($loop->iteration == 2)
                    <div class="cf-plan-badge">TERPOPULER</div>
                @endif
                <div class="cf-plan-header">
                    <h3 class="cf-plan-name">{{ $plan->title }}</h3>
                    <div class="cf-plan-price">
                        Rp{{ number_format($plan->price, 0, ',', '.') }}
                    </div>
                    <div class="cf-plan-period">/ {{ $plan->duration }} hari</div>
                </div>
                <div class="cf-plan-body">
                    <div class="cf-plan-quality">{{ $plan->resolution }}</div>
                    <ul class="cf-plan-features">
                        <li>
                            <span class="cf-feat-icon"><i class="fa-solid fa-check"></i></span>
                            Resolusi {{ $plan->resolution }}
                        </li>
                        <li>
                            <span class="cf-feat-icon"><i class="fa-solid fa-check"></i></span>
                            Mobile, Computer, TV
                        </li>
                        <li>
                            <span class="cf-feat-icon"><i class="fa-solid fa-check"></i></span>
                            {{ $plan->max_devices }} perangkat bersamaan
                        </li>
                        <li>
                            <span class="cf-feat-icon"><i class="fa-solid fa-check"></i></span>
                            Akses semua konten
                        </li>
                    </ul>
                    <a href="{{ route('subscribe.checkout', $plan) }}"
                       class="cf-plan-btn {{ $loop->iteration == 2 ? 'cf-plan-btn-solid' : 'cf-plan-btn-outline' }}">
                        Pilih Paket
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<p style="text-align:center;font-size:12px;color:#555;margin-top:32px;">
    Semua paket termasuk akses tak terbatas. Harga sudah termasuk pajak.
</p>
@endsection