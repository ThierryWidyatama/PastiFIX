@extends('admin.template.layout')
@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-body">
            <!--begin::Action-->
            <div class="d-flex my-2">
                @if (isAccess('create', $get_module, auth()->user()->role))
                    <button type="button" class="btn btn-primary m-2"
                        onclick="window.location.href = '{{ route('user.create') }}';">
                        <i class="fa fa-plus btn-icon-prepend"></i>Tambah
                    </button>
                @endif
                @if (isAccess('export', $get_module, auth()->user()->role))
                    <button type="button" class="btn btn-info m-2" onclick="window.location.href = '/user-excel';">
                        <i class="fa fa-download btn-icon-prepend"></i>Export
                    </button>
                @endif
                @if (isAccess('import', $get_module, auth()->user()->role))
                    <button type="button" class="btn btn-success m-2" onclick="window.location.href = '/import';">
                        <i class="fa fa-upload btn-icon-prepend"></i>Import
                    </button>
                @endif
            </div>
            <!--end::Action-->
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table id="myTable" class="table table-row-bordered align-middle fw-bold table-striped">
                    <thead>
                        <tr class="fw-bold text-muted bg-secondary">
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Hak Akses</th>
                            <th>Status</th>
                            <th class="pe-4 ">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-striped">
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $("#myTable").DataTable({
                responsive: true,
                "order": [],
                "ajax": {
                    url: '{{ route('user.data') }}',
                    type: 'GET',
                },
                "columns": [{
                        data: 'nama'
                    },
                    {
                        data: 'username'
                    },
                    {
                        data: 'set_role'
                    },
                    {
                        data: 'set_status'
                    },
                    {
                        data: 'action'
                    },
                ],
                "columnDefs": [{
                    className: 'px-7',
                    targets: 0
                }]
            });


            table.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            //delete
            $('#myTable').on('click', '.btn-hapus', function() {
                var kode = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Untuk menghapus data: " + nama,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus data!",
                    cancelButtonText: 'Tidak, batalkan',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'get',
                            url: '/user-destroy/' + kode,
                            dataType: 'json',
                            success: function(response) {
                                if (response.status == true) {
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Berhasil Menghapus Data",
                                        icon: "success"
                                    }).then(function() {
                                        location.reload(true);
                                    });
                                } else {
                                    Swal.fire("Hapus Data Gagal!", "", "warning");
                                }
                            },
                            error: function() {
                                Swal.fire("ERROR", "Hapus Data Gagal.", "error");
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire("Cancelled", "Hapus Data Dibatalkan.", "error");
                    }
                });
            });


            //soft
            $('#myTable').on('click', '.btn-reset', function() {
                var kode = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Untuk mereset password: " + nama,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, reset password!",
                    cancelButtonText: 'Tidak, batalkan',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'get',
                            url: '/user-reset/' + kode,
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Berhasil Mereset Password Menjadi 'smt'",
                                        icon: "success"
                                    }).then(function() {
                                        location.reload(true);
                                    });
                                } else {
                                    Swal.fire("Reset Password Gagal!", "", "warning");
                                }
                            },
                            error: function() {
                                Swal.fire("ERROR", "Reset Password Gagal.", "error");
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire("Batal", "Reset Password Dibatalkan.", "error");
                    }
                });
            });


            //ganti status
            $('#myTable').on('click', '.btn-status', function() {
                console.log($(this).data('id'));

                var kode = $(this).data('id');
                var nama = $(this).data('nama');
                var set_val = $(this).data('val');

                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Untuk mengganti status " + nama,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, ganti status!",
                    cancelButtonText: 'Tidak, batalkan proses',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'get',
                            url: '/user-reset-status/' + kode + '/' + set_val,
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    Swal.fire({
                                        title: "Success!",
                                        text: "Berhasil Merubah Status",
                                        icon: "success"
                                    }).then(function() {
                                        location.reload(true);
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Merubah Status Gagal!",
                                        icon: "warning"
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire("ERROR", "Merubah Status Gagal.", "error");
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire("Batal", "Merubah Status Dibatalkan.", "error");
                    }
                });
            });

        });
    </script>
@endsection
