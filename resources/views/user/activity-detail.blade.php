@extends('layouts.dashboard')

@section('content')

<div class="card p-4">
    <div class="card-body">
        
        <!-- Judul & Tombol Kembali -->
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('profil.activity') }}" class="btn btn-sm btn-light me-3"><i class="bi bi-arrow-left"></i></a>
            <h4 class="fw-bold mb-0">Detail Pesanan</h4>
        </div>
        <hr class="mb-4">

        <div class="row g-4 g-lg-5">

            <!-- KOLOM KIRI -->
            <div class="col-lg-7">
                <!-- Info Pesanan -->
                <div class="order-detail-info">
                    <div class="info-item">
                        <div class="info-label">Nomor Pesanan:</div>
                        <div class="info-value">#{{ substr($order->id, 0, 12) }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Pesanan Tanggal:</div>
                        <div class="info-value">{{ $order->created_at->translatedFormat('l, d F Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Kategori Perbaikan:</div>
                        <div class="info-value">{{ $order->category->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status:</div>
                        <div class="info-value">
                            @php
                                $statusColor = 'bg-secondary';
                                $statusLabel = str_replace('_', ' ', $order->status);

                                switch($order->status) {
                                    case 'PENDING':
                                    case 'PENDING_ADMIN_REVIEW':
                                    case 'PENDING_MANDOR_QUOTE':
                                        $statusColor = 'bg-warning text-dark';
                                        break;
                                    case 'APPROVED_IN_PROGRESS':
                                        $statusColor = 'bg-primary';
                                        break;
                                    case 'COMPLETED_PENDING_PAYMENT':
                                        $statusColor = 'bg-info text-dark';
                                        break;
                                    case 'FINISHED':
                                        $statusColor = 'bg-success';
                                        break;
                                    case 'CANCELLED':
                                    case 'REJECTED_BY_ADMIN':
                                    case 'REJECTED_BY_MANDOR':
                                        $statusColor = 'bg-danger';
                                        break;
                                    case 'CANCEL_REQUESTED':
                                        $statusColor = 'bg-warning text-danger border border-danger';
                                        break;
                                }
                            @endphp
                            <span class="badge {{ $statusColor }} fs-7 fw-bold px-3 py-2">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Waktu Perbaikan (Timeline) -->
                <div class="mt-5">
                    <div class="info-label fw-bold mb-3">Timeline Pengerjaan</div>
                    <div class="timeline-wrapper">
                        <ul class="timeline-stepper">
                            @forelse($order->workTimelines as $timeline)
                                <li class="timeline-step">
                                    <div class="timeline-step-icon">
                                        <span class="timeline-step-dot"></span>
                                        <span class="timeline-step-line"></span>
                                    </div>
                                    <div class="timeline-step-content">
                                        <span class="date">{{ \Carbon\Carbon::parse($timeline->work_date)->translatedFormat('l, d F Y') }}</span>
                                        <span class="day d-block text-muted small">{{ $timeline->description }}</span>
                                    </div>
                                </li>
                            @empty
                                <p class="text-muted small fst-italic">Belum ada timeline pengerjaan.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN -->
            <div class="col-lg-5">
                
                <!-- Card Mandor -->
                <div class="mandor-card mb-4">
                    @if($order->status == 'CANCELLED')
                        <div class="text-center w-100 py-2">
                            <i class="bi bi-x-circle-fill text-danger fs-1 mb-2"></i>
                            <div class="d-flex flex-column">
                                <span class="mandor-card-name text-danger">Pesanan Dibatalkan</span>
                                <span class="text-muted small">Proses telah dihentikan.</span>
                            </div>
                        </div>

                    @elseif($order->status == 'CANCEL_REQUESTED')
                        <div class="text-center w-100 py-2">
                            <i class="bi bi-hourglass-split text-warning fs-1 mb-2"></i>
                            <div class="d-flex flex-column">
                                <span class="mandor-card-name text-warning">Pengajuan Pembatalan</span>
                                <span class="text-muted small">Menunggu persetujuan Admin...</span>
                            </div>
                        </div>

                    @elseif($order->mandor)
                        <img src="{{ $order->mandor->profile_picture_url ? Storage::url($order->mandor->profile_picture_url) : asset('assets/img/default-avatar.png') }}" alt="Mandor Avatar">
                        <div class="d-flex flex-column">
                            <span class="mandor-card-name">{{ $order->mandor->name }}</span>
                            <span class="text-muted small">Mandor Bertugas</span>
                        </div>

                    @else
                        <img src="{{ asset('assets/img/default-avatar.png') }}" alt="Menunggu">
                        <div class="d-flex flex-column">
                            <span class="mandor-card-name">Menunggu Mandor</span>
                            <span class="text-muted small">Sedang dicarikan...</span>
                        </div>
                    @endif
                </div>

                <!-- Rincian Harga -->
                <h6 class="fw-bold">Ringkasan Biaya</h6>
                <div class="mt-3 card bg-light border-0 p-3">
                    @forelse($order->costItems as $item)
                        <div class="price-list-item mb-2 d-flex justify-content-between">
                            <span class="label text-muted">{{ $item->item_name }}:</span>
                            <span class="value fw-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-muted small text-center mb-0">Menunggu estimasi biaya dari Mandor.</p>
                    @endforelse

                    @if($order->costItems->count() > 0)
                        <hr class="my-3">
                        <div class="price-list-item price-total d-flex justify-content-between fw-bold fs-5">
                            <span class="label">Total Final:</span>
                            <span class="value text-primary">Rp {{ number_format($order->estimated_cost, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>

                <!-- TOMBOL AKSI -->
                
                @if($order->status == 'PENDING' || $order->status == 'PENDING_ADMIN_REVIEW' || $order->status == 'PENDING_MANDOR_QUOTE')
                    <div class="mt-4">
                        <button type="button" class="btn btn-outline-danger w-100 py-3 fw-bold border-2" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                            <i class="bi bi-x-circle me-2"></i> Ajukan Pembatalan
                        </button>
                        <div class="form-text text-center small mt-2">
                            Pembatalan memerlukan persetujuan Admin.
                        </div>
                    </div>

                @elseif($order->status == 'CANCEL_REQUESTED')
                    <div class="mt-4">
                        <div class="alert alert-warning text-center border-warning" role="alert">
                            <i class="bi bi-clock-history me-2 fs-4"></i><br>
                            <strong>Permintaan Pembatalan Dikirim</strong><br>
                            Mohon tunggu konfirmasi Admin.
                        </div>
                    </div>
                
                @elseif($order->status == 'CANCELLED')
                    <div class="mt-4">
                        <div class="alert alert-danger text-center fw-bold" role="alert">
                            <i class="bi bi-x-octagon-fill me-2"></i> Pesanan Dibatalkan
                        </div>
                        @if($order->cancellation_reason)
                            <div class="bg-light-danger p-3 rounded text-danger small text-center fst-italic border border-danger border-dashed">
                                Alasan: "{{ $order->cancellation_reason }}"
                            </div>
                        @endif
                    </div>

                @elseif($order->status == 'COMPLETED_PENDING_PAYMENT')
                    <div class="mt-4">
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                            <div class="small">Pekerjaan selesai. Silakan lakukan pembayaran.</div>
                        </div>
                        <form action="{{ route('payment.show', $order->id) }}" method="GET">
                            <button type="submit" class="btn btn-success w-100 py-3 fs-4 fw-bold shadow-sm">
                                <i class="bi bi-credit-card-2-front me-2"></i> Bayar Sekarang
                            </button>
                        </form>
                    </div>

                @elseif($order->status == 'FINISHED')
                    @if($order->review)
                        <div class="mt-4 card border-warning bg-warning-subtle">
                            <div class="card-body p-3">
                                <h5 class="fw-bold text-center mb-3">Ulasan Anda</h5>
                                <div class="row text-center mb-3">
                                    <div class="col-6 border-end border-warning">
                                        <div class="small text-muted">Mandor</div>
                                        <div class="text-warning fs-5"><i class="bi bi-star-fill"></i> {{ $order->review->rating_mandor }}/5</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="small text-muted">Layanan</div>
                                        <div class="text-warning fs-5"><i class="bi bi-star-fill"></i> {{ $order->review->rating_service }}/5</div>
                                    </div>
                                </div>
                                <p class="mb-0 small text-center fst-italic">"{{ $order->review->comment }}"</p>
                            </div>
                        </div>
                    @else
                        <div class="mt-4">
                            <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                                <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                                <div class="small fw-bold">Pesanan Selesai & Lunas.</div>
                            </div>
                            
                            <button type="button" class="btn btn-warning w-100 py-3 fs-5 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                <i class="bi bi-star-fill me-2"></i> Beri Ulasan
                            </button>
                        </div>
                    @endif
                @endif

            </div>
        </div> 
    </div>
</div>

<!-- Modal Cancel Order -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">Ajukan Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profil.activity.cancel', $order->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning small d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                        <div>
                            Tindakan ini memerlukan persetujuan Admin. Mohon berikan alasan yang jelas.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alasan Pembatalan</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Contoh: Salah pilih kategori, sudah dapat tukang lain, dll..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-danger fw-bold w-100">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Review -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Beri Ulasan Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('review.store') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                
                <div class="modal-body text-center pt-0 pb-4">
                    
                    <!-- RATING 1: KINERJA MANDOR -->
                    <p class="fw-bold mb-0 mt-3 text-start">Kinerja Mandor ({{ $order->mandor->name ?? 'Mandor' }})</p>
                    <div class="rating-css">
                        <div class="star-icon">
                            <!-- [FIX] URUTAN 5-1 UNTUK ROW-REVERSE -->
                            <input type="radio" name="rating_mandor" value="5" id="m-5" checked> <label for="m-5" class="bi bi-star-fill"></label>
                            <input type="radio" name="rating_mandor" value="4" id="m-4"> <label for="m-4" class="bi bi-star-fill"></label>
                            <input type="radio" name="rating_mandor" value="3" id="m-3"> <label for="m-3" class="bi bi-star-fill"></label>
                            <input type="radio" name="rating_mandor" value="2" id="m-2"> <label for="m-2" class="bi bi-star-fill"></label>
                            <input type="radio" name="rating_mandor" value="1" id="m-1"> <label for="m-1" class="bi bi-star-fill"></label>
                        </div>
                    </div>

                    <hr class="my-2 opacity-25">

                    <!-- RATING 2: KUALITAS LAYANAN -->
                    <p class="fw-bold mb-0 mt-2 text-start">Kualitas Aplikasi & Layanan</p>
                    <div class="rating-css">
                        <div class="star-icon">
                            <input type="radio" name="rating_service" value="5" id="s-5" checked> <label for="s-5" class="bi bi-star-fill"></label>
                            <input type="radio" name="rating_service" value="4" id="s-4"> <label for="s-4" class="bi bi-star-fill"></label>
                            <input type="radio" name="rating_service" value="3" id="s-3"> <label for="s-3" class="bi bi-star-fill"></label>
                            <input type="radio" name="rating_service" value="2" id="s-2"> <label for="s-2" class="bi bi-star-fill"></label>
                            <input type="radio" name="rating_service" value="1" id="s-1"> <label for="s-1" class="bi bi-star-fill"></label>
                        </div>
                    </div>

                    <!-- KOMENTAR -->
                    <div class="mt-4 text-start">
                        <label class="form-label fw-bold small">Komentar Tambahan</label>
                        <textarea name="comment" class="form-control bg-light" rows="3" placeholder="Ceritakan pengalaman Anda... (Opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-brand w-100 fw-bold">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection