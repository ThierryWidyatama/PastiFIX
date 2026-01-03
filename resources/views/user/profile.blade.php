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
                            <input type="file" name="avatar_file_input" id="avatarFileInput" class="d-none"
                                accept="image/*">
                            <input type="hidden" name="cropped_avatar_data" id="croppedAvatarData">
                        </div>

                        <h4 class="fw-bold">Profil Saya</h4>
                        <hr class="my-4">
                        <div class="text-start">
                            <div class="row mb-3 align-items-center">
                                <div class="col-sm-4"><label for="name" class="profile-info-label">Nama Lengkap:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-static" id="name"
                                        name="name" value="{{ $user->name }}" disabled>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center">
                                <div class="col-sm-4"><label for="phone_number" class="profile-info-label">No. Hp:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-static" id="phone_number"
                                        name="phone_number" value="{{ $user->phone_number ?? '' }}" disabled>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="editButton" class="btn btn-brand mt-4">Ganti</button>
                        <button type="submit" id="saveButton" class="btn btn-success mt-4 d-none">Simpan Perubahan</button>
                    </div>
                </div>

                <div class="card p-4 mt-4">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Pesanan</h4>
                        <div class="status-item mb-3">
                            <div class="status-dot-wrapper"> <span class="status-dot dot-yellow"></span> Sedang Berlangsung
                            </div>
                            <span>{{ $stats['on_progress'] }}</span>
                        </div>
                        <div class="status-item mb-3">
                            <div class="status-dot-wrapper"> <span class="status-dot dot-green"></span> Selesai </div>
                            <span>{{ $stats['selesai'] }}</span>
                        </div>
                        <div class="status-item">
                            <div class="status-dot-wrapper"> <span class="status-dot dot-red"></span> Dibatalkan </div>
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
                            <button type="button" class="btn btn-sm btn-brand fw-bold" data-bs-toggle="modal"
                                data-bs-target="#manageAddressModal">
                                <i class="bi bi-gear-fill me-1"></i> Kelola Alamat
                            </button>
                        </div>

                        <!-- Form Input (ID ditambahkan untuk sinkronisasi Map) -->
                        <div class="mb-3">
                            <label for="address_line" class="form-minimal-label">
                                Alamat Lengkap
                                <span id="status-text-main" class="text-danger small fst-italic ms-2" style="display:none;">
                                    <div class="spinner-border spinner-border-sm me-1" role="status"></div>Memuat...
                                </span>
                            </label>
                            <input type="text" class="form-control form-minimal-input" id="profile_address"
                                name="address_line" value="{{ $address->address_line ?? '' }}" disabled>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="rt_rw" class="form-minimal-label">RT/RW</label>
                                <!-- [FIX] Ganti class jadi form-minimal-input -->
                                <input type="text" class="form-control form-minimal-input" id="rt_rw" name="rt_rw"
                                    value="{{ $address->rt_rw ?? '' }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="postal_code" class="form-minimal-label">Kodepos</label>
                                <!-- [FIX] Ganti class jadi form-minimal-input -->
                                <input type="text" class="form-control form-minimal-input" id="profile_postcode"
                                    name="postal_code" value="{{ $address->postal_code ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="landmark_details" class="form-minimal-label">Detail Patokan (Opsional)</label>
                            <!-- [FIX] Ganti class jadi form-minimal-input -->
                            <input type="text" class="form-control form-minimal-input" id="landmark_details"
                                name="landmark_details" value="{{ $address->landmark_details ?? '' }}" disabled>
                        </div>

                        <h6 class="fw-bold">Titik Rumah</h6>
                        @if ($address && $address->latitude && $address->longitude)
                            <!-- [BARU] Wrapper & Loading -->
                            <div class="map-wrapper mb-2">
                                <div id="loading-map-main" class="map-loading">
                                    <div class="spinner-border mb-2" role="status"></div>
                                    <span>Mencari titik...</span>
                                </div>
                                <div id="map-profile-main" class="map-canvas"></div>
                            </div>

                            <input type="hidden" id="main_lat" name="profile_latitude"
                                value="{{ $address->latitude }}">
                            <input type="hidden" id="main_lng" name="profile_longitude"
                                value="{{ $address->longitude }}">

                            <div class="form-text small text-success mt-1">
                                <i class="bi bi-geo-alt-fill"></i> Lokasi terpilih: {{ $address->latitude }},
                                {{ $address->longitude }}
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
                    <h5 class="modal-title" id="cropModalLabel">Potong Gambar Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-cropper">
                    <div class="img-container">
                        <img id="imageToCrop" src="" alt="Gambar untuk di-crop">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="cropButton">Potong & Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('modals')
    <div class="modal fade" id="manageAddressModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold me-2 ">Kelola Daftar Alamat</h5>
                    <button type="button" class="btn btn-sm btn-danger fw-bold" data-bs-toggle="modal"
                        data-bs-target="#addProfileAddressModal">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </button>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light" style="max-height: 60vh; overflow-y: auto;">

                    @php
                        $allAddresses = Auth::user()
                            ->addresses()
                            ->where('is_saved', true) // <--- FILTER PENTING
                            ->orderBy('is_primary', 'desc')
                            ->get();
                    @endphp

                    @forelse($allAddresses as $addr)
                        @if (!$addr->id)
                            @continue
                        @endif
                        <div
                            class="card border-0 shadow-sm mb-3 {{ $addr->is_primary ? 'border-start border-danger border-5' : '' }}">
                            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    @if ($addr->is_primary)
                                        <span class="badge bg-danger text-white mb-2">UTAMA</span>
                                    @endif
                                    <p class="mb-1 fw-bold text-dark fs-5">{{ $addr->address_line }}</p>
                                    <p class="mb-0 text-muted small">
                                        {{ $addr->rt_rw ? 'RT/RW: ' . $addr->rt_rw . ',' : '' }}
                                        {{ $addr->postal_code ? 'Kode Pos: ' . $addr->postal_code : '' }} <br>
                                        {{ $addr->landmark_details ? '(' . $addr->landmark_details . ')' : '' }}
                                    </p>
                                </div>

                                <div class="d-flex gap-2">
                                    @if (!$addr->is_primary)
                                        <form action="{{ route('address.primary', $addr->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success"
                                                title="Jadikan Alamat Utama">
                                                <i class="bi bi-check-circle-fill"></i> Utama
                                            </button>
                                        </form>
                                    @endif

                                    <!-- [FIX] Tambahkan ID unik -->
                                    <form id="delete-form-profile-{{ $addr->id }}"
                                        action="{{ route('address.destroy', $addr->id) }}" method="POST">
                                        @csrf @method('DELETE')

                                        <!-- [FIX] Ubah jadi type="button" dan pakai onclick -->
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Alamat"
                                            onclick="confirmDeleteProfile('{{ $addr->id }}', this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <img src="{{ asset('assets/img/no-data.png') }}" alt="Kosong"
                                style="width: 80px; opacity: 0.5;">
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
                        <button type="button" class="btn-close" data-bs-toggle="modal"
                            data-bs-target="btnBackToManage"></button>
                    </div>
                    <div class="modal-body">
                        <!-- AREA PETA (LEAFLET) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Titik Lokasi (Geser Pin)</label>

                            <!-- [BARU] Wrapper & Loading -->
                            <div class="map-wrapper">
                                <div id="loading-map-modal" class="map-loading">
                                    <div class="spinner-border mb-2" role="status"></div>
                                    <span>Mencari titik...</span>
                                </div>
                                <div id="map-container" class="map-canvas"></div>
                            </div>

                            <div class="form-text small mt-1">
                                <i class="bi bi-geo-alt-fill text-danger"></i> Geser pin biru ke lokasi rumah Anda.
                            </div>

                            <input type="hidden" id="modal_lat" name="latitude">
                            <input type="hidden" id="modal_lng" name="longitude">
                        </div>

                        <!-- FORM ALAMAT -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Alamat Lengkap
                                <!-- Teks Loading Kecil -->
                                <span id="status-text-modal" class="text-warning small fst-italic ms-2"
                                    style="display:none;">(Memuat alamat...)</span>
                            </label>

                            <!-- [FIX] ID KITA UBAH JADI 'modal_address_input' -->
                            <textarea class="form-control" name="address_line" id="modal_address_input" rows="3" required
                                placeholder="Cari lokasi atau geser pin pada peta..."></textarea>

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
                                <input type="text" class="form-control" name="postal_code" id="modal_postal_code"
                                    placeholder="50xxx">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Detail Patokan</label>
                            <input type="text" class="form-control" name="landmark_details"
                                placeholder="Cth: Depan masjid hijau, pagar hitam">
                        </div>

                        <hr class="my-3">

                        <!-- Input Hidden & Checkbox (Sesuai kebutuhanmu sebelumnya) -->
                        <input type="hidden" name="is_saved" value="1">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_primary" value="1"
                                id="profile_new_is_primary">
                            <label class="form-check-label" for="profile_new_is_primary">Jadikan Alamat Utama</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="btnBackToManage">Batal</button>
                        <button type="submit" class="btn btn-brand">Simpan Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
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

        // --- HELPER: DEBOUNCE (REM OTOMATIS) ---
        // Fungsi Debounce (Jeda waktu biar ga spam server)
        function debounce(func, timeout = 1000) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    func.apply(this, args);
                }, timeout);
            };
        }


        /* =====================================================
           BAGIAN 1 — CROP FOTO PROFIL
        ===================================================== */
        let cropper;

        const avatarInput = document.getElementById("avatarFileInput");
        const previewImg = document.getElementById("profileImagePreview");
        const croppedAvatarData = document.getElementById("croppedAvatarData");
        const cropModalEl = document.getElementById("cropModal");
        const cropModal = new bootstrap.Modal(cropModalEl);

        // Pilih file → buka modal crop
        avatarInput.addEventListener("change", function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(event) {
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
        document.getElementById("cropButton").addEventListener("click", function() {
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
        // FUNGSI UMUM: SETUP MAP EVENTS + LOADING
        // =====================================================
        function setupMapEvents(map, marker, latInputId, lngInputId, addrInputId, zipInputId, loadingMapId, statusTextId) {
            const latInput = document.getElementById(latInputId);
            const lngInput = document.getElementById(lngInputId);
            const addrInput = document.getElementById(addrInputId);
            const zipInput = document.getElementById(zipInputId);
            const loadingMap = document.getElementById(loadingMapId);
            const statusText = document.getElementById(statusTextId);

            // Helper: Toggle Loading Input
            function toggleInputLoading(isLoading) {
                if (!addrInput) return;
                if (isLoading) {
                    addrInput.classList.add('input-loading');
                    addrInput.setAttribute('readonly', true);
                    if (statusText) statusText.style.display = 'inline';
                } else {
                    addrInput.classList.remove('input-loading');
                    addrInput.removeAttribute('readonly');
                    if (statusText) statusText.style.display = 'none';
                }
            }

            // Helper: Toggle Loading Peta
            function toggleMapLoading(isLoading) {
                if (loadingMap) loadingMap.style.display = isLoading ? 'flex' : 'none';
            }

            function updateInputs(lat, lng) {
                if (latInput) latInput.value = lat;
                if (lngInput) lngInput.value = lng;
            }

            // A. Reverse (Pin -> Teks)
            const doReverseGeocode = debounce((lat, lng) => {
                fetch(`/geocode/reverse?lat=${lat}&lon=${lng}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.display_name && addrInput) addrInput.value = data.display_name;
                        if (data && data.address && data.address.postcode && zipInput) {
                            zipInput.value = data.address.postcode;
                            zipInput.style.backgroundColor = "#fff9db";
                            setTimeout(() => zipInput.style.backgroundColor = "", 1500);
                        }
                    })
                    .catch(err => console.warn("Geo Error:", err))
                    .finally(() => toggleInputLoading(false)); // STOP LOADING
            }, 1000);

            // B. Forward (Teks -> Pin)
            const doForwardGeocode = debounce((query) => {
                fetch(`/geocode/search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            const lat = parseFloat(data[0].lat);
                            const lon = parseFloat(data[0].lon);
                            map.setView([lat, lon], 16);
                            marker.setLatLng([lat, lon]);
                            updateInputs(lat, lon);
                        }
                    })
                    .catch(err => console.warn("Geo Error:", err))
                    .finally(() => toggleMapLoading(false)); // STOP LOADING
            }, 1500);

            // Listeners
            marker.on('dragstart', function() {
                toggleInputLoading(true);
            });
            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                updateInputs(pos.lat, pos.lng);
                doReverseGeocode(pos.lat, pos.lng);
            });

            map.on('click', function(e) {
                if (marker.dragging.enabled()) { // Cek if draggable (mode edit)
                    toggleInputLoading(true);
                    marker.setLatLng(e.latlng);
                    updateInputs(e.latlng.lat, e.latlng.lng);
                    doReverseGeocode(e.latlng.lat, e.latlng.lng);
                }
            });

            if (addrInput) {
                addrInput.addEventListener('input', function() {
                    // Cek disabled (untuk main map)
                    if (this.disabled) return;

                    const query = this.value;
                    if (query.length > 5) {
                        toggleMapLoading(true);
                        doForwardGeocode(query);
                    }
                });
            }
        }

        // Fungsi Hapus Alamat di Profil
        function confirmDeleteProfile(id, btn) {
            if (confirm('Apakah Anda yakin ingin menghapus alamat ini?')) {
                // 1. Matikan tombol & kasih efek loading (Panggil Helper Global)
                if (window.setLoading) {
                    window.setLoading(btn);
                } else {
                    // Fallback manual kalau helper gak ketemu
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                }

                // 2. Submit form secara manual
                document.getElementById('delete-form-profile-' + id).submit();
            }
            // Kalau pilih Cancel, kode di atas gak jalan, jadi tombol TETAP AMAN (gak loading).
        }


        // =====================================================
        // BAGIAN 2 — MAP PROFIL UTAMA (MAIN)
        // =====================================================

        let mainMap = null;
        let mainMarker = null;
        const elMainLat = document.getElementById("main_lat");
        const elMainLng = document.getElementById("main_lng");

        function initMainMap() {
            const elContainer = document.getElementById("map-profile-main");
            if (!elContainer || !elMainLat || !elMainLng) return;

            let lat = parseFloat(elMainLat.value);
            let lng = parseFloat(elMainLng.value);

            if (isNaN(lat) || isNaN(lng) || (lat === 0 && lng === 0)) {
                lat = DEFAULT_LAT;
                lng = DEFAULT_LNG;
            }

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
            setTimeout(() => {
                mainMap.invalidateSize();
            }, 500);

            // [FIX] Panggil Setup dengan ID Loading
            setupMapEvents(mainMap, mainMarker, 'main_lat', 'main_lng', 'profile_address', 'profile_postcode',
                'loading-map-main', 'status-text-main');
        }

        initMainMap();


        // =====================================================
        // BAGIAN 3 — MODE EDIT TRIGGER (LOGIKA BARU)
        // =====================================================
        if (editButton) {
            editButton.addEventListener("click", function() {

                // 1. HIDUPKAN KOLOM NAMA & HP (Selalu boleh)
                const inputName = document.getElementById('name');
                const inputPhone = document.getElementById('phone_number');

                if (inputName) {
                    inputName.disabled = false;
                    inputName.classList.remove('form-control-static');
                    inputName.classList.add('form-minimal-input');
                }
                if (inputPhone) {
                    inputPhone.disabled = false;
                    inputPhone.classList.remove('form-control-static');
                    inputPhone.classList.add('form-minimal-input');
                }

                // 2. CEK APAKAH ALAMAT ADA ISINYA?
                // Kita cek value dari textarea alamat utama
                const currentAddress = document.getElementById("profile_address").value.trim();
                const hasAddress = currentAddress.length > 0;

                if (hasAddress) {
                    // JIKA ADA ALAMAT: Hidupkan semua input alamat & Peta
                    document.getElementById("profile_address").disabled = false;
                    document.getElementById("rt_rw").disabled = false;
                    document.getElementById("profile_postcode").disabled = false;
                    document.getElementById("landmark_details").disabled = false;

                    // Ubah style input alamat jadi mode edit
                    [
                        "profile_address", "rt_rw", "profile_postcode", "landmark_details"
                    ].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) {
                            el.classList.remove('form-control-static');
                            el.classList.add('form-minimal-input');
                        }
                    });

                    // Hidupkan Peta Utama
                    if (mainMap && mainMarker) {
                        mainMap.dragging.enable();
                        mainMap.touchZoom.enable();
                        mainMap.scrollWheelZoom.enable();
                        mainMap.doubleClickZoom.enable();
                        if (!document.querySelector('.leaflet-control-zoom')) {
                            L.control.zoom({
                                position: 'topleft'
                            }).addTo(mainMap);
                        }
                        mainMarker.dragging.enable();
                        document.getElementById("map-profile-main").style.border = "2px solid #FEC81A";
                        setTimeout(() => mainMap.invalidateSize(), 200);
                    }
                } else {
                    // JIKA ALAMAT KOSONG:
                    // Jangan hidupkan input alamat & peta.
                    // Opsional: Kasih alert kecil/console log
                    console.log("Alamat kosong, edit via Kelola Alamat.");
                }

                // 3. UI Umum (Tombol & Foto)
                saveButton.classList.remove("d-none");
                editButton.classList.add("d-none");

                const editIcon = document.querySelector(".profile-pic-edit-button");
                if (editIcon) editIcon.classList.remove("d-none");
                if (previewImg) previewImg.style.cursor = 'pointer';
            });
        }


        // =====================================================
        // BAGIAN 4 — MAP MODAL TAMBAH (MODAL)
        // =====================================================
        let mapModal = null;
        let markerModal = null;

        function initMapModal() {
            if (!document.getElementById('map-container')) return;
            if (mapModal !== null) return;

            mapModal = L.map('map-container').setView([DEFAULT_LAT, DEFAULT_LNG], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OSM'
            }).addTo(mapModal);
            markerModal = L.marker([DEFAULT_LAT, DEFAULT_LNG], {
                draggable: true
            }).addTo(mapModal);

            // Set default hidden
            const latInput = document.getElementById('modal_lat');
            const lngInput = document.getElementById('modal_lng');
            if (latInput) latInput.value = DEFAULT_LAT;
            if (lngInput) lngInput.value = DEFAULT_LNG;

            // [FIX] Panggil Setup dengan ID Loading Modal & Status Text Modal
            setupMapEvents(mapModal, markerModal, 'modal_lat', 'modal_lng', 'modal_address_input', 'modal_postal_code',
                'loading-map-modal', 'status-text-modal');
        }

        const modalAdd = document.getElementById('addProfileAddressModal');
        if (modalAdd) {
            modalAdd.addEventListener('shown.bs.modal', function() {
                initMapModal();
                setTimeout(() => {
                    if (mapModal) mapModal.invalidateSize();
                }, 200);
            });
        }

        function reverseGeocode(lat, lng) {
            // Gunakan API Photon (Komoot) - Gratis & Cepat
            const url = `https://photon.komoot.io/reverse?lon=${lng}&lat=${lat}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data && data.features && data.features.length > 0) {
                        const props = data.features[0].properties;

                        // Susun Alamat dari data Photon
                        // Format: Nama, Jalan, Kota, Provinsi, Negara, Kode Pos
                        let addressParts = [
                            props.name,
                            props.street,
                            props.housenumber,
                            props.city,
                            props.state,
                            props.postcode,
                            props.country
                        ];

                        // Hapus yang kosong/undefined dan gabungkan
                        const formattedAddress = addressParts.filter(Boolean).join(', ');

                        // Isi Textarea
                        if (inputAddressMain) {
                            inputAddressMain.value = formattedAddress;
                        }

                        // Isi Kode Pos
                        if (props.postcode && inputPostcodeMain) {
                            inputPostcodeMain.value = props.postcode;
                        }
                    }
                })
                .catch(err => console.error("Gagal ambil alamat:", err));
        }

        // --- FUNGSI BARU: Pencarian Alamat pakai PHOTON ---
        let typingTimerMain;
        if (inputAddressMain) {
            inputAddressMain.addEventListener('input', function() {
                if (this.disabled) return;

                clearTimeout(typingTimerMain);
                const query = this.value;

                // Tunggu user selesai ngetik 1 detik
                if (query.length > 4) {
                    typingTimerMain = setTimeout(() => {
                        console.log("Mencari di Photon:", query);

                        // Cari lokasi via Photon
                        fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=1`)
                            .then(res => res.json())
                            .then(data => {
                                if (data && data.features && data.features.length > 0) {
                                    const coords = data.features[0].geometry.coordinates;
                                    const lat = coords[1]; // Photon urutannya [lon, lat]
                                    const lon = coords[0];

                                    // Pindahkan Peta & Marker
                                    mainMap.setView([lat, lon], 16);
                                    mainMarker.setLatLng([lat, lon]);

                                    // Update hidden input
                                    inputLatMain.value = lat;
                                    inputLngMain.value = lon;

                                    // Update kode pos jika ada
                                    if (data.features[0].properties.postcode && inputPostcodeMain) {
                                        inputPostcodeMain.value = data.features[0].properties.postcode;
                                    }
                                }
                            })
                            .catch(err => console.error("Gagal cari lokasi:", err));
                    }, 1000);
                }
            });
        }

        /* FIX MODAL KELOLA + TAMBAH ALAMAT */
        document.addEventListener('DOMContentLoaded', function() {
            const manageEl = document.getElementById('manageAddressModal');
            const addEl = document.getElementById('addProfileAddressModal');

            const manageModal = new bootstrap.Modal(manageEl, {
                backdrop: 'static',
                keyboard: false
            });

            const addModal = new bootstrap.Modal(addEl, {
                backdrop: 'static',
                keyboard: false
            });

            function hardResetModalState() {
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');

                document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
            }

            // === K E L O L A  →  T A M B A H ===
            document.getElementById('btnOpenAddAddress')?.addEventListener('click', () => {
                manageModal.hide();

                manageEl.addEventListener('hidden.bs.modal', function handler() {
                    hardResetModalState();
                    addModal.show();
                    manageEl.removeEventListener('hidden.bs.modal', handler);
                });
            });

            // === T A M B A H  →  K E L O L A ===
            document.getElementById('btnBackToManage')?.addEventListener('click', () => {
                addModal.hide();

                addEl.addEventListener('hidden.bs.modal', function handler() {
                    hardResetModalState();
                    manageModal.show();
                    addEl.removeEventListener('hidden.bs.modal', handler);
                });
            });

            // === SAFETY NET (WAJIB) ===
            [manageEl, addEl].forEach(modal => {
                modal.addEventListener('hidden.bs.modal', () => {
                    hardResetModalState();
                });
            });
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
