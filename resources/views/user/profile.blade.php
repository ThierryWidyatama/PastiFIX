@extends('layouts.dashboard')

@section('content')

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<form id="profileForm" action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
    @csrf 
    
    <div class="row g-4">
        
        <div class="col-12 col-lg-6">
            
            <div class="card p-4">
                <div class="card-body text-center">
                    
                    <div class="position-relative d-inline-block">
                        <img src="{{ $user->profile_picture_url ? Storage::url($user->profile_picture_url) : asset('assets/img/default-avatar.png') }}" 
                             alt="Profile Picture" class="profile-pic mb-3" id="profileImagePreview">
                        <label for="avatar" class="profile-pic-edit-button d-none">
                            <i class="bi bi-pencil-fill"></i>
                        </label>
                        <input type="file" name="avatar_file_input" id="avatarFileInput" class="d-none" accept="image/*">
                        <input type="hidden" name="cropped_avatar_data" id="croppedAvatarData">
                    </div>

                    <h4 class="fw-bold">My Profile</h4>
                    <hr class="my-4">
                    <div class="text-start">
                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-4"><label for="name" class="profile-info-label">Nama Lengkap:</label></div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-static" id="name" name="name" value="{{ $user->name }}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-4"><label for="phone_number" class="profile-info-label">No. Hp:</label></div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-static" id="phone_number" name="phone_number" value="{{ $user->phone_number ?? '' }}" disabled>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="editButton" class="btn btn-brand mt-4">Edit</button>
                    <button type="submit" id="saveButton" class="btn btn-success mt-4 d-none">Save Changes</button>
                </div>
            </div>

            <div class="card p-4 mt-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-4">Pesanan</h4>
                    <div class="status-item mb-3">
                        <div class="status-dot-wrapper"> <span class="status-dot dot-green"></span> On Progress </div>
                        <span>{{ $stats['on_progress'] }}</span>
                    </div>
                    <div class="status-item mb-3">
                        <div class="status-dot-wrapper"> <span class="status-dot dot-yellow"></span> Selesai </div>
                        <span>{{ $stats['selesai'] }}</span>
                    </div>
                    <div class="status-item">
                        <div class="status-dot-wrapper"> <span class="status-dot dot-red"></span> Cancelled </div>
                        <span>{{ $stats['cancelled'] }}</span>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="col-12 col-lg-6">
            <div class="card p-4 h-100">
                <div class="card-body">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Alamat Utama</h4>
                        <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#manageAddressModal">
                            <i class="bi bi-gear-fill me-1"></i> Kelola Alamat Tersimpan
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="address_line" class="form-minimal-label">Alamat Lengkap</label>
                        <input type="text" class="form-control form-minimal-input" id="address_line" name="address_line" value="{{ $address->address_line ?? '' }}" disabled>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rt_rw" class="form-minimal-label">RT/RW</label>
                            <input type="text" class="form-control form-minimal-input" id="rt_rw" name="rt_rw" value="{{ $address->rt_rw ?? '' }}" disabled>
                        </div>
                        <div class="col-md-6">
                             <label for="postal_code" class="form-minimal-label">Kodepos</label>
                             <input type="text" class="form-control form-minimal-input" id="postal_code" name="postal_code" value="{{ $address->postal_code ?? '' }}" disabled>
                        </div>
                    </div>
                     <div class="mb-4">
                        <label for="landmark_details" class="form-minimal-label">Detail Patokan (Opsional)</label>
                        <input type="text" class="form-control form-minimal-input" id="landmark_details" name="landmark_details" value="{{ $address->landmark_details ?? '' }}" disabled>
                    </div>
                    
                    <h6 class="fw-bold">Titik Rumah</h6>
                    <p class="text-muted small">Titik lokasi akan diatur saat proses pemesanan.</p> 
                    
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cropModalLabel">Crop Gambar Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-body-cropper">
        <div class="img-container">
          <img id="imageToCrop" src="" alt="Gambar untuk di-crop">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="cropButton">Crop & Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="manageAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Kelola Daftar Alamat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light" style="max-height: 60vh; overflow-y: auto;">
                
                @php 
                    $allAddresses = Auth::user()->addresses()
                                    ->where('is_saved', true) // <--- FILTER PENTING
                                    ->orderBy('is_primary', 'desc')
                                    ->get(); 
                @endphp

                @forelse($allAddresses as $addr)
                    <div class="card border-0 shadow-sm mb-3 {{ $addr->is_primary ? 'border-start border-warning border-5' : '' }}">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                            <div>
                                @if($addr->is_primary)
                                    <span class="badge bg-warning text-dark mb-2">UTAMA</span>
                                @endif
                                <p class="mb-1 fw-bold text-dark fs-5">{{ $addr->address_line }}</p>
                                <p class="mb-0 text-muted small">
                                    {{ $addr->rt_rw ? 'RT/RW: '.$addr->rt_rw . ',' : '' }} 
                                    {{ $addr->postal_code ? 'Kode Pos: '.$addr->postal_code : '' }} <br>
                                    {{ $addr->landmark_details ? '('.$addr->landmark_details.')' : '' }}
                                </p>
                            </div>

                            <div class="d-flex gap-2">
                                @if(!$addr->is_primary)
                                    <form action="{{ route('address.primary', $addr->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Jadikan Alamat Utama">
                                            <i class="bi bi-check-circle-fill"></i> Utama
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('address.destroy', $addr->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alamat ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Alamat">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <img src="{{ asset('assets/img/no-data.png') }}" alt="Kosong" style="width: 80px; opacity: 0.5;">
                        <p class="text-muted mt-3">Belum ada alamat tersimpan.</p>
                    </div>
                @endforelse

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<!-- CropperJS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
let cropper;
const avatarInput = document.getElementById("avatarFileInput");
const previewImg = document.getElementById("profileImagePreview");
const cropModal = new bootstrap.Modal(document.getElementById("cropModal"));
const croppedAvatarData = document.getElementById("croppedAvatarData");

const editButton = document.getElementById("editButton");
const saveButton = document.getElementById("saveButton");

// ✅ Mode Edit → enable semua input
editButton.addEventListener("click", function () {
    document.querySelectorAll("input[disabled]").forEach(el => el.disabled = false);

    // Tampilkan tombol SAVE
    saveButton.classList.remove("d-none");

    // Hide tombol EDIT
    editButton.classList.add("d-none");

    // Munculkan icon edit foto
    document.querySelector(".profile-pic-edit-button").classList.remove("d-none");
});

// ✅ Klik icon pensil → buka file dialog
document.querySelector(".profile-pic-edit-button").addEventListener("click", function () {
    avatarInput.click();
});

// ✅ Saat pilih gambar → tampilkan modal crop
avatarInput.addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (event) {
        document.getElementById("imageToCrop").src = event.target.result;

        // Destroy cropper sebelumnya
        if (cropper) { cropper.destroy(); }

        cropModal.show();

        setTimeout(() => {
            cropper = new Cropper(document.getElementById("imageToCrop"), {
                aspectRatio: 1,
                viewMode: 2,
                dragMode: 'move',
                autoCropArea: 1,
                responsive: true
            });
        }, 300);
    };
    reader.readAsDataURL(file);
});

// ✅ Tombol "Crop & Simpan"
document.getElementById("cropButton").addEventListener("click", function () {
    const canvas = cropper.getCroppedCanvas({
        width: 500,
        height: 500,
    });

    const base64 = canvas.toDataURL("image/jpeg");

    // Set hidden input agar dikirim ke server
    croppedAvatarData.value = base64;

    // Update preview
    previewImg.src = base64;

    cropModal.hide();

    // Aktifkan tombol Save
    saveButton.classList.remove("d-none");
});
</script>
@endpush
<style>
.profile-pic {
    width: 150px;
    height: 150px;
    border-radius: 100%;
    object-fit: cover;
    border: 3px solid #ddd;
}

.profile-pic-edit-button {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: #000000a8;
    color: white;
    padding: 6px 8px;
    border-radius: 50%;
    cursor: pointer;
}
</style>

