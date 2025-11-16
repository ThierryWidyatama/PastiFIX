@extends('layouts.landing')

@section('title', 'Pembayaran')

@section('content')
    <div class="container" style="padding-top: 150px; padding-bottom: 50px;">
        <div class="row">
            <div class="col-lg-7">
                <h2 class="mb-4">Pilih Metode Pembayaran</h2>

                <div class="accordion payment-method" id="paymentAccordion">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne">
                                <i class="bi bi-wallet2 me-2"></i> Virtual Account
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <p>Anda akan mendapatkan nomor VA setelah menekan tombol "Bayar".</p>
                                <div>
                                    <img src="https://placehold.co/100x30/e9ecef/999?text=BCA" alt="BCA"
                                        class="border rounded p-1 me-2">
                                    <img src="https://placehold.co/100x30/e9ecef/999?text=Mandiri" alt="Mandiri"
                                        class="border rounded p-1 me-2">
                                    <img src="https://placehold.co/100x30/e9ecef/999?text=BRI" alt="BRI"
                                        class="border rounded p-1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo">
                                <i class="bi bi-phone-fill me-2"></i> E-Wallet
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <p>Pastikan saldo E-Wallet Anda mencukupi.</p>
                                <div>
                                    <img src="https://placehold.co/100x30/e9ecef/999?text=GoPay" alt="GoPay"
                                        class="border rounded p-1 me-2">
                                    <img src="https://placehold.co/100x30/e9ecef/999?text=OVO" alt="OVO"
                                        class="border rounded p-1 me-2">
                                    <img src="https://placehold.co/100x30/e9ecef/999?text=DANA" alt="DANA"
                                        class="border rounded p-1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree">
                                <i class="bi bi-credit-card-fill me-2"></i> Kartu Kredit / Debit
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="cc-name" class="form-label">Nama di Kartu</label>
                                        <input type="text" class="form-control" id="cc-name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cc-number" class="form-label">Nomor Kartu</label>
                                        <input type="text" class="form-control" id="cc-number"
                                            placeholder="XXXX XXXX XXXX XXXX" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cc-expiration" class="form-label">Masa Berlaku (MM/YY)</label>
                                            <input type="text" class="form-control" id="cc-expiration"
                                                placeholder="MM/YY" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cc-cvv" class="form-label">CVV</label>
                                            <input type="text" class="form-control" id="cc-cvv" placeholder="XXX"
                                                required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-5">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-warning">Tagihan Pesanan #001</span>
                </h4>
                <div class="card summary-card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Perbaikan Atap Bocor</h6>
                                <small class="text-muted">Durasi: 1 jam</small>
                            </div>
                            <span class="text-muted">Rp250.000</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Biaya Layanan</h6>
                            </div>
                            <span class="text-muted">Rp15.000</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <span class="fw-bold">Total (IDR)</span>
                            <strong class="text-warning">Rp265.000</strong>
                        </li>
                    </ul>
                </div>

                <button class="btn btn-brand btn-lg w-100 mt-3" type="submit">
                    Bayar Sekarang (Rp265.000)
                </button>
            </div>
        </div>
    </div>
@endsection
