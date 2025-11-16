@extends('admin.template.layout')

@section('content')
<div class="card card-flush">
    <div class="card-header mt-6">
        <div class="card-title">
            <h2>Daftar Pesanan Masuk</h2>
        </div>
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