@extends('admin.template.layout')
@section('content')
    <!--begin::Tables Widget 13-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->

        <div class="card-body ps-10 mt-1">
            <form action="{{ route('module-permission.store') }}" method="POST" id="form">
                @csrf
                <div class="col-xxl-12">
                    <div class="row g-8">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <div class="form-group row">
                                    <label class="form-label">Kode Hak Akses</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="code" class="form-control" aria-describedby="code">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Nama Hak Akses</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" aria-describedby="name">
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#btn-submit').on('click', function(e) {
                e.preventDefault(); // Prevent the default button click behavior


                var formData = new FormData($('#form')[0]);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('module-permission.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === true) {
                            Swal.fire({
                                title: "Success!",
                                text: "Berhasil Menyimpan Data",
                                icon: "success"
                            }).then(function() {
                                document.location = '/module-permission';
                            });
                        } else {
                            var pesan = "";
                            jQuery.each(response.pesan, function(key, value) {
                                pesan += value + '. ';
                            });
                            Swal.fire("Error!", pesan, "error");
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
