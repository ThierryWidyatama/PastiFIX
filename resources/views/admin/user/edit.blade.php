@extends('admin.template.layout')
@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Edit Data User</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a class="text-muted">Home / Data User / Edit</a>
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
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid">

                    <!--begin::Tables Widget 13-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->

                        <div class="card-body ps-10 mt-1">
                            <form method="POST" id="form">
                                @csrf
                                <div class="col-xxl-12">
                                    <div class="row g-8">
                                        {{-- <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="form-label">Pegawai</label>
                                                <div class="col-sm-10">
                                                    <select name="employee_user" id="employee_user"
                                                        class="form-control smt-select2" data-placeholder="Pilih Pegawai">
                                                        <option value="">Pilih Pegawai</option>
                                                        @foreach ($pegawai as $item)
                                                            <option value="{{ $item->id_employee }}">
                                                                {{ $item->name_employee }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="form-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control"
                                                        aria-describedby="name" value="{{ $get_data->name }}" placeholder="Masukkan Nama">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="email" class="form-control"
                                                        aria-describedby="email" value="{{ $get_data->email }}" placeholder="Masukkan email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="form-label">Hak Akses</label>
                                                <div class="col-sm-10">
                                                    <select name="roles" id="roles" class="form-control"
                                                        data-placeholder="Pilih Hak Akses">
                                                        <option value="">Pilih Hak Akses</option>
                                                        @foreach ($role as $item)
                                                            <option @if ($get_data->role_id == $item->id) selected @endif value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="form-label">Username</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="username" class="form-control"
                                                        aria-describedby="username" value="{{ $get_data->username }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="form-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="password" class="form-control"
                                                        aria-describedby="password" placeholder="Masukkan Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group row">
                                                <label class="form-label">Status</label>
                                                <div class="col-sm-10">
                                                    <select name="status" id="status" class="form-control"
                                                        data-placeholder="Pilih Status">
                                                        <option value="">Pilih Status</option>
                                                        <option value="1" @if ($get_data->status == 1) selected @endif>Aktif</option>
                                                        <option value="0" @if ($get_data->status == 0) selected @endif>Tidak Aktif</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col d-flex flex-column">
                            <div class="card-footer">
                                <button type="submit" id="btn-submit" class="btn btn-primary btn-simpan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#employee_user').select2();
            $('#roles').select2();
            $('#status').select2();
            $('#kab_kota').select2();

            $('.btn-simpan').on('click', function() {
                $.ajax({
                    type: 'PUT',
                    url: '{{ route('user.update', $get_data->id) }}',
                    data: $('#form').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire({
                                title: "Success!",
                                text: "Berhasil Menyimpan Data",
                                icon: "success"
                            }).then(function() {
                                document.location = "{{ route('user.index') }}";
                            });
                        } else {
                            if (response.email) {
                                Swal.fire("Error!", response.email, "error");
                            } else {
                                var pesan = "";
                                jQuery.each(response.pesan, function(key, value) {
                                    pesan += value + '. ';
                                });
                                Swal.fire("Error!", pesan, "error");
                            }
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "Proses Gagal", "error");
                    }
                });
            });
        });
    </script>
@endsection
