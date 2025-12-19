@extends('layouts.services')

@section('title', 'Checkout')

@section('content')
    <header class="services-hero">
        <div class="container" style="padding-top: 100px; padding-bottom: 50px;">
            <h1>Checkout</h1>
        </div>
    </header>
    <div class="container" style="padding-top: 50px; padding-bottom: 50px;">

        <!-- [PENTING] Tambahkan id="checkoutForm" -->
        <form action="{{ route('order.store') }}" method="POST" id="checkoutForm">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">

            <div class="row g-5">
                <div class="col-lg-7">
                    <h4 class="mb-4 fw-bold">Pilih Alamat Survei</h4>

                    @forelse ($addresses as $address)
                        <div class="address-card-wrapper mt-3">
                            <input type="radio" name="address_id" id="address{{ $address->id }}" class="address-radio"
                                value="{{ $address->id }}" {{-- Logic Checked: Prioritas Alamat Baru (Session), lalu Utama --}}
                                {{ session('new_address_id') == $address->id ? 'checked' : ($address->is_primary && !session('new_address_id') ? 'checked' : '') }}>

                            <label for="address{{ $address->id }}" class="address-card">
                                <div class="address-card-body">
                                    <div class="fw-bold">
                                        {{ $address->address_line }}
                                        @if ($address->is_primary)
                                            <span
                                                class="badge bg-danger-subtle text-danger-emphasis fw-medium ms-2">UTAMA</span>
                                        @endif
                                    </div>
                                    <div class="text-muted small my-2">
                                        RT/RW: {{ $address->rt_rw }}, Kode Pos: {{ $address->postal_code }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $address->landmark_details }}
                                    </div>
                                </div>

                                <!-- TOMBOL AKSI -->
                                <div class="address-card-actions d-flex align-items-center gap-2"
                                    onclick="event.preventDefault()">

                                    <!-- TOMBOL EDIT -->
                                    <!-- [PENTING] Pastikan data-saved ada -->
                                    <button type="button" class="btn btn-icon btn-sm btn-light-primary btn-edit-address"
                                        data-id="{{ $address->id }}" data-line="{{ $address->address_line }}"
                                        data-rt="{{ $address->rt_rw }}" data-pos="{{ $address->postal_code }}"
                                        data-patokan="{{ $address->landmark_details }}"
                                        data-primary="{{ $address->is_primary ? '1' : '0' }}"
                                        data-saved="{{ $address->is_saved ? '1' : '0' }}" {{-- [BARU] Kirim koordinat lama --}}
                                        data-lat="{{ $address->latitude }}" data-lng="{{ $address->longitude }}"
                                        data-bs-toggle="modal" data-bs-target="#editAddressModal">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- TOMBOL DELETE -->
                                    @if (!$address->is_primary)
                                        <button type="button" class="btn btn-icon btn-sm btn-light-danger"
                                            onclick="confirmDelete('{{ $address->id }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </label>
                        </div>
                    @empty
                        <div class="alert alert-info">Belum ada alamat.</div>
                    @endforelse

                    <div class="add-new-address-link text-center my-4">
                        <div class="divider-line"></div>
                        {{-- <br><br><br><br> --}}
                        <a href="#" class="btn btn-icon-add" data-bs-toggle="modal"
                            data-bs-target="#newAddressModal"><i class="bi bi-plus"></i></a>
                        <div class="mt-2 text-muted fw-medium">Tambah Alamat Baru</div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 checkout-summary-card">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-4">Ringkasan Pesanan</h5>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Biaya Awal</span>
                                <span class="fw-medium">Rp{{ number_format($prices['service'], 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Biaya Layanan</span>
                                <span class="fw-medium">Rp{{ number_format($prices['admin_fee'], 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Pajak</span>
                                <span class="fw-medium">Rp{{ number_format($prices['tax'], 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                                <span>Total (Estimasi)</span>
                                <span>Rp{{ number_format($prices['total'], 0, ',', '.') }}</span>
                            </div>

                            <!-- [PENTING] Tambahkan ID dan type="button" -->
                            <button type="button" id="btnSubmitCheckout" class="btn btn-brand btn-lg w-100 fw-bold">
                                Kirim Permintaan Survei
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- FORM DELETE TERSEMBUNYI -->
    @foreach ($addresses as $address)
        @if (!$address->is_primary)
            <form id="delete-form-{{ $address->id }}" action="{{ route('address.destroy', $address->id) }}"
                method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endif
    @endforeach

    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="newAddressModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('address.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="redirect_to"
                        value="{{ route('services.checkout', ['service_id' => $service->id]) }}">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambahkan Alamat Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- [BARU] AREA PETA -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Titik Lokasi</label>

                            <!-- Wrapper Baru -->
                            <div class="map-wrapper">
                                <!-- Overlay Loading -->
                                <div id="loading-map-new" class="map-loading">
                                    <div class="spinner-border mb-2" role="status"></div>
                                    <span>Mencari titik...</span>
                                </div>

                                <!-- Peta Asli -->
                                <div id="map-checkout" class="map-canvas"></div>
                            </div>

                            <div class="form-text small text-muted">
                                <i class="bi bi-geo-alt-fill text-danger"></i> Geser pin untuk isi alamat otomatis.
                            </div>
                            <input type="hidden" id="lat_new" name="latitude">
                            <input type="hidden" id="lng_new" name="longitude">
                        </div>

                        <!-- Form Alamat -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap <span id="status-text-new"
                                    class="text-warning small fst-italic ms-2" style="display:none;">(Memuat
                                    alamat...)</span></label>
                            <textarea class="form-control" name="address_line" id="address_input_new" rows="3" required
                                placeholder="Cari di peta atau ketik manual..."></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label">RT/RW</label>
                                <input type="text" class="form-control" name="rt_rw" placeholder="00/00">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" name="postal_code" id="postal_code_new"
                                    placeholder="Otomatis">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Detail Patokan</label>
                            <input type="text" class="form-control" name="landmark_details"
                                placeholder="Cth: Pagar hitam">
                        </div>

                        <hr class="my-3">

                        <!-- Checkbox Simpan & Utama (Logika Lama Tetap Ada) -->
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_saved" value="1"
                                id="new_is_saved" checked>
                            <label class="form-check-label fw-bold" for="new_is_saved">Simpan ke Daftar Alamat</label>
                            <div class="form-text small">Jika tidak dicentang, alamat hanya digunakan sekali ini saja.
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_primary" value="1"
                                id="new_is_primary">
                            <label class="form-check-label" for="new_is_primary">Jadikan Alamat Utama</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-pesan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" id="editAddressModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editAddressForm" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Alamat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- [BARU] AREA PETA EDIT -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Perbarui Titik Lokasi</label>

                            <div class="map-wrapper">
                                <!-- Overlay Loading -->
                                <div id="loading-map-edit" class="map-loading">
                                    <div class="spinner-border mb-2" role="status"></div>
                                    <span>Mencari titik...</span>
                                </div>

                                <div id="map-edit" class="map-canvas"></div>
                            </div>

                            <input type="hidden" id="lat_edit" name="latitude">
                            <input type="hidden" id="lng_edit" name="longitude">
                        </div>

                        <!-- Form Alamat (Tambahkan ID untuk Geocoding) -->
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap <span id="status-text-edit"
                                    class="text-warning small fst-italic ms-2" style="display:none;">(Memuat
                                    alamat...)</span></label>
                            <textarea class="form-control" id="edit_address_line" name="address_line" rows="3" required></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label">RT/RW</label>
                                <input type="text" class="form-control" id="edit_rt_rw" name="rt_rw">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Kode Pos</label>
                                <!-- Tambahkan ID -->
                                <input type="text" class="form-control" id="edit_postal_code" name="postal_code">
                            </div>
                        </div>
                        <div class="mb-3"><label class="form-label">Detail Patokan</label><input type="text"
                                class="form-control" id="edit_landmark_details" name="landmark_details"></div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_primary" value="1"
                                id="edit_is_primary">
                            <label class="form-check-label" for="edit_is_primary">Jadikan Alamat Utama</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-pesan">Update Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL WARNING DOUBLE ORDER -->
    <div class="modal fade" id="doubleOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-warning">
                        <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Konfirmasi Pesanan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pt-4">
                    <p class="mb-3">
                        Anda sudah memiliki pesanan aktif untuk kategori <strong>{{ $service->name }}</strong> di alamat
                        yang dipilih.
                    </p>
                    <p class="text-muted small">
                        Apakah Anda yakin ingin membuat pesanan baru lagi di lokasi yang sama?
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <!-- [PENTING] ID tombol konfirmasi -->
                    <button type="button" class="btn btn-success px-4 fw-bold" id="btnConfirmDoubleOrder">Ya, Pesan
                        Lagi</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- 1. JS Leaflet (Wajib untuk Peta) -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        <script>
            function confirmDelete(id) {
                if (confirm('Apakah Anda yakin ingin menghapus alamat ini?')) {
                    document.getElementById('delete-form-' + id).submit();
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                console.log("Javascript Checkout + Smart Maps Ready!");

                const DEFAULT_LAT = -6.9932; // Semarang
                const DEFAULT_LNG = 110.4203;

                // Fungsi Debounce (Rem Otomatis untuk API)
                function debounce(func, timeout = 1000) {
                    let timer;
                    return (...args) => {
                        clearTimeout(timer);
                        timer = setTimeout(() => {
                            func.apply(this, args);
                        }, timeout);
                    };
                }

                // ==========================================
                // FUNGSI UMUM: SETUP MAP EVENTS + LOADING
                // ==========================================
                function setupMapEvents(map, marker, latInputId, lngInputId, addrInputId, zipInputId, loadingMapId,
                    statusTextId) {
                    const latInput = document.getElementById(latInputId);
                    const lngInput = document.getElementById(lngInputId);
                    const addrInput = document.getElementById(addrInputId);
                    const zipInput = document.getElementById(zipInputId);
                    const loadingMap = document.getElementById(loadingMapId); // Overlay Loading Peta
                    const statusText = document.getElementById(statusTextId); // Teks Loading Alamat

                    // Helper: Nyalakan/Matikan Loading Input
                    function toggleInputLoading(isLoading) {
                        if (isLoading) {
                            addrInput.classList.add('input-loading');
                            addrInput.setAttribute('readonly', true); // Cegah ketik saat loading
                            if (statusText) statusText.style.display = 'inline';
                        } else {
                            addrInput.classList.remove('input-loading');
                            addrInput.removeAttribute('readonly');
                            if (statusText) statusText.style.display = 'none';
                        }
                    }

                    // Helper: Nyalakan/Matikan Loading Peta
                    function toggleMapLoading(isLoading) {
                        if (loadingMap) loadingMap.style.display = isLoading ? 'flex' : 'none';
                    }

                    function updateInputs(lat, lng) {
                        if (latInput) latInput.value = lat;
                        if (lngInput) lngInput.value = lng;
                    }

                    // A. Reverse Geocode (Pin -> Teks)
                    const doReverseGeocode = debounce((lat, lng) => {
                        // Fetch jalan -> Matikan loading input setelah selesai
                        fetch(`/geocode/reverse?lat=${lat}&lon=${lng}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data && data.display_name && addrInput) {
                                    addrInput.value = data.display_name;
                                }
                                if (data && data.address && data.address.postcode && zipInput) {
                                    zipInput.value = data.address.postcode;
                                    zipInput.style.backgroundColor = "#fff9db";
                                    setTimeout(() => zipInput.style.backgroundColor = "", 1500);
                                }
                            })
                            .catch(err => console.warn("Reverse Geo Error:", err))
                            .finally(() => {
                                toggleInputLoading(false); // [STOP LOADING]
                            });
                    }, 1000);

                    // B. Forward Geocode (Teks -> Pin)
                    const doForwardGeocode = debounce((query) => {
                        // Fetch jalan -> Matikan loading peta setelah selesai
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
                            .catch(err => console.warn("Forward Geo Error:", err))
                            .finally(() => {
                                toggleMapLoading(false); // [STOP LOADING]
                            });
                    }, 1500);

                    // --- EVENT LISTENERS ---

                    // 1. Marker Digeser
                    marker.on('dragstart', function() {
                        toggleInputLoading(true); // [START LOADING] Saat mulai geser
                    });

                    marker.on('dragend', function(e) {
                        const pos = marker.getLatLng();
                        updateInputs(pos.lat, pos.lng);
                        doReverseGeocode(pos.lat, pos.lng); // Debounce akan jalan, loading mati di finally
                    });

                    // 2. Peta Diklik
                    map.on('click', function(e) {
                        toggleInputLoading(true); // [START LOADING]
                        marker.setLatLng(e.latlng);
                        updateInputs(e.latlng.lat, e.latlng.lng);
                        doReverseGeocode(e.latlng.lat, e.latlng.lng);
                    });

                    // 3. Ketik Alamat
                    if (addrInput) {
                        addrInput.addEventListener('input', function() {
                            const query = this.value;
                            if (query.length > 5) {
                                toggleMapLoading(true); // [START LOADING] Saat ngetik
                                doForwardGeocode(query);
                            }
                        });
                    }
                }

                // ==========================================
                // BAGIAN 1: PETA MODAL TAMBAH (NEW)
                // ==========================================
                let mapNew = null;
                let markerNew = null;

                function initMapNew() {
                    if (!document.getElementById('map-checkout')) return;
                    if (mapNew !== null) return;

                    mapNew = L.map('map-checkout').setView([DEFAULT_LAT, DEFAULT_LNG], 15);

                    const tileLayer = L.tileLayer(
                        'https://tile.openstreetmap.de/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OSM'
                        }
                    );

                    tileLayer.addTo(mapNew);

                    markerNew = L.marker([DEFAULT_LAT, DEFAULT_LNG], {
                        draggable: true
                    }).addTo(mapNew);

                    setupMapEvents(
                        mapNew,
                        markerNew,
                        'lat_new',
                        'lng_new',
                        'address_input_new',
                        'postal_code_new',
                        'loading-map-new',
                        'status-text-new'
                    );

                    // SET INPUT DEFAULT
                    document.getElementById('lat_new').value = DEFAULT_LAT;
                    document.getElementById('lng_new').value = DEFAULT_LNG;

                    // 🔥 INI KUNCINYA: MATIKAN LOADING SAAT TILE SIAP
                    tileLayer.once('load', () => {
                        const loading = document.getElementById('loading-map-new');
                        if (loading) loading.style.display = 'none';

                        mapNew.invalidateSize(true);
                    });
                }

                const modalNew = document.getElementById('newAddressModal');
                if (modalNew) {
                    modalNew.addEventListener('shown.bs.modal', function() {
                        initMapNew();
                        setTimeout(() => {
                            if (mapNew) mapNew.invalidateSize();
                        }, 200);
                    });
                }

                // ==========================================
                // BAGIAN 2: PETA MODAL EDIT (EDIT)
                // ==========================================
                let mapEdit = null;
                let markerEdit = null;

                function initMapEdit(lat, lng, addressText) {
                    const mapEl = document.getElementById('map-edit');
                    if (!mapEl) return;

                    const loadingEl = document.getElementById('loading-map-edit');

                    const isValidCoord =
                        typeof lat === 'number' &&
                        typeof lng === 'number' &&
                        !isNaN(lat) &&
                        !isNaN(lng) &&
                        lat !== 0 &&
                        lng !== 0;

                    const startLat = isValidCoord ? lat : DEFAULT_LAT;
                    const startLng = isValidCoord ? lng : DEFAULT_LNG;

                    // Pastikan loading aktif saat init
                    if (loadingEl) loadingEl.style.display = 'flex';

                    // === INIT MAP SEKALI SAJA ===
                    if (mapEdit === null) {
                        mapEdit = L.map('map-edit', {
                            center: [startLat, startLng],
                            zoom: 15,
                            zoomControl: true
                        });

                        const tileLayer = L.tileLayer(
                            'https://tile.openstreetmap.de/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '© OpenStreetMap'
                            }
                        ).addTo(mapEdit);

                        markerEdit = L.marker([startLat, startLng], {
                            draggable: true
                        }).addTo(mapEdit);

                        setupMapEvents(
                            mapEdit,
                            markerEdit,
                            'lat_edit',
                            'lng_edit',
                            'edit_address_line',
                            'edit_postal_code',
                            'loading-map-edit',
                            'status-text-edit'
                        );

                        // 🔑 MATIKAN LOADING SAAT TILE BENAR-BENAR SIAP
                        tileLayer.once('load', () => {
                            if (loadingEl) loadingEl.style.display = 'none';
                            mapEdit.invalidateSize(true);
                        });

                    } else {
                        // === MAP SUDAH ADA ===
                        mapEdit.setView([startLat, startLng], 15);
                        markerEdit.setLatLng([startLat, startLng]);

                        setTimeout(() => {
                            mapEdit.invalidateSize(true);
                            if (loadingEl) loadingEl.style.display = 'none';
                        }, 200);
                    }

                    // === SET HIDDEN INPUT KOORDINAT ===
                    const latInput = document.getElementById('lat_edit');
                    const lngInput = document.getElementById('lng_edit');
                    if (latInput) latInput.value = startLat;
                    if (lngInput) lngInput.value = startLng;

                    // === AUTO FIX JIKA KOORDINAT KOSONG TAPI ADA ALAMAT ===
                    if (!isValidCoord && addressText && addressText.length > 5) {
                        fetch(`/geocode/search?q=${encodeURIComponent(addressText)}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data && data.length > 0) {
                                    const newLat = parseFloat(data[0].lat);
                                    const newLng = parseFloat(data[0].lon);

                                    if (!isNaN(newLat) && !isNaN(newLng)) {
                                        mapEdit.setView([newLat, newLng], 16);
                                        markerEdit.setLatLng([newLat, newLng]);

                                        if (latInput) latInput.value = newLat;
                                        if (lngInput) lngInput.value = newLng;
                                    }
                                }
                            })
                            .catch(err => console.warn('Auto geocode edit failed:', err))
                            .finally(() => {
                                if (loadingEl) loadingEl.style.display = 'none';
                            });
                    }
                }


                // ==========================================
                // LOGIC TOMBOL EDIT (UPDATE DATA KE MODAL)
                // ==========================================
                const editButtons = document.querySelectorAll('.btn-edit-address');
                const editForm = document.getElementById('editAddressForm');

                editButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const {
                            id,
                            line,
                            rt,
                            pos,
                            patokan,
                            primary,
                            saved,
                            lat,
                            lng
                        } = this.dataset;

                        // Isi Form Text
                        if (document.getElementById('edit_address_line')) document.getElementById(
                            'edit_address_line').value = line;
                        if (document.getElementById('edit_rt_rw')) document.getElementById('edit_rt_rw')
                            .value = rt;
                        if (document.getElementById('edit_postal_code')) document.getElementById(
                            'edit_postal_code').value = pos;
                        if (document.getElementById('edit_landmark_details')) document.getElementById(
                            'edit_landmark_details').value = patokan;

                        // Isi Hidden Input Koordinat (Fallback ke default jika null)
                        if (document.getElementById('lat_edit')) document.getElementById('lat_edit')
                            .value = lat || DEFAULT_LAT;
                        if (document.getElementById('lng_edit')) document.getElementById('lng_edit')
                            .value = lng || DEFAULT_LNG;

                        // Init Peta Edit dengan Koordinat Lama
                        // Timeout dikit biar modal render dulu
                        setTimeout(() => {
                            initMapEdit(parseFloat(lat), parseFloat(lng), line);
                        }, 300);

                        // Logic Checkbox Utama
                        const checkPrimary = document.getElementById('edit_is_primary');
                        const containerPrimary = checkPrimary ? checkPrimary.closest('.form-check') :
                            null;
                        if (checkPrimary) {
                            const isSavedAddress = saved === '1';
                            const isPrimaryAddress = primary === '1';

                            if (!isSavedAddress) {
                                checkPrimary.checked = false;
                                checkPrimary.disabled = true;
                                if (containerPrimary) containerPrimary.style.display = 'none';
                            } else {
                                if (containerPrimary) containerPrimary.style.display = 'block';
                                checkPrimary.checked = isPrimaryAddress;
                                checkPrimary.disabled = isPrimaryAddress;
                            }
                        }

                        if (editForm) editForm.action = `/profil/address/${id}`;
                    });
                });


                // ==========================================
                // LOGIC CHECKBOX TAMBAH
                // ==========================================
                const saveCheck = document.getElementById('new_is_saved');
                const primaryCheck = document.getElementById('new_is_primary');
                if (saveCheck && primaryCheck) {
                    saveCheck.addEventListener('change', function() {
                        if (this.checked) {
                            primaryCheck.disabled = false;
                        } else {
                            primaryCheck.checked = false;
                            primaryCheck.disabled = true;
                        }
                    });
                }

                // ==========================================
                // BAGIAN 4: CEK DOUBLE ORDER
                // ==========================================
                const busyAddressIds = @json($busyAddressIds ?? []);
                const checkoutForm = document.getElementById('checkoutForm');
                const btnSubmit = document.getElementById('btnSubmitCheckout');
                const btnConfirm = document.getElementById('btnConfirmDoubleOrder');

                const doubleOrderModalEl = document.getElementById('doubleOrderModal');
                let doubleOrderModal = null;
                if (doubleOrderModalEl) doubleOrderModal = new bootstrap.Modal(doubleOrderModalEl);

                if (btnSubmit) {
                    btnSubmit.addEventListener('click', function(e) {
                        const selectedRadio = document.querySelector('input[name="address_id"]:checked');
                        if (!selectedRadio) {
                            alert("Silakan pilih alamat terlebih dahulu.");
                            return;
                        }

                        const selectedAddressId = selectedRadio.value;

                        if (busyAddressIds.includes(selectedAddressId) && doubleOrderModal) {
                            doubleOrderModal.show();
                        } else {
                            // [CLEAN CODE] Cukup panggil ini, dia otomatis jadi spinner
                            setLoading(btnSubmit);
                            checkoutForm.submit();
                        }
                    });
                }

                if (btnConfirm) {
                    btnConfirm.addEventListener('click', function() {
                        // [CLEAN CODE] Ini juga sama
                        setLoading(btnConfirm);
                        checkoutForm.submit();
                    });
                }
            });
        </script>
    @endsection
