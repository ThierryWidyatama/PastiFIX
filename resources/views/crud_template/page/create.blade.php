@php
    $subtitle .= ' / Tambah';
@endphp
@extends(config('template.layout'))

@section('content')
    <!--begin::Tables Widget 13-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->

        <form action="" id="myForm" enctype="multipart/form-data">
            <div class="card-body ps-10 mt-1">
                <div class="col-xxl-12">
                    <div class="row g-8">
                        @foreach ($fields as $field_name => $field)
                            <div class="col-lg-6">
                                <x-init :name="$field_name" :field="$field" value="" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col d-flex flex-column">
                <div class="card-footer">
                    <button type="reset" class="btn btn-danger">Batal</button>
                    <button type="button" id="btn-submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
        
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
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
                    url: "{{ $url['store'] }}",
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    beforeSubmit: function(formData, jqForm, options) {
                        Swal.fire({
                            title: 'Loading...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            showConfirmButton: false,
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            }
                        });
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
