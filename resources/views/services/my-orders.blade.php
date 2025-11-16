@extends('layouts.landing')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container" style="padding-top: 150px; padding-bottom: 50px;">
    <h1 class="mb-4">Pesanan Saya</h1>

    <div class="card shadow-sm mb-4 border-warning">
        <div class="card-header bg-warning-subtle d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pesanan #001 - Perbaikan Atap Bocor</h5>
            <span class="badge bg-warning text-dark fs-6">
                <i class="bi bi-cash-stack me-1"></i> Menunggu Pembayaran
            </span>
        </div>
        <div class="card-body">
            <p>
                Admin telah menyetujui hasil survei Mandor. Rincian harga final telah diterbitkan.
            </p>
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item d-flex justify-content-between fw-bold fs-5">
                    <span class="text-warning">Total Tagihan Final</span>
                    <strong class="text-warning">Rp265.000</strong>
                </li>
            </ul>

            <a href="{{ route('services.payment') }}" class="btn btn-brand btn-lg px-5">
                Bayar Sekarang (Rp265.000)
            </a>
            <a href="#" class="btn btn-outline-danger btn-lg px-3">Batalkan Pesanan</a>
        </div>
        <div class="card-footer text-muted">
            Dipesan: 5 November 2025 | Harga Final Diterbitkan: 6 November 2025
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        </div>

    <div class="card shadow-sm mb-4">
        </div>

</div>
@endsection
