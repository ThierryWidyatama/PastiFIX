@extends('layouts.services')

@section('title', 'Checkout')

@section('content')
    <header class="services-header">
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
                            <input type="radio" name="address_id" id="address{{ $address->id }}" 
                                   class="address-radio" value="{{ $address->id }}" 
                                   {{-- Logic Checked: Prioritas Alamat Baru (Session), lalu Utama --}}
                                   {{ (session('new_address_id') == $address->id) ? 'checked' : ($address->is_primary && !session('new_address_id') ? 'checked' : '') }}>
                            
                            <label for="address{{ $address->id }}" class="address-card">
                                <div class="address-card-body">
                                    <div class="fw-bold">
                                        {{ $address->address_line }}
                                        @if($address->is_primary)
                                            <span class="badge bg-warning-subtle text-warning-emphasis fw-medium ms-2">UTAMA</span>
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
                                <div class="address-card-actions d-flex align-items-center gap-2" onclick="event.preventDefault()">
                                    
                                    <!-- TOMBOL EDIT -->
                                    <!-- [PENTING] Pastikan data-saved ada -->
                                    <button type="button" class="btn btn-icon btn-sm btn-light-primary btn-edit-address" 
                                            data-id="{{ $address->id }}"
                                            data-line="{{ $address->address_line }}"
                                            data-rt="{{ $address->rt_rw }}"
                                            data-pos="{{ $address->postal_code }}"
                                            data-patokan="{{ $address->landmark_details }}"
                                            data-primary="{{ $address->is_primary ? '1' : '0' }}" 
                                            data-saved="{{ $address->is_saved ? '1' : '0' }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editAddressModal">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- TOMBOL DELETE -->
                                    @if(!$address->is_primary) 
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
                        <br><br><br><br>
                        <a href="#" class="btn btn-icon-add" data-bs-toggle="modal" data-bs-target="#newAddressModal"><i class="bi bi-plus"></i></a>
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
        @if(!$address->is_primary)
            <form id="delete-form-{{ $address->id }}" action="{{ route('address.destroy', $address->id) }}" method="POST" style="display: none;">
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
                    <input type="hidden" name="redirect_to" value="{{ route('services.checkout', ['service_id' => $service->id]) }}">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambahkan Alamat Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Alamat Lengkap</label><textarea class="form-control" name="address_line" rows="3" required></textarea></div>
                        <div class="row mb-3">
                            <div class="col-6"><label class="form-label">RT/RW</label><input type="text" class="form-control" name="rt_rw"></div>
                            <div class="col-6"><label class="form-label">Kode Pos</label><input type="text" class="form-control" name="postal_code"></div>
                        </div>
                        <div class="mb-3"><label class="form-label">Detail Patokan</label><input type="text" class="form-control" name="landmark_details"></div>
                        
                        <hr class="my-3">
                        <!-- Checkbox Simpan -->
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_saved" value="1" id="new_is_saved" checked>
                            <label class="form-check-label fw-bold" for="new_is_saved">Simpan ke Daftar Alamat</label>
                            <div class="form-text small">Jika tidak dicentang, alamat hanya digunakan sekali ini saja.</div>
                        </div>
                        <!-- Checkbox Utama -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="new_is_primary">
                            <label class="form-check-label" for="new_is_primary">Jadikan Alamat Utama</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-brand">Simpan</button>
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
                        <div class="mb-3"><label class="form-label">Alamat Lengkap</label><textarea class="form-control" id="edit_address_line" name="address_line" rows="3" required></textarea></div>
                        <div class="row mb-3">
                            <div class="col-6"><label class="form-label">RT/RW</label><input type="text" class="form-control" id="edit_rt_rw" name="rt_rw"></div>
                            <div class="col-6"><label class="form-label">Kode Pos</label><input type="text" class="form-control" id="edit_postal_code" name="postal_code"></div>
                        </div>
                        <div class="mb-3"><label class="form-label">Detail Patokan</label><input type="text" class="form-control" id="edit_landmark_details" name="landmark_details"></div>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="edit_is_primary">
                            <label class="form-check-label" for="edit_is_primary">Jadikan Alamat Utama</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-brand">Update Alamat</button>
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
                        Anda sudah memiliki pesanan aktif untuk kategori <strong>{{ $service->name }}</strong> di alamat yang dipilih.
                    </p>
                    <p class="text-muted small">
                        Apakah Anda yakin ingin membuat pesanan baru lagi di lokasi yang sama?
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <!-- [PENTING] ID tombol konfirmasi -->
                    <button type="button" class="btn btn-warning px-4 fw-bold" id="btnConfirmDoubleOrder">Ya, Pesan Lagi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        // Fungsi Hapus (Global)
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus alamat ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log("Javascript Checkout Siap 86!");

            // ==========================================
            // BAGIAN 1: LOGIC EDIT ALAMAT
            // ==========================================
            const editButtons = document.querySelectorAll('.btn-edit-address');
            const editForm = document.getElementById('editAddressForm');
            
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const { id, line, rt, pos, patokan, primary, saved } = this.dataset;

                    if(document.getElementById('edit_address_line')) document.getElementById('edit_address_line').value = line;
                    if(document.getElementById('edit_rt_rw')) document.getElementById('edit_rt_rw').value = rt;
                    if(document.getElementById('edit_postal_code')) document.getElementById('edit_postal_code').value = pos;
                    if(document.getElementById('edit_landmark_details')) document.getElementById('edit_landmark_details').value = patokan;

                    const checkPrimary = document.getElementById('edit_is_primary');
                    const containerPrimary = checkPrimary ? checkPrimary.closest('.form-check') : null;

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

                    if (editAddressForm) {
                        editAddressForm.action = `/profil/address/${id}`;
                    }
                });
            });

            // ==========================================
            // BAGIAN 2: LOGIC TAMBAH ALAMAT
            // ==========================================
            const saveCheck = document.getElementById('new_is_saved');
            const primaryCheck = document.getElementById('new_is_primary');

            if(saveCheck && primaryCheck) {
                saveCheck.addEventListener('change', function() {
                    if(this.checked) {
                        primaryCheck.disabled = false;
                    } else {
                        primaryCheck.checked = false;
                        primaryCheck.disabled = true;
                    }
                });
            }

            // ==========================================
            // BAGIAN 3: CEK DOUBLE ORDER (INTERSEPSI SUBMIT)
            // ==========================================
            const busyAddressIds = @json($busyAddressIds); // Data dari Controller
            const checkoutForm = document.getElementById('checkoutForm');
            const btnSubmit = document.getElementById('btnSubmitCheckout');
            const btnConfirm = document.getElementById('btnConfirmDoubleOrder');
            
            const doubleOrderModalEl = document.getElementById('doubleOrderModal');
            const doubleOrderModal = new bootstrap.Modal(doubleOrderModalEl);

            if(btnSubmit) {
                btnSubmit.addEventListener('click', function(e) {
                    const selectedRadio = document.querySelector('input[name="address_id"]:checked');
                    
                    if (!selectedRadio) {
                        alert("Silakan pilih alamat terlebih dahulu.");
                        return;
                    }

                    const selectedAddressId = selectedRadio.value;

                    // Cek apakah alamat ini sedang sibuk
                    if (busyAddressIds.includes(selectedAddressId)) {
                        doubleOrderModal.show(); // Tampilkan Peringatan
                    } else {
                        checkoutForm.submit(); // Aman, kirim
                    }
                });
            }

            if(btnConfirm) {
                btnConfirm.addEventListener('click', function() {
                    checkoutForm.submit(); // Paksa kirim meski double
                });
            }
        });
    </script>
@endsection