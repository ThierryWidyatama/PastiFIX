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
                        <label for="avatarFileInput" class="profile-pic-edit-button d-none">
                            <i class="bi bi-pencil-fill"></i>
                        </label>

                        <input type="file" id="avatarFileInput" hidden>
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
                    
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Alamat Utama</h4>
                        <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#manageAddressModal">
                            <i class="bi bi-gear-fill me-1"></i> Kelola Alamat
                        </button>
                    </div>

                    <!-- Form Input (ID ditambahkan untuk sinkronisasi Map) -->
                    <div class="mb-3">
                        <label for="address_line" class="form-minimal-label">Alamat Lengkap</label>
                        <textarea class="form-control form-control-static" id="profile_address" name="address_line" rows="2" disabled>{{ $address->address_line ?? '' }}</textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rt_rw" class="form-minimal-label">RT/RW</label>
                            <input type="text" class="form-control form-control-static" id="rt_rw" name="rt_rw" value="{{ $address->rt_rw ?? '' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="postal_code" class="form-minimal-label">Kodepos</label>
                            <!-- [ID PENTING] -->
                            <input type="text" class="form-control form-control-static" id="profile_postcode" name="postal_code" value="{{ $address->postal_code ?? '' }}" disabled>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="landmark_details" class="form-minimal-label">Detail Patokan (Opsional)</label>
                        <input type="text" class="form-control form-control-static" id="landmark_details" name="landmark_details" value="{{ $address->landmark_details ?? '' }}" disabled>
                    </div>
                    
                    <h6 class="fw-bold">Titik Rumah</h6>

                    @if($address && $address->latitude && $address->longitude)
                        <!-- Peta View Only -->
                        <!-- [FIX] ID disamakan dengan JS -->
                        <div id="map-profile-main" style="height: 250px; width: 100%; border-radius: 8px; border: 2px solid #e0e0e0; z-index: 0;"></div>

                        <!-- [FIX] GANTI NAME JADI 'profile_...' AGAR TIDAK BENTROK DENGAN MODAL -->
                        <input type="hidden" id="main_lat" name="profile_latitude" value="{{ $address->latitude ?? '' }}">
                        <input type="hidden" id="main_lng" name="profile_longitude" value="{{ $address->longitude ?? '' }}">
                        
                        <div class="form-text small text-success mt-1">
                            <i class="bi bi-geo-alt-fill"></i> Lokasi terpilih: {{ $address->latitude }}, {{ $address->longitude }}
                        </div>
                    @else
                        <!-- Tampilan jika belum ada koordinat -->
                        <div class="alert alert-secondary small text-center p-4">
                            <i class="bi bi-geo-alt-slash fs-1 text-muted d-block mb-2"></i>
                            Belum ada titik lokasi di peta.<br>
                            Silakan klik <strong>"Kelola Alamat"</strong> lalu Edit/Tambah alamat dengan pin peta.
                        </div>
                    @endif
                    
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
                        <label class="form-label fw-bold">Titik Lokasi (Geser Pin)</label>
                        
                        <div id="map-container" style="height: 300px; width: 100%; border-radius: 8px; border: 2px solid #e0e0e0; z-index: 1;"></div>
                        
                        <div class="form-text small mt-1">
                            <i class="bi bi-geo-alt-fill text-danger"></i> Geser pin biru ke lokasi rumah Anda.
                        </div>
                        
                        <!-- [FIX] ID KITA UBAH JADI 'modal_...' BIAR UNIK -->
                        <input type="hidden" id="modal_lat" name="latitude"> 
                        <input type="hidden" id="modal_lng" name="longitude">
                    </div>

                    <!-- FORM ALAMAT -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Lengkap</label>
                        
                        <!-- [FIX] ID KITA UBAH JADI 'modal_address_input' -->
                        <textarea 
                            class="form-control" 
                            name="address_line" 
                            id="modal_address_input" 
                            rows="3" 
                            required 
                            placeholder="Cari lokasi atau geser pin pada peta..."
                        ></textarea>
                        
                        <div class="form-text small">Alamat akan terisi otomatis dari titik peta.</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">RT/RW</label>
                            <input type="text" class="form-control" name="rt_rw" placeholder="00/00">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kode Pos</label>
                            
                            <!-- [FIX] ID KITA UBAH JADI 'modal_postal_code' -->
                            <input type="text" class="form-control" name="postal_code" id="modal_postal_code" placeholder="50xxx">
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

<!-- ================== CROPper ================== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<script>
        // =====================================================
        // KONFIGURASI GLOBAL (Satu kali deklarasi aja biar ga error)
        // =====================================================
        const DEFAULT_LAT = -6.9932; // Koordinat Default (Semarang/Pati)
        const DEFAULT_LNG = 110.4203;


/* =====================================================
   BAGIAN 1 — CROP FOTO PROFIL
===================================================== */
let cropper;

const avatarInput        = document.getElementById("avatarFileInput");
const previewImg         = document.getElementById("profileImagePreview");
const croppedAvatarData  = document.getElementById("croppedAvatarData");
const cropModalEl        = document.getElementById("cropModal");
const cropModal          = new bootstrap.Modal(cropModalEl);

// Pilih file → buka modal crop
avatarInput.addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (event) {
        const img = document.getElementById("imageToCrop");
        img.src = event.target.result;

        cropModal.show();

        // Destroy cropper lama
        if (cropper) cropper.destroy();

        setTimeout(() => {
            cropper = new Cropper(img, {
                aspectRatio: 1,
                viewMode: 2,
                autoCropArea: 1,
                responsive: true
            });
        }, 300);
    };
    reader.readAsDataURL(file);
});

// Tombol crop
document.getElementById("cropButton").addEventListener("click", function () {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
        width: 500,
        height: 500
    });

    const base64 = canvas.toDataURL("image/jpeg");
    croppedAvatarData.value = base64;
    previewImg.src = base64;

    cropModal.hide();
});


        // =====================================================
        // BAGIAN 2 — MAP PROFIL UTAMA (VIEW & EDIT)
        // =====================================================
        
        let mainMap = null;
        let mainMarker = null;

        // Elemen-elemen
        const mapContainerMain = document.getElementById("map-profile-main");
        const inputLatMain = document.getElementById("main_lat");
        const inputLngMain = document.getElementById("main_lng");
        const inputAddressMain = document.getElementById("profile_address"); 
        const inputPostcodeMain = document.getElementById("profile_postcode");

        if (mapContainerMain && inputLatMain && inputLngMain) {
            
            // Ambil koordinat awal
            let lat = parseFloat(inputLatMain.value);
            let lng = parseFloat(inputLngMain.value);

            if (isNaN(lat) || isNaN(lng) || (lat === 0 && lng === 0)) {
                lat = DEFAULT_LAT;
                lng = DEFAULT_LNG;
            }

            // Init Map (Mode Static)
            mainMap = L.map("map-profile-main", {
                center: [lat, lng],
                zoom: 16,
                dragging: false,      
                touchZoom: false,     
                scrollWheelZoom: false,
                doubleClickZoom: false,
                zoomControl: false    
            });

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
                attribution: "© OSM"
            }).addTo(mainMap);

            mainMarker = L.marker([lat, lng], {
                draggable: false      
            }).addTo(mainMap);

            // Fix ukuran map saat load
            setTimeout(() => { mainMap.invalidateSize(); }, 500);


            // --- FUNGSI UPDATE DATA ---

            function updateAddressFromPin(lat, lng) {
                inputLatMain.value = lat;
                inputLngMain.value = lng;

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.display_name) {
                            inputAddressMain.value = data.display_name;
                        }
                        if (data && data.address && data.address.postcode) {
                            inputPostcodeMain.value = data.address.postcode;
                        }
                    });
            }

            // --- EVENT LISTENER MAP ---

            mainMarker.on('dragend', function (e) {
                const pos = mainMarker.getLatLng();
                updateAddressFromPin(pos.lat, pos.lng);
            });

            mainMap.on('click', function(e) {
                if (mainMarker.dragging.enabled()) { // Cuma jalan kalau mode edit aktif
                    mainMarker.setLatLng(e.latlng);
                    updateAddressFromPin(e.latlng.lat, e.latlng.lng);
                }
            });

            // [FITUR BARU] KETIK ALAMAT -> PINDAH PIN
            let typingTimerMain;
            if(inputAddressMain) {
                inputAddressMain.addEventListener('input', function () {
                    // Cek apakah sedang mode edit (disabled == false)
                    if (this.disabled) return;

                    clearTimeout(typingTimerMain);
                    const query = this.value;

                    if (query.length > 5) {
                        typingTimerMain = setTimeout(() => {
                            console.log("Mencari di Peta Utama:", query);
                            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                                .then(res => res.json())
                                .then(data => {
                                    if (data && data.length > 0) {
                                        const lat = parseFloat(data[0].lat);
                                        const lon = parseFloat(data[0].lon);

                                        // Pindahkan Peta & Marker
                                        mainMap.setView([lat, lon], 16);
                                        mainMarker.setLatLng([lat, lon]);

                                        // Update hidden input TAPI JANGAN update teks alamatnya lagi (biar ga looping)
                                        inputLatMain.value = lat;
                                        inputLngMain.value = lon;
                                    }
                                });
                        }, 1000); // Delay 1 detik
                    }
                });
            }
        }


        // =====================================================
        // BAGIAN 3 — MODE EDIT (TOMBOL EDIT DITEKAN)
        // =====================================================
        if(editButton) {
            editButton.addEventListener("click", function () {
                // 1. Hidupkan Form
                document.querySelectorAll("input[disabled], textarea[disabled]")
                    .forEach(el => el.disabled = false);

                // 2. Tukar Tombol
                saveButton.classList.remove("d-none");
                editButton.classList.add("d-none");
                
                // 3. Munculkan tombol edit foto
                const editIcon = document.querySelector(".profile-pic-edit-button");
                if(editIcon) editIcon.classList.remove("d-none");
                if(previewImg) previewImg.style.cursor = 'pointer';

                // 4. HIDUPKAN PETA UTAMA
                if (mainMap && mainMarker) {
                    mainMap.dragging.enable();
                    mainMap.touchZoom.enable();
                    mainMap.scrollWheelZoom.enable();
                    mainMap.doubleClickZoom.enable();
                    
                    // Tambah kontrol zoom
                    if (!document.querySelector('.leaflet-control-zoom')) {
                        L.control.zoom({ position: 'topleft' }).addTo(mainMap);
                    }

                    // Hidupkan Marker
                    mainMarker.dragging.enable();
                    
                    // Efek visual border
                    document.getElementById("map-profile-main").style.border = "2px solid #FEC81A";
                    
                    setTimeout(() => mainMap.invalidateSize(), 200);
                }
            });
        }


        // =====================================================
        // BAGIAN 4 — MAP MODAL TAMBAH ALAMAT (INDEPENDEN)
        // =====================================================
        let mapModal = null;
        let markerModal = null;

        function initMapModal() {
            if (!document.getElementById('map-container')) return;
            if (mapModal !== null) return;

            mapModal = L.map('map-container').setView([DEFAULT_LAT, DEFAULT_LNG], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OSM' }).addTo(mapModal);
            markerModal = L.marker([DEFAULT_LAT, DEFAULT_LNG], { draggable: true }).addTo(mapModal);

            const latInput = document.getElementById('modal_lat');
            const lngInput = document.getElementById('modal_lng');
            const addrInput = document.getElementById('modal_address_input');
            const zipInput = document.getElementById('modal_postal_code');

            if(latInput) latInput.value = DEFAULT_LAT;
            if(lngInput) lngInput.value = DEFAULT_LNG;

            function reverseGeocodeModal(lat, lng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.display_name && addrInput) addrInput.value = data.display_name;
                        if (data && data.address && data.address.postcode && zipInput) zipInput.value = data.address.postcode;
                    });
            }

            markerModal.on('dragend', function (e) {
                const pos = markerModal.getLatLng();
                if(latInput) latInput.value = pos.lat;
                if(lngInput) lngInput.value = pos.lng;
                reverseGeocodeModal(pos.lat, pos.lng);
            });

            mapModal.on('click', function(e) {
                markerModal.setLatLng(e.latlng);
                if(latInput) latInput.value = e.latlng.lat;
                if(lngInput) lngInput.value = e.latlng.lng;
                reverseGeocodeModal(e.latlng.lat, e.latlng.lng);
            });
            
             // Forward Geocode Modal (Ketik -> Pindah)
            let typingTimerModal;
            if (addrInput) {
                addrInput.addEventListener('input', function () {
                    clearTimeout(typingTimerModal);
                    const query = this.value;
                    if (query.length > 5) {
                        typingTimerModal = setTimeout(() => {
                            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                                .then(res => res.json())
                                .then(data => {
                                    if (data?.length > 0) {
                                        const lat = parseFloat(data[0].lat);
                                        const lon = parseFloat(data[0].lon);
                                        mapModal.setView([lat, lon], 16);
                                        markerModal.setLatLng([lat, lon]);
                                        if(latInput) latInput.value = lat;
                                        if(lngInput) lngInput.value = lon;
                                    }
                                });
                        }, 1000);
                    }
                });
            }
        }

        const modalAdd = document.getElementById('addProfileAddressModal');
        if (modalAdd) {
            modalAdd.addEventListener('shown.bs.modal', function () {
                initMapModal();
                setTimeout(() => { if(mapModal) mapModal.invalidateSize(); }, 200);
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

