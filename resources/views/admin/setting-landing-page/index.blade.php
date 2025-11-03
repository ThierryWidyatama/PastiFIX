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
                                    <label class="form-label">Nama Singkat Aplikasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" id="name-form" class="form-control"
                                            aria-describedby="name"
                                            value="{{ $data->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Nama Aplikasi</label>
                                <div class="col-sm-10">
                                    <textarea name="full_name" class="form-control" id="address-form" cols="30" rows="">{{ $data->full_name }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="form-group row">
                                <label class="form-label">About Landing Page</label>
                                <div class="col-sm-11">
                                    <textarea name="about" class="form-control" id="address-form" cols="30" rows="">{{ $data->about }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="form-group row">
                                <label class="form-label">Slider Landing Page <span class="text-danger">*Guanakan gambar dengan ukuran 1600 x 800 agar hasil optimal</span></label>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="fw-bold fs-6 text-gray-800">
                                                <th>Nama</th>
                                                <th>File / Gambar</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="append_section">
                                            @if (count($slider) > 0)
                                            @foreach ($slider->sortBy('order') as $item)
                                            <tr>
                                                <input type="hidden" name="slider_id[]" value="{{ $item->id }}">
                                                <td><input class="form-control" type="text" name="slider_name[]" value="{{ $item->name }}" id=""></td>
                                                <td><img style="width: 100%" class="mb-4" src="{{ asset($item->file_path) }}" alt=""><input class="form-control" type="file" name="slider_image[{{ $item->id }}]" id=""></td>
                                                <td><select class="form-control min-w-125px" name="slider_status[]" id="" data-control="select2">
                                                    <option @if ($item->status == 1)
                                                        selected
                                                    @endif value="1">Aktif</option>
                                                    <option @if ($item->status == 0)
                                                        selected
                                                    @endif value="0">Tidak aktif</option>
                                                </select></td>
                                                <td><a href="" class="btn btn-light-danger btn-sm btn-delete"><i class="fa fa-trash"></i></a></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <button class="btn btn-light-primary btn-sm" id="btn-add"><i class="fa fa-plus"></i> Tambah </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col d-flex flex-column">
                <div class="card-footer">
                    <button type="button" id="btn-submit" class="btn btn-success btn-submit">Simpan</button>
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
            $('#btn-add').on('click', function (e) {
                e.preventDefault();

                // Append a new row with empty fields.
                $('#append_section').append(`
                    <tr>
                        <td><input class="form-control" placeholder="Masukkan Nama Slider" type="text" name="new_slider_name[]" value="" id=""></td>
                        <td><input class="form-control" type="file" name="new_slider_image[]" id=""> <img src="" alt=""></td>
                        <td>
                            <select class="form-control" data-control="select2" name="new_slider_status[]" id="">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak aktif</option>
                            </select>
                        </td>
                        <td><a href="#" class="btn btn-light-danger btn-sm btn-delete"><i class="fa fa-trash"></i></a></td>
                    </tr>
                `);

                
            });

            // Use event delegation to handle click event on dynamically added elements
            $('#append_section').on('click', '.btn-delete', function (e) {
                e.preventDefault();
                // Remove the closest row
                $(this).closest('tr').remove();
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
                            url: '{{ route('setting-landing-page.update', $data->id) }}',
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
                                        '{{ route('setting-landing-page.index') }}';
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
