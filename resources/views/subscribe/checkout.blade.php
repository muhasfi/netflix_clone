{{-- ============================================================ --}}
{{-- checkout.blade.php                                          --}}
{{-- ============================================================ --}}
@extends('layouts.subscribe')

@section('title', 'Detail Pembayaran')
@section('page-title', 'Pembayaran')

@section('content')
<div class="cf-checkout-card">
    <div class="cf-checkout-header">
        <div class="cf-checkout-plan-name">{{ $plan->title }}</div>
        <div style="font-size:13px;color:#888;margin-bottom:10px;">{{ $plan->duration }} Hari Langganan</div>
        <div class="cf-checkout-plan-price">Rp{{ number_format($plan->price, 0, ',', '.') }}</div>
    </div>
    <div class="cf-checkout-body">
        <div class="cf-price-row">
            <span>Subtotal</span>
            <span>Rp{{ number_format($plan->price, 0, ',', '.') }}</span>
        </div>
        <div class="cf-price-row">
            <span>PPN 12%</span>
            <span>Rp{{ number_format($plan->price * 0.12, 0, ',', '.') }}</span>
        </div>
        <div class="cf-price-row total">
            <span>Total Pembayaran</span>
            <span style="color:var(--cf-red);">Rp{{ number_format($plan->price * 1.1, 0, ',', '.') }}</span>
        </div>

        <div class="cf-terms">
            <input type="checkbox" id="terms" required>
            <label for="terms">
                Dengan melanjutkan, kamu setuju dengan
                <a href="#">Syarat & Ketentuan</a> dan
                <a href="#">Kebijakan Privasi</a> kami.
            </label>
        </div>

        <form action="#" method="POST">
            <button type="submit" class="btn-cf-pay" id="pay-button">
                <i class="fa-solid fa-lock me-2"></i>Bayar Sekarang
            </button>
        </form>

        <div style="text-align:center;margin-top:16px;font-size:12px;color:#555;">
            <i class="fa-solid fa-shield-halved me-1"></i>Pembayaran diproses secara aman via Midtrans
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const payButton = document.querySelector('#pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();
        const terms = document.querySelector('#terms');
        if (!terms.checked) { alert('Harap setujui syarat & ketentuan terlebih dahulu.'); return; }
        fetch('/checkout', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ plan_id: '{{ $plan->id }}', amount: {{ (int) ($plan->price * 1.1) }} })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                window.snap.pay(data.snap_token, {
                    onSuccess: () => window.location.href = '/subscribe/success',
                    onPending: () => window.location.href = '/payment/pending',
                    onError: () => window.location.href = '/payment/error',
                    onClose: () => alert('Pembayaran dibatalkan.')
                });
            } else { alert('Pembayaran gagal diinisialisasi.'); }
        })
        .catch(err => { console.error(err); alert('Terjadi kesalahan.'); });
    });
</script>
@endsection