@extends('admin.template.layout')

@section('content')
<div class="card card-flush">
    <div class="card-header mt-6">
        <div class="card-title">
            <h2>Daftar Pesanan Masuk</h2>
        </div>
        <!-- [BARU] TOOLBAR FILTER & SEARCH -->
        <div class="card-toolbar">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex align-items-center gap-2 my-1">
                
                <!-- INPUT SEARCH -->
                <div class="position-relative w-250px me-2">
                    <span class="svg-icon svg-icon-3 position-absolute top-50 translate-middle-y ms-4">
                        <i class="bi bi-search text-gray-500"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control form-control-solid ps-12" 
                           placeholder="Cari Order ID / Nama..." />
                </div>
                <!-- TOMBOL SUBMIT (Optional, buat Search) -->
                <button type="submit" class="btn btn-primary btn-icon">
                    <i class="bi bi-arrow-right"></i>
                </button>

                <!-- DROPDOWN STATUS -->
                <div class="w-200px">
                    <select name="status" class="form-select form-select-solid" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="PENDING_ADMIN_REVIEW" {{ request('status') == 'PENDING_ADMIN_REVIEW' ? 'selected' : '' }}>Pending Review</option>
                        <option value="PENDING_MANDOR_QUOTE" {{ request('status') == 'PENDING_MANDOR_QUOTE' ? 'selected' : '' }}>Survei Mandor</option>
                        <option value="APPROVED_IN_PROGRESS" {{ request('status') == 'APPROVED_IN_PROGRESS' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                        <option value="COMPLETED_PENDING_PAYMENT" {{ request('status') == 'COMPLETED_PENDING_PAYMENT' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="FINISHED" {{ request('status') == 'FINISHED' ? 'selected' : '' }}>Selesai (Lunas)</option>
                        <option value="ALL_CANCELLED" {{ request('status') == 'ALL_CANCELLED' ? 'selected' : '' }} class="fw-bold text-danger">Semua Dibatalkan</option>
                    </select>
                </div>
                
                <!-- TOMBOL RESET -->
                @if(request('status') || request('search'))
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-light btn-icon" title="Reset Filter">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>
        </div>
        <!-- END TOOLBAR -->
    </div>
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_orders_table">
            <thead>
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Layanan</th>
                    <th>Mandor</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @forelse ($orders as $order)
                <tr>
                    <td>#{{ substr($order->id, 0, 8) }}</td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="text-gray-800 fw-bold">{{ $order->user->name }}</span>
                            <span class="text-muted fs-7">{{ $order->user->email }}</span>
                        </div>
                    </td>
                    <td><span class="badge badge-light-primary">{{ $order->category->name }}</span></td>
                    <td>
                        @if($order->mandor)
                            <span class="badge badge-light-success">{{ $order->mandor->name }}</span>
                        @else
                            <span class="badge badge-light-warning">Belum ada</span>
                        @endif
                    </td>
                    <td>
                        {{-- Logic warna badge sederhana --}}
                        @php
                            $statusClass = 'badge-light-info';
                            if($order->status == 'FINISHED') $statusClass = 'badge-light-success';
                            if(str_contains($order->status, 'REJECTED') || $order->status == 'CANCELLED') $statusClass = 'badge-light-danger';
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $order->status }}</span>
                    </td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-light btn-active-light-primary">
                            Detail & Atur
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada pesanan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection