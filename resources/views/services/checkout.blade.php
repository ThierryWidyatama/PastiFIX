@extends('layouts.services') {{-- [FIX] Ganti ke layout 'landing' --}}

@section('title', 'Checkout')

@section('content')
    <header class="services-header">
        <div class="container" style="padding-top: 100px; padding-bottom: 50px;">
            <h1>Checkout</h1>
        </div>
    </header>
    <div class="container" style="padding-top: 50px; padding-bottom: 50px;">

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
                                   {{ $address->is_primary ? 'checked' : '' }}>
                            
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
                                
                                <div class="address-card-actions d-flex align-items-center gap-2" onclick="event.preventDefault()">
                                    
                                    <button type="button" class="btn btn-icon btn-sm btn-light-primary btn-edit-address" 
                                            data-id="{{ $address->id }}"
                                            data-line="{{ $address->address_line }}"
                                            data-rt="{{ $address->rt_rw }}"
                                            data-pos="{{ $address->postal_code }}"
                                            data-patokan="{{ $address->landmark_details }}"
                                            data-primary="{{ $address->is_primary ? '1' : '0' }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editAddressModal">
                                        <i class="bi bi-pencil"></i>
                                    </button>

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
                            <button type="submit" class="btn btn-brand btn-lg w-100 fw-bold">Kirim Permintaan Survei</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @foreach ($addresses as $address)
        @if(!$address->is_primary)
            <form id="delete-form-{{ $address->id }}" action="{{ route('address.destroy', $address->id) }}" method="POST" style="display: none;">
                @csrf 
                @method('DELETE')
            </form>
        @endif
    @endforeach

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
                        <div class="modal-body">
                            <div class="mb-3"><label class="form-label">Detail Patokan</label><input type="text" class="form-control" name="landmark_details"></div>
                            
                            <hr class="my-3">

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="is_saved" value="1" id="new_is_saved" checked>
                                <label class="form-check-label fw-bold" for="new_is_saved">
                                    Simpan ke Daftar Alamat
                                </label>
                                <div class="form-text small">Jika tidak dicentang, alamat hanya digunakan untuk pesanan ini saja (Sekali Pakai).</div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="new_is_primary">
                                <label class="form-check-label" for="new_is_primary">Jadikan Alamat Utama</label>
                            </div>
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

    <script>
        // Fungsi Hapus (Global) - Biarkan di luar
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
                    const id = this.getAttribute('data-id');
                    const line = this.getAttribute('data-line');
                    const rt = this.getAttribute('data-rt');
                    const pos = this.getAttribute('data-pos');
                    const patokan = this.getAttribute('data-patokan');
                    const isPrimary = this.getAttribute('data-primary');

                    // Isi Modal
                    if(document.getElementById('edit_address_line')) document.getElementById('edit_address_line').value = line;
                    if(document.getElementById('edit_rt_rw')) document.getElementById('edit_rt_rw').value = rt;
                    if(document.getElementById('edit_postal_code')) document.getElementById('edit_postal_code').value = pos;
                    if(document.getElementById('edit_landmark_details')) document.getElementById('edit_landmark_details').value = patokan;

                    // [FIX] Logika Checkbox Utama di Edit
                    const checkPrimary = document.getElementById('edit_is_primary');
                    if (checkPrimary) {
                        if (isPrimary === '1') {
                            checkPrimary.checked = true;
                            checkPrimary.disabled = true; // MATIKAN kalau sudah utama
                        } else {
                            checkPrimary.checked = false;
                            checkPrimary.disabled = false; // NYALAKAN kalau belum utama
                        }
                    }

                    // Update URL Action Form
                    const actionUrl = "/profil/address/" + id;
                    editForm.setAttribute('action', actionUrl);
                });
            });

            // ==========================================
            // BAGIAN 2: LOGIC TAMBAH ALAMAT (FIXED)
            // ==========================================
            // Kita taruh di dalam sini biar elemennya ketemu
            const saveCheck = document.getElementById('new_is_saved');
            const primaryCheck = document.getElementById('new_is_primary');

            // Cek dulu apakah elemennya ada (biar gak error di console)
            if(saveCheck && primaryCheck) {
                console.log("Logic Checkbox Tambah Aktif");
                
                saveCheck.addEventListener('change', function() {
                    if(this.checked) {
                        // Kalau disimpan -> Boleh jadi utama
                        primaryCheck.disabled = false;
                        // primaryCheck.parentElement.classList.remove('text-muted'); // Optional: styling
                    } else {
                        // Kalau sekali pakai -> GABOLEH jadi utama
                        primaryCheck.checked = false;
                        primaryCheck.disabled = true;
                        // primaryCheck.parentElement.classList.add('text-muted'); // Optional: styling
                    }
                });
            } else {
                console.error("ID new_is_saved atau new_is_primary tidak ditemukan!");
            }

        });
    </script>

@endsection