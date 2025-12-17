@extends('layouts.services')

@section('title', 'Detail Jasa - ' . $service->name)

@push('styles')
<style>
    .services-header {
        background-color: #f8f9fa;
    }
    .card-price {
        color: #bf3131; /* Warna Kuning PastiFIX */
        font-weight: 700;
    }
    .btn-brand {
        background-color: #bf3131;
        color: #000;
        font-weight: 600;
        border: none;
    }
    .btn-brand:hover {
        background-color: #f50000;
        color: #000;
    }
</style>
@endpush

@section('content')
    <header class="services-header">
        <div class="container" style="padding-top: 100px; padding-bottom: 50px;">
            <h1>Detail Jasa</h1>
            <small class="text-muted">
                <a href="{{ route('services.index') }}" class="text-decoration-none text-muted">Services</a>
                / {{ $service->name }}
            </small>
        </div>
    </header>

    <div class="container" style="padding-top: 50px; padding-bottom: 50px;">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ $service->image_url ? Storage::url($service->image_url) : 'https://placehold.co/800x600/FEC81A/333?text=' . urlencode($service->name) }}"
                     class="img-fluid rounded shadow-sm"
                     alt="{{ $service->name }}"
                     style="width: 100%; height: 400px; object-fit: cover;">
            </div>

            <div class="col-lg-6">
                <h2>{{ $service->name }}</h2>

                <h3 class="card-price mb-3">
                    {{ $service->price ? 'Mulai dari Rp' . number_format($service->price, 0, ',', '.') : 'Harga via Survei' }}
                </h3>

                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading fs-5"><i class="bi bi-info-circle-fill"></i> Perhatian!</h4>
                    <p class="mb-0 small">Harga yang tertera adalah <strong>perkiraan awal</strong>. Harga final ditentukan oleh <strong>Mandor</strong> setelah <strong>survei</strong>.</p>
                </div>

                <div class="text-muted mb-4">
                    @if($service->description)
                        <p>{{ $service->description }}</p>
                    @else
                        <p>Tidak ada deskripsi tambahan untuk layanan ini.</p>
                    @endif
                </div>

                <ul class="list-unstyled mb-4">
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Tukang profesional dan bersertifikat.</li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Survei lokasi oleh mandor.</li>
                    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Garansi pengerjaan.</li>
                </ul>

                <a href="{{ route('services.checkout', ['service_id' => $service->id]) }}" class="btn btn-brand btn-lg px-5">
                    <i class="bi bi-calendar-check me-2"></i> Ajukan Permintaan Survei
                </a>
            </div>
        </div>
    </div>
@endsection
