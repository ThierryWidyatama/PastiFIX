@extends('layouts.dashboard')

@section('content')

<div class="row g-4">
    <div class="col-12 col-lg-6">
        <div class="card p-4 h-100">
            <div class="card-body text-center">
                <img src="{{ asset('assets/img/user1.jpeg') }}" alt="Profile Picture" class="profile-pic mb-3">
                <h4 class="fw-bold">My Profile</h4>
                <hr class="my-4">

                <div class="text-start">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <span class="profile-info-label">Nama Lengkap:</span>
                        </div>
                        <div class="col-sm-8">
                            <span class="profile-info-value">Thierry Widyatama</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <span class="profile-info-label">No. Hp:</span>
                        </div>
                        <div class="col-sm-8">
                            <span class="profile-info-value">0899801187450</span>
                        </div>
                    </div>
                </div>

                <a href="#" class="btn btn-brand mt-4">Edit</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card p-4">
            <div class="card-body">
                <h4 class="fw-bold mb-4">Alamat</h4>
                <form>
                    <div class="mb-3">
                        <input type="text" class="form-control form-minimal-input" id="alamat" placeholder="Alamat Lengkap">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control form-minimal-input" id="rt-rw" placeholder="RT/RW">
                        </div>
                        <div class="col-md-6">
                             <input type="text" class="form-control form-minimal-input" id="kodepos" placeholder="Kodepos">
                        </div>
                    </div>
                     <div class="mb-4">
                        <input type="text" class="form-control form-minimal-input" id="patokan" placeholder="Detail Patokan (Opsional)">
                    </div>

                    <h6 class="fw-bold">Titik Rumah</h6>
                    <img src="{{ asset('assets/img/maps.png') }}" alt="Peta Lokasi" class="img-fluid rounded mt-2">
                </form>
            </div>
        </div>

        <div class="card p-4 mt-4">
            <div class="card-body">
                <h4 class="fw-bold mb-4">Pesanan</h4>
                
                <div class="status-item mb-3">
                    <div class="status-dot-wrapper">
                        <span class="status-dot dot-green"></span> On Progress
                    </div>
                    <span>1</span>
                </div>
                
                <div class="status-item mb-3">
                    <div class="status-dot-wrapper">
                        <span class="status-dot dot-yellow"></span> Selesai
                    </div>
                    <span>1</span>
                </div>

                <div class="status-item">
                    <div class="status-dot-wrapper">
                        <span class="status-dot dot-red"></span> Cancelled
                    </div>
                    <span>1</span>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection