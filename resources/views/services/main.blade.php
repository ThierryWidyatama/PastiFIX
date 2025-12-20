@extends('layouts.services')

@section('title', 'PastiFIX - Services')

@section('content')

<!-- HERO -->
<section class="services-hero">
    <div class="container" style="padding-top: 100px; padding-bottom: 50px;">
        <h1>Temukan Jasa Terbaik</h1>
        <p>Pilih layanan profesional sesuai kebutuhan renovasi kamu</p>

        <!-- SEARCH -->
        <form action="{{ route('services.index') }}" method="GET" class="services-search">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari jasa, contoh: Tukang Atap"
            >
            <button type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </form>
    </div>
</section>

<!-- FORM FILTER UTAMA -->
<form action="{{ route('services.index') }}" method="GET">
<section class="services-wrapper">
    <div class="container">
        <div class="services-layout">

            <!-- FILTER -->
            <aside class="services-filter">

                <h4>Filter Jasa</h4>

                <!-- SORT -->
                <div class="filter-group">
                    <label>Urutkan</label>
                    <select name="sort" onchange="this.form.submit()">
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Popular</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    </select>
                </div>

                <!-- KATEGORI (DINAMIS) -->
                <div class="filter-group">
                    <label>Kategori</label>

                    @forelse ($all_categories as $category)
                        <div class="rating-option">
                            <input
                                type="checkbox"
                                name="filters[]"
                                value="{{ $category->id }}"
                                onchange="this.form.submit()"
                                {{ in_array($category->id, request('filters', [])) ? 'checked' : '' }}
                            >
                            {{ $category->name }}
                        </div>
                    @empty
                        <small class="text-muted">Belum ada kategori</small>
                    @endforelse
                </div>

            </aside>

            <!-- LIST JASA -->
            <div>

                <div class="services-grid">

                    @forelse ($services as $service)
                        <a href="{{ route('services.detail', $service->id) }}" class="service-item">

                            <div class="service-thumb">
                                <img
                                    src="{{ $service->image_url
                                        ? Storage::url($service->image_url)
                                        : 'https://placehold.co/600x400/cccccc/333?text=' . urlencode($service->name)
                                    }}"
                                    alt="{{ $service->name }}"
                                >
                                <span class="service-badge">Populer</span>
                            </div>

                            <div class="service-info">
                                <h3>{{ $service->name }}</h3>

                                <p class="service-desc">
                                    {{ Str::limit($service->description ?? 'Layanan profesional terpercaya.', 80) }}
                                </p>

                                <div class="service-meta">
                                    <span class="price">
                                        {{ $service->price
                                            ? 'Rp' . number_format($service->price, 0, ',', '.')
                                            : 'Harga via Survei'
                                        }}
                                    </span>
                                </div>

                                <div class="service-btn">
                                    Lihat Detail
                                </div>
                            </div>

                        </a>
                    @empty
                        <div class="alert alert-secondary text-center">
                            Tidak ada layanan yang cocok dengan filter.
                        </div>
                    @endforelse

                </div>

                <!-- PAGINATION -->
                <div class="text-center mt-5">
                    {{ $services->withQueryString()->links() }}
                </div>

            </div>

        </div>
    </div>
</section>
</form>

@endsection
