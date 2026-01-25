@extends('layouts.services')

@section('title', 'Layanan')

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
                placeholder="Cari jasa, contoh: Pasang Keramik"
            >
            <button type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </form>
    </div>
</section>

<!-- FORM FILTER UTAMA -->
<form action="{{ route('services.index') }}" method="GET" id="filterForm">
    <!-- Pertahankan search query saat filter diganti -->
    @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
    @endif

<section class="services-wrapper">
    <div class="container">
        <div class="services-layout">

            <!-- FILTER SIDEBAR -->
            <aside class="services-filter">

                <h4>Filter Jasa</h4>

                <!-- SORT -->
                <div class="filter-group">
                    <label class="mb-2 fw-bold small text-uppercase text-muted">Urutkan</label>
                    <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="" disabled {{ !request('sort') ? 'selected' : '' }}>Pilih Urutan</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </div>

                <hr class="my-4" style="opacity: 0.1">

                <!-- KATEGORI UTAMA (PARENT) -->
                <div class="filter-group">
                    <label class="mb-3 fw-bold small text-uppercase text-muted">Kategori</label>

                    <div class="d-flex flex-column gap-2">
                        @forelse ($all_categories as $parent)
                            <!-- [FIX] Gunakan class 'form-check' bawaan Bootstrap biar rapi sejajar -->
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="filters[]"
                                    value="{{ $parent->id }}"
                                    id="cat_{{ $parent->id }}"
                                    onchange="document.getElementById('filterForm').submit()"
                                    {{ in_array($parent->id, request('filters', [])) ? 'checked' : '' }}
                                    style="cursor: pointer;"
                                >
                                <label class="form-check-label" for="cat_{{ $parent->id }}" style="cursor: pointer;">
                                    {{ $parent->name }}
                                </label>
                            </div>
                        @empty
                            <small class="text-muted">Belum ada kategori utama</small>
                        @endforelse
                    </div>
                </div>

                <!-- [BARU] TOMBOL CLEAR FILTER -->
                <!-- Muncul hanya jika ada filter/search/sort yang aktif -->
                @if(request()->hasAny(['search', 'filters', 'sort']))
                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('services.index') }}" class="btn btn-outline-danger w-100 btn-sm">
                            <i class="bi bi-x-lg me-1"></i> Hapus Filter
                        </a>
                    </div>
                @endif

            </aside>

            <!-- LIST JASA (CHILDREN) -->
            <div>

                <div class="services-grid">

                    @forelse ($services as $service)
                        <a href="{{ route('services.detail', $service->id) }}" class="service-item text-decoration-none">

                            <div class="service-thumb">
                                <img
                                    src="{{ $service->image_url
                                        ? Storage::url($service->image_url)
                                        : 'https://placehold.co/600x400/cccccc/333?text=' . urlencode($service->name)
                                    }}"
                                    alt="{{ $service->name }}"
                                    style="height: 200px; object-fit: cover; width: 100%;"
                                >
                                <!-- Badge Nama Kategori Utama -->
                                <span class="service-badge">
                                    {{ $service->parent->name ?? 'Umum' }}
                                </span>
                            </div>

                            <div class="service-info">
                                <h3 class="text-dark">{{ $service->name }}</h3>

                                <p class="service-desc text-muted">
                                    {{ Str::limit($service->description ?? 'Layanan profesional terpercaya.', 80) }}
                                </p>

                                <div class="service-meta">
                                    <span class="price" style="color: #bf3131; font-weight: 700;">
                                        {{ $service->price
                                            ? 'Mulai Rp' . number_format($service->price, 0, ',', '.')
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
                        <div class="col-12" style="grid-column: 1 / -1;">
                            <div class="alert alert-secondary text-center p-5 border-0">
                                <i class="bi bi-search fs-1 d-block mb-3 text-muted"></i>
                                <h5 class="text-muted">Jasa tidak ditemukan</h5>
                                <p class="small mb-0">Coba ubah filter atau kata kunci pencarian Anda.</p>
                            </div>
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