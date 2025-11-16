@extends('layouts.dashboard')

@section('content')

<div class="card p-4">
    <div class="card-body">
        
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('profil.activity') }}" class="btn btn-sm btn-light me-3"><i class="bi bi-arrow-left"></i></a>
            <h4 class="fw-bold mb-0">Detail Pesanan</h4>
        </div>
        <hr class="mb-4">

        <div class="row g-4 g-lg-5">

            <div class="col-lg-7">
                
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
                            <span class="badge bg-warning text-dark">{{ str_replace('_', ' ', $order->status) }}</span>
                        </div>
                    </div>
                </div>

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

            <div class="col-lg-5">
                
                <div class="mandor-card mb-4">
                    @if($order->mandor)
                        <img src="{{ $order->mandor->profile_picture_url ? Storage::url($order->mandor->profile_picture_url) : asset('assets/img/default-avatar.png') }}" 
                             alt="Mandor Avatar">
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
                        <div class="price-list-item price-total d-flex justify-content-between fw-bold">
                            <span class="label">Total:</span>
                            <span class="value">Rp {{ number_format($order->estimated_cost, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
                @if($order->status == 'COMPLETED_PENDING_PAYMENT')
                    <div class="mt-4">
                        <div class="alert alert-info d-flex align-items-center" role="alert">
                            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                            <div class="small">
                                Pekerjaan telah selesai. Silakan lakukan pembayaran untuk menyelesaikan pesanan ini.
                            </div>
                        </div>

                        <form action="{{ route('payment.show', $order->id) }}" method="GET">
                            <button type="submit" class="btn btn-success w-100 py-3 fs-4 fw-bold shadow-sm">
                                <i class="bi bi-credit-card-2-front me-2"></i> Bayar Sekarang
                            </button>
                        </form>
                    </div>
                @elseif($order->status == 'FINISHED')
                     <div class="mt-4">
                        <div class="alert alert-success text-center fw-bold">
                            <i class="bi bi-check-circle-fill me-2"></i> Lunas & Selesai
                        </div>
                    </div>
                @endif

            </div>

        </div> 
    </div>
</div>

@endsection