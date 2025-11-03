@extends('layouts.dashboard')

@section('content')

<div class="card p-4">
    <div class="card-body">
        
        <h4 class="fw-bold">Pesananku</h4>
        <hr class="my-3">

        <div class="row g-4 g-lg-5 mt-2">

            <div class="col-lg-7">
                
                <div class="order-detail-info">
                    <div class="info-item">
                        <div class="info-label">Nomor Pesanan:</div>
                        <div class="info-value">299047423209424</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Pesanan Tanggal:</div>
                        <div class="info-value">Senin 25 November 2025</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Kategori Perbaikan:</div>
                        <div class="info-value">Atap Bocor</div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="info-label">Waktu Perbaikan: 3 Hari</div>
                    
                    <div class="timeline-wrapper mt-3">
                        <ul class="timeline-stepper">
                            
                            <li class="timeline-step">
                                <div class="timeline-step-icon">
                                    <span class="timeline-step-dot"></span>
                                    <span class="timeline-step-line"></span>
                                </div>
                                <div class="timeline-step-content">
                                    <span class="date">Senin, 25 November 2025</span>
                                    </div>
                            </li>

                            <li class="timeline-step">
                                <div class="timeline-step-icon">
                                    <span class="timeline-step-dot"></span>
                                    <span class="timeline-step-line"></span>
                                </div>
                                <div class="timeline-step-content">
                                    <span class="date">Selasa, 26 November 2025</span>
                                </div>
                            </li>

                            <li class="timeline-step">
                                <div class="timeline-step-icon">
                                    <span class="timeline-step-dot"></span>
                                    <span class="timeline-step-line"></span>
                                </div>
                                <div class="timeline-step-content">
                                    <span class="date">Senin, 27 November 2025</span>
                                </div>
                            </li>

                            <li class="timeline-step">
                                <div class="timeline-step-icon">
                                    <span class="timeline-step-dot"></span>
                                    <span class="timeline-step-line"></span>
                                </div>
                                <div class="timeline-step-content">
                                    <span class="date">Selasa, 28 November 2025</span>
                                </div>
                            </li>
                            <li class="timeline-step">
                                <div class="timeline-step-icon">
                                    <span class="timeline-step-dot"></span>
                                    </div>
                                <div class="timeline-step-content">
                                    <span class="date">Rabu, 29 November 2025</span>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                
                <div class="mandor-card mb-4">
                    <img src="{{ asset('assets/img/user1.jpeg') }}" alt="Mandor Avatar">
                    <span class="mandor-card-name">Nama Mandor disini</span>
                </div>

                <h6 class="fw-bold">Ringkasan Harga</h6>
                <div class="mt-3">
                    <div class="price-list-item">
                        <span class="label">Iwak:</span>
                        <span class="value">Rp. 50.000</span>
                    </div>
                    <div class="price-list-item">
                        <span class="label">Semen:</span>
                        <span class="value">Rp. 50.000</span>
                    </div>
                    <div class="price-list-item">
                        <span class="label">Genteng:</span>
                        <span class="value">Rp. 50.000</span>
                    </div>

                    <hr class="my-3">

                    <div class="price-list-item price-total">
                        <span class="label">Total:</span>
                        <span class="value">Rp. 150.000</span>
                    </div>
                </div>
            </div>

        </div> </div>
</div>

@endsection