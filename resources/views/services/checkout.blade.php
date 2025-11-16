@extends('layouts.services') {{-- [FIX] Ganti ke layout 'landing' --}}

@section('title', 'Checkout')

@section('content')
    <header class="services-header">
        <div class="container" style="padding-top: 100px; padding-bottom: 50px;">
            <h1>Checkout</h1>
            <small class="text-muted">
                <a href="{{ route('services.index') }}" class="text-decoration-none text-muted">Services</a> 
                / <a href="{{ route('services.detail', $service->id) }}" class="text-decoration-none text-muted">{{ $service->name }}</a>
                / Checkout
            </small>
        </div>
    </header>
    <div class="container" style="padding-top: 50px; padding-bottom: 50px;">

        <!-- [BARU] Form untuk kirim data (PENTING) -->
        <!-- (Kita akan buat route 'order.store' nanti) -->
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <!-- Kirim ID layanan yg dipesan -->
            <input type="hidden" name="service_id" value="{{ $service->id }}">
            
            <div class="row g-5">

                <div class="col-lg-7">
                    <h4 class="mb-4 fw-bold">Pilih Alamat Survei</h4>

                    <!-- [FIX] Loop semua alamat user dari database -->
                    @forelse ($addresses as $address)
                        <div class="address-card-wrapper mt-3">
                            <input type="radio" name="address_id" id="address{{ $address->id }}" 
                                   class="address-radio" value="{{ $address->id }}" 
                                   {{ $address->is_primary ? 'checked' : '' }}>
                            
                            <label for="address{{ $address->id }}" class="address-card">
                                <div class="address-card-body">
                                    <div class="fw-bold">
                                        {{ $address->label ?? ($address->is_primary ? 'Alamat Utama' : 'Alamat') }}
                                        @if($address->is_primary)
                                            <span class="badge bg-warning-subtle text-warning-emphasis fw-medium ms-2">UTAMA</span>
                                        @endif
                                    </div>
                                    <div class="text-muted small my-2">
                                        {{ $address->address_line }}, {{ $address->rt_rw }}, {{ $address->postal_code }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $address->landmark_details }}
                                    </div>
                                </div>
                                <div class="address-card-actions">
                                    <!-- (Tombol edit/delete ini kita fungsikan nanti) -->
                                    <button type="button" class="btn btn-icon"><i class="bi bi-pencil"></i></button>
                                </div>
                            </label>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            Anda belum memiliki alamat tersimpan. Silakan <a href="#" data-bs-toggle="modal" data-bs-target="#newAddressModal">tambah alamat baru</a>.
                        </div>
                    @endforelse

                    <div class="add-new-address-link text-center my-4">
                        <div class="divider-line"></div>
                        <a href="#" class="btn btn-icon-add" data-bs-toggle="modal" data-bs-target="#newAddressModal">
                            <i class="bi bi-plus"></i>
                        </a>
                        <div class="mt-2 text-muted fw-medium">Tambah Alamat Baru</div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 checkout-summary-card">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-4">Ringkasan Pesanan</h5>

                            <!-- [FIX] Ambil data dari controller -->
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Biaya Awal ({{ $service->name }})</span>
                                <span class="fw-medium">Rp{{ number_format($prices['service'], 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Biaya Layanan</span>
                                <span class="fw-medium">Rp{{ number_format($prices['admin_fee'], 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Pajak (Estimasi)</span>
                                <span class="fw-medium">Rp{{ number_format($prices['tax'], 0, ',', '.') }}</span>
                            </div>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                                <span>Total (Estimasi)</span>
                                <span>Rp{{ number_format($prices['total'], 0, ',', '.') }}</span>
                            </div>

                            <button type="submit" class="btn btn-brand btn-lg w-100 fw-bold">
                                Kirim Permintaan Survei
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- [DIUBAH] Modal untuk Tambah Alamat (form-nya kita benerin) -->
    <div class="modal fade" id="newAddressModal" tabindex="-1" aria-labelledby="newAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- [BARU] Kita jadikan form yg beneran -->
                <form action="{{ route('address.store') }}" method="POST">
                    @csrf
                    <!-- [BARU] Kita kirim route checkout, biar bisa balik ke sini -->
                    <input type="hidden" name="redirect_to" value="{{ route('services.checkout', ['service_id' => $service->id]) }}">
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="newAddressModalLabel">Tambahkan Alamat Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- [FIX] Sesuaikan 'name' dengan DB kita -->
                            <div class="col-12">
                                <label for="address_line" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="address_line" name="address_line" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="rt_rw" class="form-label">RT/RW</label>
                                <input type="text" class="form-control" id="rt_rw" name="rt_rw" placeholder="001/002">
                            </div>
                            <div class="col-md-6">
                                <label for="postal_code" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code">
                            </div>
                            <div class="col-12">
                                <label for="landmark_details" class="form-label">Detail Patokan (Opsional)</label>
                                <input type="text" class="form-control" id="landmark_details" name="landmark_details" placeholder="Cth: Sebelah warung sate">
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="is_primary">
                                    <label class="form-check-label" for="is_primary">
                                        Jadikan Alamat Utama
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-brand">Simpan Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection