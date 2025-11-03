@extends('admin.template.layout')
@section('content')
    <!--begin::Tables Widget 13-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-body py-10">
            <div class="d-flex justify-content-between">
                <div class="d-flex gap-4 align-items-center mb-9">
                    <h2 class="m-0">
                        <img class="me-3 rounded" style="width: 64px" src="{{ asset($data->logo) }}" alt="">{{ $data->name }}
                    </h2>
                    <div>
                        @if ($data->status == 1)
                            <span class="badge badge-light-success fs-7">Aktif</span>
                        @else
                            <span class="badge badge-light-danger fs-7">Tidak Aktif</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-4">
                    <a href="{{ route('master-my-apps.edit', $data->id) }}" class="btn btn-light-warning btn-icon"><i class="ki-duotone ki-notepad-edit fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    </i></a>
                    <button type="button" class="btn btn-light-danger btn-delete btn-icon" data-id="{{ $data->id }}"><i class="ki-duotone ki-trash-square fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    </i></button>
                </div>
            </div>

            <!--begin::Overview-->
            <div class="row mb-10">
                <!--begin::Col-->
                <div class="col-xl-6 mb-15 mb-xl-0 pe-5">
                    <div class="mb-5">
                        <h4 class="mb-0">Deskripsi</h4>
                        <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">
                            {{ $data->description }}
                        </p>
                    </div>
                    @if ($data->link)
                    <div class="mb-5">
                        <h4 class="mb-0">Link login</h4>

                        <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">
                            Klik tombol di bawah ini untuk membuka aplikasi
                        </p>

                        <a href="{{ $data->link }}" target="_blank" class="btn btn-dark fw-bold"><i class="ki-duotone ki-send fs-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        </i>Link</a>
                    </div>
                    @else
                    <div class="mb-5">
                        <h4 class="mb-0">Link login</h4>

                        <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">
                            Tidak ada link login
                        </p>
                    </div>
                    @endif
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                @if ($data->username && $data->password)
                <div class="col-xl-6">
                    <h4 class="text-gray-800 mb-0">
                        Authentikasi
                    </h4>

                    <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">
                        Gunakan username dan password di bawah ini untuk mengakses aplikasi. Mohon untuk digunakan dengan bijak :)
                    </p>

                    <div class="d-flex mb-4">
                        <input id="kt_referral_link_input_username" type="text"
                            class="form-control form-control-solid me-3 flex-grow-1" name="search"
                            value="{{ $data->username }}">

                        <button class="btn btn-light btn-active-light-primary fw-bold flex-shrink-0"
                            data-target="#kt_referral_link_input_username">Copy</button>
                    </div>
                    <div class="d-flex mb-4">
                        <input id="kt_referral_link_input_password" type="text"
                            class="form-control form-control-solid me-3 flex-grow-1" name="search"
                            value="{{ $data->password }}">

                        <button class="btn btn-light btn-active-light-primary fw-bold flex-shrink-0"
                            data-target="#kt_referral_link_input_password">Copy</button>
                    </div>
                </div>
                @else
                <div class="col-xl-6">
                    <h4 class="text-gray-800 mb-0">
                        Authentikasi
                    </h4>

                    <p class="fs-6 fw-semibold text-gray-600 py-4 m-0">
                        Tidak ada username dan password
                    </p>
                </div>
                @endif
                <!--end::Col-->
            </div>
            <!--end::Overview-->
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.querySelectorAll('button[data-target]').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.querySelector(button.getAttribute('data-target'));
                if (target) {
                    target.select();
                    target.setSelectionRange(0, 99999); // For mobile devices
                    document.execCommand('copy');
                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: target.value + ' Berhasil Disalin',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
        $(document).ready(function() {

            $('.btn-delete').on('click', function(e) {
                e.preventDefault();

                var appId = $(this).data('id');
                var url = "{{ route('master-my-apps.destroy', ':id') }}".replace(':id', appId);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    buttonStyling : false,
                    showCancelButton: true,
                    confirmButtonText: 'Ya Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your app has been deleted.',
                                    'success'
                                ).then(() => {
                                    window.location.href = "{{ route('master-my-apps.index') }}"; // Back to the previous page
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the app.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
