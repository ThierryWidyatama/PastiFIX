@php
    $subtitle .= ' / Edit';
@endphp
@extends(config('template.layout'))

@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Edit {{ $title }}</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a class="text-muted">{{ $subtitle }} </a>
                    </li>

                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted"></li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">

            <!--begin::Tables Widget 13-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->

                <div class="card-body ps-10 mt-1">
                    <form action="" id="myForm">
                        <div class="col-xxl-12">
                            <div class="row g-8">
                                @foreach ($fields as $field_name => $field)
                                    @if ($field['type'] == 'image')
                                        @if ($data->$field_name != null && file_exists(public_path($data->$field_name)))
                                            <div class="col-lg-6">
                                                <img src="{!! asset($data->$field_name) !!}" alt="{{ $field_name }}"
                                                    style="max-width: 200px; height: auto;">
                                                <x-init :name="$field_name" :field="$field" :value="$data->$field_name ?? null" />
                                            </div>
                                        @else
                                            <div class="col-lg-6">
                                                <x-init :name="$field_name" :field="$field" :value="$data->$field_name ?? null" />
                                            </div>
                                        @endif
                                    @elseif ($field['type'] == 'file')
                                        @if ($data->$field_name != null && file_exists(public_path($data->$field_name)))
                                            <div class="col-lg-6">
                                                <x-init :name="$field_name" :field="$field" :value="$data->$field_name ?? null" />
                                                <a href="{!! asset($data->$field_name) !!}" target="_blank">
                                                    <i class="fas fa-download text-primary"></i> Unduh File
                                                </a>
                                            </div>
                                        @else
                                            <div class="col-lg-6">
                                                <x-init :name="$field_name" :field="$field" :value="$data->$field_name ?? null" />
                                                <a class="text-danger">File tidak tersedia</a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-lg-6">
                                            <x-init :name="$field_name" :field="$field" :value="$data->$field_name ?? null" />
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col d-flex flex-column">
                    <div class="card-footer">
                        <button type="button" id="btn-submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>  
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {!! $custom_script ?? '' !!}
    


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
            {!! $js_code ?? '' !!}

            $('#btn-submit').click(function() {
                $('#myForm').ajaxForm({
                    url: "{{ $url['update'] }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        '_method': 'PUT'
                    },
                    beforeSubmit: function(formData, jqForm, options) {
                        Swal.fire("Silahkan Tunggu ....");
                        Swal.showLoading();
                    },
                    // Callback function to be executed after the form is successfully submitted
                    success: function(responseText, status, xhr, $form) {
                        // You can use this function to handle the server's response
                        setTimeout(function() {
                            Swal.close();
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data berhasil disimpan',
                                icon: 'success'
                            }).then(function() {
                                document.location.href =
                                    "{{ $url['baseurl'] }}";
                            });
                        }, 2000);
                    },
                    // Callback function to be executed if the form submission fails
                    error: function(xhr) {
                        Swal.close();
                        setErrors(xhr.responseJSON.errors);
                    }
                }).submit();
            });
        });
    </script>
@endsection
