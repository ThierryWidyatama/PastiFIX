@extends('admin.template.layout')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
    <!--begin::Tables Widget 13-->
    <div class="card mb-5 mb-xl-8">

        <form action="{{ route('modules.store') }}" method="POST" id="form">
            <div class="card-body ps-10 mt-1">
                @csrf
                <div class="col-xxl-12">
                    <div class="row g-8">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Parent Module</label>
                                <div class="col-sm-10">
                                    <select name="parent_id" id="parent_id" class="form-control form-select"
                                        data-select="select2">
                                        <option value="">parent</option>
                                        @foreach ($modules as $mdl)
                                            <option value="{{ $mdl->id }}">{{ $mdl->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <div class="form-group row">
                                    <label class="form-label">Kode Module</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="code" class="form-control" aria-describedby="code">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Nama Module</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" aria-describedby="name">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Link Module</label>
                                <div class="col-sm-10">
                                    <input type="text" name="link" class="form-control" aria-describedby="link">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Icon Module, <span><a
                                            href="https://preview.keenthemes.com/html/metronic/docs/icons/keenicons"
                                            target="_blank"> Cari Keen Icon</a></span></label>
                                <div class="col-sm-10">
                                    <textarea name="icon" id="" class="form-control" aria-describedby="icon" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Urutan Module</label>
                                <div class="col-sm-10">
                                    <input type="text" name="order" class="form-control" aria-describedby="order">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Aksi Module</label>
                                <div class="col-sm-10">
                                    <div class="py-5">
                                        <div class="rounded border ps-10 p-2 gap-2">
                                            <label
                                                class="form-check form-check-custom form-check-inline form-check-solid my-3 me-4 min-w-80px">
                                                <input class="form-check-input" name="actions[]" type="checkbox"
                                                    value="create">
                                                <span class="text-muted fw-semibold ps-2 fs-6">
                                                    Create
                                                </span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-inline form-check-solid my-3 me-4 min-w-80px">
                                                <input class="form-check-input" name="actions[]" type="checkbox"
                                                    value="read">
                                                <span class="text-muted fw-semibold ps-2 fs-6">
                                                    Read
                                                </span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-inline form-check-solid my-3 me-4 min-w-80px">
                                                <input class="form-check-input" name="actions[]" type="checkbox"
                                                    value="update">
                                                <span class="text-muted fw-semibold ps-2 fs-6">
                                                    Update
                                                </span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-inline form-check-solid my-3 me-4 min-w-80px">
                                                <input class="form-check-input" name="actions[]" type="checkbox"
                                                    value="delete">
                                                <span class="text-muted fw-semibold ps-2 fs-6">
                                                    Delete
                                                </span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-inline form-check-solid my-3 me-4 min-w-80px">
                                                <input class="form-check-input" name="actions[]" type="checkbox"
                                                    value="show">
                                                <span class="text-muted fw-semibold ps-2 fs-6">
                                                    Show
                                                </span>
                                            </label>
                                            <label
                                                class="form-check form-check-custom form-check-inline form-check-solid my-3 me-4 min-w-80px">
                                                <input class="form-check-input" name="actions[]" type="checkbox"
                                                    value="list">
                                                <span class="text-muted fw-semibold ps-2 fs-6">
                                                    List
                                                </span>
                                            </label>

                                        </div>
                                    </div>
                                    <input type="text" name="action" class="form-control smt-tags" id="smt-tags"
                                        aria-describedby="action" placeholder="Aksi Lainnya (gunakan koma(,) atau enter">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="form-label">Deskripsi Module</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col d-flex flex-column">
                <div class="card-footer">
                    <button type="submit" id="btn-submit" class="btn btn-primary btn-simpan">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <link href="{{ asset('plugins/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/custom/jstree/jstree.bundle.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('#parent_id').select2();
            $('.btn-simpan').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Logging in',
                    text: 'Silahkan tunggu...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                Swal.showLoading();

                var input = $('#smt-tags').val();
                if (input) {
                    // Parse the JSON data
                    var inputValues = JSON.parse(input);

                    // Process the parsed values
                    var tagValues = [];
                    inputValues.forEach(function(tag) {
                        tagValues.push(tag.value);
                    });
                    $('input[name="action"]').val(tagValues.join(','));
                }

                // Set the desired values to the action_module input
                var formData = new FormData($('#form')[0]);

                $.ajax({
                    url: $('#form').attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.close();

                        if (response.status == true) {
                            Swal.fire({
                                title: "Success!",
                                text: "Berhasil Menyimpan Data",
                                icon: "success"
                            }).then(function() {
                                window.location = '/modules';
                            });
                        } else {
                            var pesan = "";
                            var firstError = true;
                            $.each(response.pesan, function(key, value) {
                                if (firstError) {
                                    pesan += value + '. ';
                                    firstError = false;
                                }
                            });
                            Swal.fire("Error!", pesan, "error");
                        }
                    },
                    error: function() {
                        Swal.close();

                        Swal.fire("Error!", "Proses Gagal", "error");
                    }
                });
            });

        });


        //tag input
        var input1 = document.querySelector("#smt-tags");
        new Tagify(input1);
    </script>
@endsection
