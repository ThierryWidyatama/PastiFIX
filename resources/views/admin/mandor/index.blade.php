@extends('admin.template.layout')

@section('content')
<div class="card card-flush">
    <div class="card-header mt-6">
        <div class="card-title">
            <h2>Daftar Mitra Mandor</h2>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('mandor.create') }}" class="btn btn-primary">
                <i class="ki-duotone ki-plus fs-2"></i> Tambah Mandor
            </a>
        </div>
    </div>
    <div class="card-body pt-0">
        @if (session('success'))
            <div class="alert alert-success mb-5">{{ session('success') }}</div>
        @endif

        <table class="table align-middle table-row-dashed fs-6 gy-5">
            <thead>
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Username</th>
                    <th>Bergabung</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                @forelse ($mandors as $mandor)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                <div class="symbol-label fs-3 bg-light-primary text-primary">
                                    {{ substr($mandor->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 fw-bold mb-1">{{ $mandor->name }}</span>
                                <span class="text-muted fs-7">Mitra Terverifikasi</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <div><i class="bi bi-envelope me-2"></i>{{ $mandor->email }}</div>
                            <div><i class="bi bi-telephone me-2"></i>{{ $mandor->phone_number }}</div>
                        </div>
                    </td>
                    <td><span class="badge badge-light">{{ $mandor->username }}</span></td>
                    <td>{{ $mandor->created_at->format('d M Y') }}</td>
                    <td class="text-end">
                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data mandor.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection