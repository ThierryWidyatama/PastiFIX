@extends('admin.template.layout')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
    <!--begin::Tables Widget 13-->
    <div class="card mb-5 mb-xl-8">

        <form action="" method="POST" id="myForm">
            <div class="card-body ps-10 mt-1">
                @csrf
                @method('PUT')
                <div class="col-xxl-12">
                    <div class="row g-8">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <div class="form-group row">
                                    <label class="form-label">Nama Website</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" id="name-form" class="form-control"
                                            aria-describedby="name"
                                            value="{{ $option->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea name="address" class="form-control" id="address-form" cols="30" rows="">{{ $option->address }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <div class="form-group row">
                                    <label class="form-label">Nomor HP</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="phone" id="phone-form" class="form-control"
                                            value="{{ $option->phone }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Deskripsi Website</label>
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control" id="description-form" cols="30" rows="">{{ $option->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <div class="form-group row">
                                    <label class="form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" id="email-form" class="form-control"
                                            value="{{ $option->email }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <div class="form-group row">
                                    <label class="form-label">Start and End Hour</label>
                                    <div class="col-sm-5">
                                        <input class="form-control time_picker" name="start_time" value="{{ $option->starthour }}" placeholder="Pick a start time" id=""/>
                                    </div>
                                    <div class="col-sm-5">
                                        <input class="form-control time_picker" name="end_time" value="{{ $option->endhour }}" placeholder="Pick an end time" id=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Logo</label>
                                <label class="text-danger fs-7">Ukuran 269x69px untuk hasil optimal (ext jpeg,png,jpg,gif,svg,webp)</label>
                                <div class="col-sm-10">
                                    @if (!empty($option->logo))
                                        @php
                                            $url_logo = asset($option->logo);
                                        @endphp
                                        <div class="mb-5 mt-2">
                                            <!--begin::Overlay-->
                                            <a class="d-block overlay" data-fslightbox="lightbox-basic"
                                                href="{{ asset($option->logo) }}">
                                                <!--begin::Image-->
                                                <div class="text-center px-4 bg-secondary rounded">
                                                    <img alt="" class="w-100"
                                                        src="{{ asset($option->logo) }}">
                                                </div>
                                                <!--end::Image-->
                                                <!--begin::Action-->
                                                <div
                                                    class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                                    <i class="bi bi-eye-fill text-white fs-3x"></i>
                                                </div>
                                                <!--end::Action-->
                                            </a>
                                            <!--end::Overlay-->
                                        </div>
                                    @else
                                        @php
                                            $url_logo = null;
                                        @endphp
                                        <div class="mb-5 mt-2 text-danger">
                                            Tidak ada file tersedia
                                        </div>
                                    @endif
                                    <input type="file" name="logo" id="logo-form"
                                        class="form-control" data-default-file="{{ $url_logo }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Logo Dark</label>
                                <label class="text-danger fs-7">Ukuran 269x69px untuk hasil optimal (ext jpeg,png,jpg,gif,svg,webp)</label>
                                <div class="col-sm-10">
                                    @if (!empty($option->logo_dark))
                                        @php
                                            $url_logo_dark = asset($option->logo_dark);
                                        @endphp
                                        <div class="mb-5 mt-2">
                                            <!--begin::Overlay-->
                                            <a class="d-block overlay" data-fslightbox="lightbox-basic"
                                                href="{{ asset($option->logo_dark) }}">
                                                <!--begin::Image-->
                                                <div class="text-center px-4 bg-secondary rounded">
                                                    <img alt="" class="w-100"
                                                        src="{{ asset($option->logo_dark) }}">
                                                </div>
                                                <!--end::Image-->
                                                <!--begin::Action-->
                                                <div
                                                    class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                                    <i class="bi bi-eye-fill text-white fs-3x"></i>
                                                </div>
                                                <!--end::Action-->
                                            </a>
                                            <!--end::Overlay-->
                                        </div>
                                    @else
                                        @php
                                            $url_logo_dark = null;
                                        @endphp
                                        <div class="mb-5 mt-2 text-danger">
                                            Tidak ada file tersedia
                                        </div>
                                    @endif
                                    <input type="file" name="logo_dark" id="logo_dark-form"
                                        class="form-control" data-default-file="{{ $url_logo_dark }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Favicon</label>
                                <div class="col-sm-10">
                                    @if (!empty($option->favicon))
                                        @php
                                            $url_favicon = asset($option->favicon);
                                        @endphp
                                        <div class="mb-5 mt-2">
                                            <!--begin::Overlay-->
                                            <a class="d-block overlay" data-fslightbox="lightbox-basic"
                                                href="{{ asset($option->favicon) }}">
                                                <!--begin::Image-->
                                                <div class="text-center px-4 bg-secondary rounded">
                                                    <img alt="" class="w-100"
                                                        src="{{ asset($option->favicon) }}">
                                                </div>
                                                <!--end::Image-->
                                                <!--begin::Action-->
                                                <div
                                                    class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                                    <i class="bi bi-eye-fill text-white fs-3x"></i>
                                                </div>
                                                <!--end::Action-->
                                            </a>
                                            <!--end::Overlay-->
                                        </div>
                                    @else
                                        @php
                                            $url_favicon = null;
                                        @endphp
                                        <div class="mb-5 mt-2 text-danger">
                                            Tidak ada file tersedia
                                        </div>
                                    @endif
                                    <input type="file" name="favicon" id="favicon-form"
                                        class="form-control" data-default-file="{{ $url_favicon }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Landing Page</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                        <input class="form-check-input " type="checkbox" value="1" @if ($option->is_landing_page == 1)
                                        checked
                                        @endif name="is_landing_page" id="kt_flexSwitchCustomDefault_1_1"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col d-flex flex-column">
                <div class="card-footer">
                    <button type="button" id="btn-submit" class="btn btn-primary btn-submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        function resetErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        }

        function setErrors(errors) {

            resetErrors();
            $.each(errors, function(index, value) {
                $("#" + index + "-form").addClass('is-invalid');
                $("#" + index + "-form").after(`<div class="invalid-feedback">` + value + `</div>`);
            });
        }

        $(document).ready(function() {
            $(".time_picker").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
            });
            $('.btn-submit').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data?',
                    text: "Data akan tersimpan ke dalam database",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan data',
                            text: 'Silahkan tunggu...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                        });
                        Swal.showLoading();
                        var formData = new FormData($('#myForm')[0]);
                        formData.append('_token', '{{ csrf_token() }}');

                        $.ajax({
                            url: '{{ route('option.update', $option->id) }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                Swal.close();
                                console.log(response);

                                if (response.status == 'error') {
                                    setErrors(response.pesan);
                                    return;
                                }

                                Swal.fire({
                                    title: "Success!",
                                    text: "Berhasil Menyimpan Data",
                                    icon: "success"
                                }).then(function() {
                                    window.location =
                                        '{{ route('option.index') }}';
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Gagal Menyimpan Data",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });


        });
    </script>
@endsection
