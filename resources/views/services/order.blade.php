@extends('layouts.services')

@section('title', 'PastiFIX - Order Sukses')

@section('hide-navbar')
@endsection

@section('hide-footer')
@endsection

@section('hide-botnav')
@endsection

@section('content')
    <div class="container" style="padding-top: 150px; padding-bottom: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <i class="bi bi-check-circle-fill display-1 text-success mb-3"></i>

                        <h1 class="mb-3 fw-bold">Permintaan Terkirim!</h1>

                        <p class="lead text-muted">
                            Permintaan Anda telah berhasil dikirim. Admin kami akan segera memverifikasi pesanan Anda.
                        </p>
                        <p>
                            Anda dapat melacak status pesanan dan melihat harga final dari Mandor di halaman
                            <strong>Pesanan Saya</strong>.
                        </p>

                        <div class="d-flex flex-column flex-md-row justify-content-center gap-3 mt-4">
                            <a href="{{ route('profil.activity') }}" class="btn btn-brand btn-lg px-5">
                                Lihat Pesanan Saya
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-dark btn-lg px-5">
                                Kembali ke Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
