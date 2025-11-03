@extends('admin.template.layout')
@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <div class="d-flex align-items-center position-relative my-1 mb-4 gap-2">
                <input type="text" name="nomor_filter" id="nomor_filter" class="form-control" placeholder="Nomor">
                <select class="form-select min-w-250px" data-control="select2"
                    data-placeholder="Pilih tipe dokumen terlebih dahulu" id="jenis_dokumen" data-allow-clear="true"
                    name="jenis_dokumen">
                    <option></option>
                </select>
                <input type="text" name="tahun" id="tahun" class="form-control" placeholder="Tahun">
            </div>
            <div class="card-toolbar gap-4">
                <!--begin::Action-->
                <div class="d-flex justify-content-end my-2">
                    <button class="btn btn-primary btn-sm" id="filter-table">
                        <i class="ki-outline ki-magnifier fs-2">
                        </i>Cari</button>
                </div>
                <!--end::Action-->
            </div>
        </div>
        <div class="separator my-6"></div>
        <div class="card-header border-0 pt-5">
            <div class="d-flex align-items-center position-relative my-1 mb-4">
                <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span
                        class="path2"></span></i>
                <input type="text" id="searchTable" class="form-control form-control-solid w-250px ps-15"
                    placeholder="Cari data" autocomplete="off" />
            </div>
            <div class="card-toolbar gap-4">
                <!--begin::Action-->
                <div class="d-flex justify-content-end my-2">
                    <a href="{{ route('master-produk-hukum.create') }}" class="btn btn-success btn-sm"><i
                            class="ki-duotone ki-plus-square fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>Tambah Produk Hukum</a>
                </div>
                <!--end::Action-->
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-row-bordered align-middle fw-bold table-striped">
                    <thead>
                        <tr class="fw-bold text-muted bg-secondary">
                            <th class="text-start ps-7">No</th>
                            <th>Jenis</th>
                            <th>Nomor</th>
                            <th>Tahun Diundang</th>
                            <th>Judul</th>
                            <th>Dibuat</th>
                            <th>Publish</th>
                            <th class="">Aksi</th>
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
            initSelect2('{{ route('master-jenis-dokumen.jenisDokumenSelect') }}', '#jenis_dokumen');
            $('#tahun').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            var table = $("#myTable").DataTable({
                responsive: true,
                "order": [],
                "ajax": {
                    url: '{{ route('master-produk-hukum.data') }}',
                    type: 'GET',
                    data: function(data) {}
                },
                "columns": [{
                        data: null, // Use null for the index column
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Use row index + 1 for the "No" column
                        },
                        className: 'text-start ps-7'
                    },
                    {
                        data: 'jenisDokumen'
                    },
                    {
                        data: 'nomor'
                    },
                    {
                        data: 'tahun_diundang'
                    },
                    {
                        data: 'judul'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'publish'
                    },
                    {
                        data: 'action'
                    }

                ],
                "columnDefs": [{
                        className: 'px-7',
                        targets: 0
                    },
                    {
                        className: 'text-start ps-4', // Add text-end class to action column
                        targets: 2
                    }
                ]
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
                            type: 'DELETE',
                            url: `{{ route('master-produk-hukum.destroy', ':id') }}`
                                .replace(':id', kode),
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
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


            $("#filter-table").on('click', function() {
                var nomor_filter = $("#nomor_filter").val();
                var jenis_dokumen = $("#jenis_dokumen").val();
                var tahun = $("#tahun").val();

                // Update the DataTable with the selected filters
                table.ajax.url(
                    `{{ route('master-produk-hukum.data') }}?nomor_filter=${nomor_filter}&jenis_dokumen=${jenis_dokumen}&tahun=${tahun}`
                    ).load();
            });

            $("#searchTable").on("keyup", debounce(function() {
                // Get the search value from the input
                let searchValue = $(this).val();

                // Perform the search and redraw the table
                table.search(searchValue).draw();
            }, 300));

        });
    </script>
@endsection
