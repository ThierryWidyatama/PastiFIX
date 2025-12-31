@extends('layouts.landing')

@section('title', 'Ulasan Pelanggan')

@section('content')
    <main class="services-main review-page">
        <section class="review-market-hero">
            <div class="container" style="padding-top: 100px; padding-bottom: 50px;">
                <h1>Ulasan Pelanggan</h1>
                <p>Rating & pengalaman asli pengguna PastiFIX</p>
            </div>
        </section>

        <section class="container review-market-wrapper">

            <!-- FILTER BAR -->
            <div class="review-market-filter">
                <a href="{{ route('reviews.index') }}" class="{{ !request('star') ? 'active' : '' }}">
                    Semua
                </a>
                @foreach (range(5, 1) as $i)
                    <a href="{{ route('reviews.index', ['star' => $i]) }}"
                        class="{{ request('star') == $i ? 'active' : '' }}">
                        {{ $i }} <i class="bi bi-star-fill"></i>
                    </a>
                @endforeach
            </div>

            <!-- SKELETON -->
            <div class="review-skeleton-grid" id="reviewSkeleton">
                @for ($i = 0; $i < 6; $i++)
                    <div class="review-skeleton-card"></div>
                @endfor
            </div>

            <!-- REVIEW LIST -->
            <div class="review-market-grid d-none" id="reviewList">
                @forelse($reviews as $review)
                    @php
                        $avg = ceil(($review->rating_mandor + $review->rating_service) / 2);
                    @endphp

                    <article class="review-market-card">
                        <header>
                            <img
                                src="{{ $review->user->profile_picture_url ? Storage::url($review->user->profile_picture_url) : asset('assets/img/default-avatar.png') }}">
                            <div>
                                <h4>{{ $review->user->name }}</h4>
                                <small>{{ $review->created_at->translatedFormat('d F Y') }}</small>
                                <div class="stars">
                                    @for ($x = 0; $x < $avg; $x++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                </div>
                            </div>
                            <span class="rating-badge">{{ $avg }}</span>
                        </header>

                        <div class="review-body">
                            <span class="service-label">{{ $review->order->category->name ?? 'Jasa' }}</span>
                            <p>"{{ $review->comment }}"</p>
                        </div>

                        <footer>
                            <span>Mandor <i class="bi bi-star-fill"></i> {{ $review->rating_mandor }}</span>
                            <span>Aplikasi <i class="bi bi-star-fill"></i> {{ $review->rating_service }}</span>
                        </footer>
                    </article>
                @empty
                    <div class="review-empty">
                        <img src="{{ asset('assets/img/no-data.png') }}">
                        <p>Belum ada ulasan.</p>
                    </div>
                @endforelse
            </div>

            <div class="review-pagination">
                {{ $reviews->links() }}
            </div>

        </section>
    </main>
@endsection
