@extends('admin.template.layout')

@section('content')

@if (session('success'))
    <div class="alert alert-success mb-5" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="row g-5 g-xl-8">
    <div class="col-xl-8">
        <div class="card mb-5 mb-xl-8">
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3">Detail Pesanan #{{ substr($order->id, 0, 8) }}</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <tbody>
                            <tr>
                                <td class="fw-bold text-gray-600 w-200px">Pemesan</td>
                                <td class="fw-bold text-dark">{{ $order->user->name }} ({{ $order->user->phone_number }})</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-600">Layanan</td>
                                <td><span class="badge badge-primary">{{ $order->category->name }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-600">Alamat Proyek</td>
                                <td class="text-gray-800">
                                    {{ $order->projectAddress->address_line }} <br>
                                    RT/RW: {{ $order->projectAddress->rt_rw }}, Kode Pos: {{ $order->projectAddress->postal_code }} <br>
                                    <span class="text-muted fs-7">Patokan: {{ $order->projectAddress->landmark_details }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-600">Harga Dasar Kategori</td>
                                <td class="text-gray-800">
                                    <span class="badge badge-light-success fs-7">
                                        {{ $order->category->price ? 'Rp ' . number_format($order->category->price, 0, ',', '.') : 'Via Survei' }}
                                    </span>
                                    <span class="text-muted fs-8 ms-2">(Harga default layanan)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-600">Total Tagihan Saat Ini</td>
                                <td class="text-gray-800 fw-bold">Rp {{ number_format($order->estimated_cost, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-gray-600">Tanggal Pesan</td>
                                <td class="text-gray-800">{{ $order->created_at->translatedFormat('l, d F Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-5 mb-xl-8">
            <div class="card-header">
                <h3 class="card-title fw-bold fs-3">Rincian Biaya (Update Mandor)</h3>
            </div>
            <div class="card-body py-3">
                <table class="table table-row-dashed align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="ps-4 rounded-start">Item</th>
                            <th>Harga</th>
                            <th class="rounded-end text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->costItems as $item)
                        <tr>
                            <td class="ps-4">{{ $item->item_name }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.orders.cost.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-sm btn-light-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted">Belum ada rincian biaya.</td></tr>
                        @endforelse
                        <tr class="fw-bold fs-5 bg-light-warning">
                            <td class="ps-4">TOTAL FINAL</td>
                            <td colspan="2">Rp {{ number_format($order->estimated_cost, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="separator my-5"></div>
                <form action="{{ route('admin.orders.cost.store', $order->id) }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <input type="text" name="item_name" class="form-control" placeholder="Nama Item (Misal: Semen 1 Sak)" required>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="price" class="form-control" placeholder="Harga (Rp)" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100 h-100">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-5 mb-xl-8">
            <div class="card-header">
                <h3 class="card-title fw-bold fs-3">Update Timeline Pengerjaan</h3>
            </div>
            <div class="card-body py-3">
                <div class="timeline-label">
                    @forelse($order->workTimelines()->orderBy('work_date')->get() as $timeline)
                    <div class="timeline-item">
                        <div class="timeline-label fw-bold text-gray-800 fs-6 w-100px">
                            {{ \Carbon\Carbon::parse($timeline->work_date)->format('d M Y') }}
                        </div>
                        <div class="timeline-badge">
                            <i class="fa fa-genderless text-primary fs-1"></i>
                        </div>
                        <div class="timeline-content d-flex flex-row-fluid align-items-center ps-3">
                            <span class="text-gray-800 fw-bold fs-6 flex-grow-1">{{ $timeline->description }}</span>
                            <form action="{{ route('admin.orders.timeline.destroy', $timeline->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-icon btn-sm btn-active-light-danger"><i class="bi bi-x"></i></button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted">Belum ada timeline.</div>
                    @endforelse
                </div>

                <div class="separator my-5"></div>
                <form action="{{ route('admin.orders.timeline.store', $order->id) }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                        <input type="date" name="work_date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="description" class="form-control" placeholder="Keterangan (Misal: Survei Lokasi)" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100 h-100">Add</button>
                    </div>
                </form>
            </div>
        </div>

    <div class="col-xl-4">
        <div class="card card-flush">
            <div class="card-header">
                <div class="card-title">
                    <h2>Kontrol Admin</h2>
                </div>
            </div>
            <div class="card-body pt-0">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-10">
                        <label for="mandor_id" class="form-label fw-bold">Tugaskan Mandor</label>
                        <select name="mandor_id" id="mandor_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Mandor">
                            <option></option>
                            @foreach($mandors as $mandor)
                                <option value="{{ $mandor->id }}" {{ $order->mandor_id == $mandor->id ? 'selected' : '' }}>
                                    {{ $mandor->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="text-muted fs-7 mt-2">Pilih mandor yang akan melakukan survei/pengerjaan.</div>
                    </div>

                    <div class="mb-10">
                        <label for="status" class="form-label fw-bold">Status Pesanan</label>
                        <select name="status" id="status" class="form-select form-select-solid">
                            <option value="PENDING_ADMIN_REVIEW" {{ $order->status == 'PENDING_ADMIN_REVIEW' ? 'selected' : '' }}>Pending Admin Review</option>
                            <option value="PENDING_MANDOR_QUOTE" {{ $order->status == 'PENDING_MANDOR_QUOTE' ? 'selected' : '' }}>Teruskan ke Mandor (Survei)</option>
                            <option value="APPROVED_IN_PROGRESS" {{ $order->status == 'APPROVED_IN_PROGRESS' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                            <option value="COMPLETED_PENDING_PAYMENT" {{ $order->status == 'COMPLETED_PENDING_PAYMENT' ? 'selected' : '' }}>Selesai (Tunggu Bayar)</option>
                            <option value="FINISHED" {{ $order->status == 'FINISHED' ? 'selected' : '' }}>Selesai (Lunas)</option>
                            <option value="REJECTED_BY_ADMIN" {{ $order->status == 'REJECTED_BY_ADMIN' ? 'selected' : '' }}>Tolak (Oleh Admin)</option>
                            <option value="CANCELLED" {{ $order->status == 'CANCELLED' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection