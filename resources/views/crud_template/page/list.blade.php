@extends(config('template.layout'))


@section('content')

    <!--begin::Tables Widget 13-->
    <div class="card mb-5 mb-xl-8">
        @if (isset($fields_filter))
            @if ($fields_filter != null)
                <div class="card-body border-0 ps-10">
                    <div class="col-xxl-12">
                        <div class="row g-1">
                            @foreach ($fields_filter as $field_name => $field)
                                <div class="col-lg-2 me-3">
                                    <x-init :name="$field_name" :field="$field" value="" />
                                </div>
                            @endforeach
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-primary me-5 mt-8" id="filter-table">
                                    <i class="fas fa-search"></i>
                                    Cari
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="separator separator-dashed"></div>
            @endif
        @endif
        <div class="card-body">
            <!--begin::Action-->
            @if ($disable_create)
                @if (isAccess('create', get_module_id($module), auth()->user()->roles))
                    <button type="button" class="btn btn-success me-5 mt-2" id="btn-create"
                        onclick="window.location.href='{{ $url['create'] }}'">
                        <i class="fas fa-plus"></i>
                        Tambah {{ $title }}
                        </span>
                    </button>
                @endif
            @endif
            <!--end::Action-->
            @if (isset($buttons))
                @foreach ($buttons as $button_name => $button)
                    @if (isAccess($button_name, get_module_id($module), auth()->user()->roles))
                        {!! $button !!}
                    @endif
                @endforeach
            @endif
        </div>

        <!--begin::Body-->
        <div class="card-body pt-0">
            <!--begin::Table Search-->
            <div class="d-flex align-items-center position-relative my-1 mb-4">
                <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span
                        class="path2"></span></i>
                <input type="text" id="searchTable" class="form-control form-control-solid w-250px ps-15"
                    placeholder="Cari {{ $title }}" />
            </div>
            <!--end::Table Search-->
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="kt_datatable_dom_positioning"
                    class="table table-row-bordered gy-4 align-middle fw-bold table-striped">
                    <!--begin::Table head-->
                    <thead class="">
                        <tr class="fw-bold text-muted bg-secondary">
                            @foreach ($columns as $column => $label)
                                <th class="px-7">{{ isset($label['label']) ? $label['label'] : $label }}</th>
                            @endforeach
                            @if ($disable_action)
                                <th class="text-end pe-4">AKSI</th>
                            @endif
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fs-6"></tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    <!--end::Tables Widget 13-->



    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>

    {{-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('js/custom/widgets.js') }}"></script>
    <script src="{{ asset('js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('js/custom/utilities/modals/create-campaign.js') }}"></script>
    <script src="{{ asset('js/custom/utilities/modals/users-search.js') }}"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
@endsection

@section('script')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> --}}
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {!! $custom_script ?? '' !!}

    <script>
        var table;
        $(document).ready(function() {
            {!! $js_code ?? '' !!}
            table = $('#kt_datatable_dom_positioning').DataTable({
                order: [],
                responsive: true,
                processing: true,
                ajax: "{!! $url['datatables'] !!}",
                columns: {!! $column_datatables !!},
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td').addClass('px-7');
                }
            });


            $('#filter-table').click(function() {
                table.destroy();
                table = $('#kt_datatable_dom_positioning').DataTable({ // Reinitialize the DataTable
                    processing: true,
                    ajax: {
                        url: "{!! $url['datatables'] !!}",
                        data: function(d) {
                            @if (isset($fields_filter))
                                @foreach ($fields_filter as $field_name => $field)
                                    d.{{ $field_name }} = $('#{{ $field_name }}-form')
                                        .val();
                                @endforeach
                            @endif
                        }
                    },
                    columns: {!! $column_datatables !!},
                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td').addClass('px-7');
                    },
                    headerCallback: function(thead, data, start, end, display) {
                        $(thead).find('th').eq(0).addClass('ps-7');
                    },
                });
            });

            // Debounce the search input
            $("#searchTable").on("keyup", debounce(function() {
                // Get the search value from the input
                let searchValue = $(this).val();

                // Perform the search and redraw the table
                table.search(searchValue).draw();
            }, 300));

        });

        function deleteData(id) {
            Swal.fire({
                title: 'Hapus data?',
                text: 'Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
            }).then((result) => {
                // kode yang dijalankan setelah pengguna memilih Ya atau Tidak
                if (result.isConfirmed) {
                    //ajax hapus data
                    $.ajax({
                        url: `{{ $url['baseurl'] }}/` + id,
                        type: 'DELETE',
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
                        },
                        success: function(response) {
                            $('#loading').addClass('fa fa-spinner fa-spin fa-fw');
                            Swal.fire({
                                title: "Silahkan Tunggu ....",
                                allowOutsideClick: false, // Prevent closing by clicking outside
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // kode yang dijalankan jika request berhasil
                            setTimeout(function() {
                                Swal.close();
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: 'Data berhasil disimpan',
                                    icon: 'success'
                                }).then(function() {
                                    table
                                        .destroy(); // Destroy the existing DataTable instance
                                    table = $('#kt_datatable_dom_positioning')
                                        .DataTable({
                                            processing: true,
                                            ajax: "{!! $url['datatables'] !!}",
                                            columns: {!! $column_datatables !!}
                                        });
                                });
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            // kode yang dijalankan jika request gagal
                            console.log('Terjadi kesalahan saat menghapus data:', error);
                        }
                    });
                }
            });
        }

        /**
         * Creates a debounced version of a function that will delay its execution
         * until after delay milliseconds have passed since the last time it was
         * invoked. Returns the debounced function.
         *
         * @param {function} func - The function to debounce.
         * @param {number} delay - The number of milliseconds to delay execution.
         * @return {function} The debounced function.
         */
        function debounce(func, delay) {
            let timeoutId;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function() {
                    func.apply(context, args);
                }, delay);
            };
        }
    </script>
@endsection
