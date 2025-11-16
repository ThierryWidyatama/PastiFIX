@extends('layouts.landing')

@section('title', 'Pembayaran')

@section('content')
<div class="container" style="padding-top: 120px; padding-bottom: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5 text-center">
                    <h2 class="fw-bold mb-4">Konfirmasi Pembayaran</h2>
                    
                    <div class="alert alert-warning">
                        Total Tagihan: 
                        <strong class="fs-4 d-block mt-2">Rp {{ number_format($order->estimated_cost, 0, ',', '.') }}</strong>
                    </div>

                    <p class="text-muted mb-4">
                        Order ID: #{{ substr($order->id, 0, 8) }}<br>
                        Klik tombol di bawah untuk memilih metode pembayaran.
                    </p>

                    <button id="pay-button" class="btn btn-brand btn-lg w-100 fw-bold">
                        Pilih Metode Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        
        // Ambil elemen tombol
        var payButton = document.getElementById('pay-button');
        
        // Ambil token dari PHP
        var snapToken = '{{ $snapToken }}';

        // Cek di Console (Tekan F12 -> Console buat liat ini)
        console.log("Script siap!");
        console.log("Token Midtrans:", snapToken);

        // Event saat tombol diklik
        payButton.addEventListener('click', function () {
            
            console.log("Tombol Bayar Ditekan...");

            // Cek apakah library Snap sudah termuat
            if (typeof window.snap === 'undefined') {
                alert("Error: Library Midtrans gagal dimuat. Cek koneksi internet atau Client Key.");
                return;
            }

            // Panggil Pop-up
            window.snap.pay(snapToken, {
                onSuccess: function(result){
                    /* Ubah kode ini nanti untuk update status di database */
                    alert("Pembayaran Berhasil!");
                    console.log(result);
                    window.location.href = "{{ route('profil.activity') }}";
                },
                onPending: function(result){
                    /* Ubah kode ini nanti */
                    alert("Menunggu pembayaran Anda!");
                    console.log(result);
                },
                onError: function(result){
                    /* Ubah kode ini nanti */
                    alert("Pembayaran gagal!");
                    console.log(result);
                },
                onClose: function(){
                    /* Ubah kode ini nanti */
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    });
</script>
@endpush