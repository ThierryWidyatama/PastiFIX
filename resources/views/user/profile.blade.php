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
                    <button class="btn btn-sm btn-brand fw-bold ms-3" data-bs-toggle="modal" data-bs-target="#addProfileAddressModal">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </button>
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
<!-- [BARU] Modal Tambah Alamat (Khusus Profil) -->
<div class="modal fade" id="addProfileAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Form Action pakai route yg sama dgn checkout -->
            <form action="{{ route('address.store') }}" method="POST">
                @csrf
                <!-- [PENTING] Redirect kembali ke PROFIL setelah simpan -->
                <input type="hidden" name="redirect_to" value="{{ route('profil') }}">
                
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Alamat Baru</h5>
                    <!-- Tombol X kembali ke modal manage -->
                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#manageAddressModal"></button>
                </div>
                <div class="modal-body">
                    <!-- AREA PETA (LEAFLET) -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Titik Lokasi</label>
                        
                        <!-- Wadah Peta -->
                        <div id="map-container" class="mb-2"></div>
                        
                        <div class="form-text small text-muted">
                            <i class="bi bi-info-circle me-1"></i> Geser pin biru atau klik pada peta untuk menandai lokasi.
                        </div>
                        
                        <!-- Input Tersembunyi untuk Koordinat -->
                        <input type="hidden" id="latitude_input" name="latitude">
                        <input type="hidden" id="longitude_input" name="longitude">
                    </div>

                    <!-- FORM ALAMAT DETIL -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Lengkap</label>
                        <!-- Input ini "pintar": Ketik untuk cari lokasi, atau otomatis terisi dari pin -->
                        <textarea 
                            class="form-control" 
                            name="address_line" 
                            id="address_input" 
                            rows="3" 
                            required 
                            placeholder="Cari lokasi atau geser pin pada peta..."
                        ></textarea>
                        <div class="form-text small">Alamat akan terisi otomatis dari titik peta. Anda bisa melengkapinya manual.</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">RT/RW</label>
                            <input type="text" class="form-control" name="rt_rw" placeholder="00/00">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kode Pos</label>
                            <!-- [FIX] Tambahkan id="postal_code_input" -->
                            <input type="text" class="form-control" name="postal_code" id="postal_code_input" placeholder="50xxx">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Detail Patokan</label>
                        <input type="text" class="form-control" name="landmark_details" placeholder="Cth: Depan masjid hijau, pagar hitam">
                    </div>

                    <hr class="my-3">
                    
                    <!-- Input Hidden & Checkbox (Sesuai kebutuhanmu sebelumnya) -->
                    <input type="hidden" name="is_saved" value="1">
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="profile_new_is_primary">
                        <label class="form-check-label" for="profile_new_is_primary">Jadikan Alamat Utama</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#manageAddressModal">Batal</button>
                    <button type="submit" class="btn btn-brand">Simpan Alamat</button>
                </div>
            </form>
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

// ==========================================
    // BAGIAN 2: LOGIKA PETA LEAFLET (ADD ADDRESS)
    // ==========================================
    
    let map = null;
    let marker = null;
    let mapInitialized = false;

    // Koordinat Default (Simpang Lima Semarang)
    const defaultLat = -6.9932; 
    const defaultLng = 110.4203;

    function initMap() {
        if (mapInitialized) return; // Cegah double init
        
        // Cek elemen
        if (!document.getElementById('map-container')) return;

        // 1. Buat Peta
        map = L.map('map-container').setView([defaultLat, defaultLng], 15);

        // 2. Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // 3. Marker
        marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        // Elemen Input
        const latInput = document.getElementById('latitude_input');
        const lngInput = document.getElementById('longitude_input');
        const addressInput = document.getElementById('address_input');

        // Set nilai awal
        if(latInput) latInput.value = defaultLat;
        if(lngInput) lngInput.value = defaultLng;

        // === FUNGSI BANTUAN ===

        // A. Reverse Geocode (Koordinat -> Alamat Teks)
        // Dipanggil saat marker digeser/diklik
        // A. Reverse Geocode (Koordinat -> Alamat Teks & Kode Pos)
        function reverseGeocode(lat, lng) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // 1. Isi Alamat Lengkap
                    if (data && data.display_name && addressInput) {
                        addressInput.value = data.display_name;
                    }

                    // 2. [BARU] Isi Kode Pos Otomatis
                    // Cek apakah data address dan postcode tersedia
                    if (data && data.address && data.address.postcode) {
                        const postalInput = document.getElementById('postal_code_input');
                        if (postalInput) {
                            postalInput.value = data.address.postcode;
                            // Efek visual dikit biar user tau itu berubah
                            postalInput.style.backgroundColor = "#fff9db"; 
                            setTimeout(() => postalInput.style.backgroundColor = "", 1000);
                        }
                    }
                })
                .catch(error => console.error('Error reverse geocoding:', error));
        }

        // B. Forward Geocode (Teks Alamat -> Koordinat)
        // Dipanggil saat user mengetik di textarea alamat
        let typingTimer;
        if (addressInput) {
            addressInput.addEventListener('input', function () {
                clearTimeout(typingTimer);
                const query = this.value;

                // Tunggu user selesai ngetik 1 detik baru cari (biar gak spam API)
                if (query.length > 5) {
                    typingTimer = setTimeout(() => {
                        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;
                        
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                if (data && data.length > 0) {
                                    const result = data[0];
                                    const lat = parseFloat(result.lat);
                                    const lon = parseFloat(result.lon);

                                    // Pindahkan map & marker
                                    map.setView([lat, lon], 16);
                                    marker.setLatLng([lat, lon]);
                                    
                                    // Update input hidden
                                    if(latInput) latInput.value = lat;
                                    if(lngInput) lngInput.value = lon;
                                }
                            })
                            .catch(error => console.error('Error searching address:', error));
                    }, 1000);
                }
            });
        }

        // === EVENT LISTENER PETA ===

        // Saat marker selesai digeser manual
        marker.on('dragend', function (e) {
            const position = marker.getLatLng();
            if(latInput) latInput.value = position.lat;
            if(lngInput) lngInput.value = position.lng;
            reverseGeocode(position.lat, position.lng);
        });

        // Saat peta diklik
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            if(latInput) latInput.value = e.latlng.lat;
            if(lngInput) lngInput.value = e.latlng.lng;
            reverseGeocode(e.latlng.lat, e.latlng.lng);
        });

        mapInitialized = true;
    }

    // [PENTING] Trigger saat Modal Muncul
    const modalAddAddress = document.getElementById('addProfileAddressModal'); 
    
    if (modalAddAddress) {
        modalAddAddress.addEventListener('shown.bs.modal', function () {
            // Init map (hanya sekali)
            initMap(); 
            
            // Fix ukuran map (Leaflet suka abu-abu kalau di modal)
            setTimeout(() => {
                if(map) map.invalidateSize(); 
            }, 200);
        });
    }
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

