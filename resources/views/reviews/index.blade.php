@extends('layouts.services')

@section('title', 'Ulasan Pelanggan')

@push('styles')
<style>
    .review-header { background-color: #f8f9fa; }
    .star-filter-item { cursor: pointer; transition: 0.2s; }
    .star-filter-item:hover { background-color: #f1f1f1; }
    .star-filter-item.active { background-color: #fff9db; border-left: 4px solid #FEC81A; }
    .rating-badge { background-color: #FEC81A; color: #000; font-weight: bold; font-size: 0.8rem; padding: 2px 8px; border-radius: 4px; }
</style>
@endpush

@section('content')

    <header class="review-header">
        <div class="container" style="padding-top: 100px; padding-bottom: 50px;">
            <h1>Apa Kata Mereka?</h1>
            <p class="text-muted">Transparansi adalah kunci. Lihat pengalaman asli pengguna PastiFIX.</p>
        </div>
    </header>

    <div class="container mt-5 mb-5">
        <div class="row">

            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold">Filter Rating</div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('reviews.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !request('star') ? 'active fw-bold' : '' }}">
                            Semua Bintang
                            <span class="badge bg-secondary rounded-pill">{{ \App\Models\Review::count() }}</span>
                        </a>

                        @foreach(range(5, 1) as $i)
                            <a href="{{ route('reviews.index', ['star' => $i]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request('star') == $i ? 'active fw-bold' : '' }}">
                                <div>
                                    <span class="text-warning me-2">
                                        @for($x=0; $x<$i; $x++) <i class="bi bi-star-fill"></i> @endfor
                                        @for($x=$i; $x<5; $x++) <i class="bi bi-star text-muted opacity-25"></i> @endfor
                                    </span>
                                    {{ $i }} Bintang
                                </div>
                                <span class="badge bg-light text-dark rounded-pill border">{{ $counts[$i] ?? 0 }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row g-4">
                    @forelse($reviews as $review)
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm p-3">
                                <div class="d-flex align-items-start mb-3">
                                    <img src="{{ $review->user->profile_picture_url ? Storage::url($review->user->profile_picture_url) : asset('assets/img/default-avatar.png') }}"
                                         class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ $review->user->name }}</h6>
                                        <small class="text-muted">{{ $review->created_at->translatedFormat('d F Y') }}</small>
                                    </div>
                                    <div class="ms-auto">
                                        @php $avg = ceil(($review->rating_mandor + $review->rating_service) / 2); @endphp
                                        <span class="rating-badge"><i class="bi bi-star-fill"></i> {{ $avg }}.0</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <p class="text-muted small mb-1">Layanan: <strong>{{ $review->order->category->name ?? 'Jasa' }}</strong></p>
                                    <p class="fst-italic mb-0">"{{ $review->comment }}"</p>
                                </div>

                                <div class="mt-auto border-top pt-2">
                                    <div class="row text-center small text-muted">
                                        <div class="col-6 border-end">
                                            Mandor: <span class="text-warning fw-bold"><i class="bi bi-star-fill"></i> {{ $review->rating_mandor }}</span>
                                        </div>
                                        <div class="col-6">
                                            App: <span class="text-warning fw-bold"><i class="bi bi-star-fill"></i> {{ $review->rating_service }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <img src="{{ asset('assets/img/no-data.png') }}" alt="Empty" style="width: 100px; opacity: 0.5;">
                            <h5 class="mt-3 text-muted">Belum ada ulasan untuk kategori ini.</h5>
                        </div>
                    @endforelse
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $reviews->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
