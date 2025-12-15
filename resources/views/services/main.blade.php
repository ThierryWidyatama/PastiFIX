@extends('layouts.services')

@section('title', 'PastiFIX - Services')

@section('content')

    <header class="services-header">
        <div class="container" style="padding-top: 80px; padding-bottom: 50px;">
            <h1>Services</h1>
        </div>
    </header>

    <div class="container">
        <div class="search-bar-container">
            <form action="#">
                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" placeholder="Search Services"
                        aria-label="Search Services">
                    <button class="btn btn-warning btn-lg px-4" type="submit"
                        style="background-color: #FEC81A; color: #333;">
                    <i class="bi bi-search"></i> Search
                </button>
                </div>
            </form>
        </div>
    </div>
<!-- FORM baru dibuka di sini -->
<form action="{{ route('services.index') }}" method="GET">
        <div class="container mt-4 mt-md-5">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Services</li>
                </ol>
            </nav>

            <div class="row">

                <div class="col-lg-3">
                    <div class="card filter-card">
                        <div class="card-header bg-white filter-header d-flex justify-content-between align-items-center"
                             data-bs-toggle="collapse" href="#collapseFilter" role="button">
                            <span>Kategori</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="collapse show" id="collapseFilter">
                            <div class="filter-body">
                                
                                <!-- [FIX] Ganti jadi loop dinamis dari database -->
                                @forelse ($all_categories as $category)
                                    <div class="form-check">
                                        <!-- 'name="filters[]"' penting untuk array -->
                                        <input class="form-check-input" type="checkbox" name="filters[]"
                                               value="{{ $category->id }}" id="check_{{ $category->id }}"
                                               onchange="this.form.submit()"
                                               {{ ( in_array($category->id, request('filters', [])) ) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="check_{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @empty
                                    <small class="text-muted">Belum ada kategori.</small>
                                @endforelse
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 mt-4 mt-lg-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Showing {{ $services->firstItem() }}-{{ $services->lastItem() }} of {{ $services->total() }} results</span>
                        <div class="col-md-4 col-lg-3">
                            <!-- [FIX] 'name' & 'onchange' ditambahkan -->
                            <select class="form-select" name="sort" onchange="this.form.submit()">
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Sort By: Popular</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Sort By: Harga Terendah</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Sort By: Harga Tertinggi</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Sort By: Terbaru</option>
                            </select>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                        <!-- [FIX] Ganti jadi loop dinamis -->
                        @forelse ($services as $service)
                            <div class="col">
                                <a href="{{ route('services.detail', $service->id) }}" class="text-decoration-none text-dark">
                                    <div class="card service-card h-100">
                                        <!-- [FIX] Tampilkan gambar asli dari DB, atau placeholder jika kosong -->
                                        <img src="{{ $service->image_url ? Storage::url($service->image_url) : 'https://placehold.co/600x400/FEC81A/333?text=' . urlencode($service->name) }}" 
                                            class="card-img-top" alt="{{ $service->name }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $service->name }}</h5>
                                            <small class="text-muted">Mulai dari</small>
                                            <!-- Kita belum punya harga di DB, jadi kita dummy dulu -->
                                            <!-- [FIX] Tampilkan harga yg sudah diformat dari DB -->
                                            <p class="card-price">
                                                {{ $service->price ? 'Rp' . number_format($service->price, 0, ',', '.') : 'Harga via Survei' }}
                                            </p>
                                            <span class="badge bg-info-subtle text-info-emphasis rounded-pill">
                                                <i class="bi bi-search me-1"></i> Perlu Survei
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-secondary text-center">
                                    Tidak ada layanan yang cocok dengan kriteria pencarian Anda.
                                </div>
                            </div>
                        @endforelse

                    </div>
                    
                    <!-- [FIX] Ganti 'Load More' jadi Pagination Laravel -->
                    <div class="text-center mt-5 mb-5">
                         {{ $services->links() }}
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection