@extends('admin.template.layout')
@section('content')
    <div class="card mb-5 mb-xl-8">

        <div class="card-body">
            <!--begin::Action-->
            <a href="{{ route('module-permission.create') }}" class="btn btn-success me-5 mt-2">
                <i class="fas fa-plus"></i>
                Tambah Data
            </a>
            <!--end::Action-->
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table id="myTable" class="table table-row-bordered align-middle fw-bold table-striped">
                    <thead>
                        <tr class="fw-bold text-muted bg-secondary">
                            <th>Group Code</th>
                            <th>Group Name</th>
                            <th>Terakhir diperbarui</th>
                            <th class="pe-4 ">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-striped">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </div>
@endsection
@section('script')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            const deleteData = (url, kode, nama) => {
                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Untuk menghapus role : " + nama,
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
                            type: 'post', // Use the appropriate HTTP method (e.g., 'post' for delete)
                            url: url, // Use the generated URL
                            data: {
                                _method: 'delete', // Laravel expects a _method field for DELETE requests
                            },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include the CSRF token in the request headers
                            },
                            success: function(response) {
                                if (response.status == 'success') {
                                    Swal.fire({
                                        title: "Success!",
                                        text: response.message,
                                        icon: "success"
                                    }).then(function() {
                                        location.reload(true);
                                    });
                                } else if (response.status == 'error') {
                                    Swal.fire("Hapus Data Gagal!", response.message,
                                        "error");
                                }
                            },
                            error: function() {
                                Swal.fire("ERROR", "Hapus Data Gagal.", "error");
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire("Batal", "Hapus Data Dibatalkan.", "error");
                    }
                });
            }

            // Event listener for the filter button click
            $("#filter-table").on('click', function() {
                var date_start = $("#date_start").val();
                var date_end = $("#date_end").val();
                var filter_type = $("#filter_type").val();

                // Update the DataTable with the selected filters
                table.ajax.url('{{ route('module-permission.data') }}' + '?date_start=' + date_start +
                    '&date_end=' + date_end + '&filter_type=' + filter_type).load();
            });

            var table = $("#myTable").DataTable({
                responsive: true,
                "order": [],
                "ajax": {
                    url: '{{ route('module-permission.data') }}',
                    type: 'GET',
                },
                "columns": [{
                        data: 'code'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'updated_at'
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

            $('#myTable').on('click', '.btn-hapus', function() {
                var kode = $(this).data('id');
                var nama = $(this).data('nama');
                var url = '{{ route('module-permission.destroy', ':kode') }}';
                url = url.replace(':kode', kode);

                deleteData(url, kode, nama);
            });
        });
    </script>
@endsection
