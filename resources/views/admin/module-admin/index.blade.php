@extends('admin.template.layout')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
    <!--begin::Tables Widget 13-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->

        <div class="card-header border-0 pt-5">
            <div class="d-flex flex-wrap flex-stack mb-6">
            </div>
            <div class="d-flex my-2">
                <button type="button" class="btn btn-primary"
                    onclick="window.location.href = '{{ route('modules.create') }}';">
                    <i class="fa fa-plus btn-icon-prepend"></i>Tambah
                </button>
            </div>
        </div>

        <div class="separator separator-dashed mt-4 mb-4"></div>

        <div class="card-body ps-10">
            <div class="row g-6 g-xl-12">
                <!--begin::Col-->
                <div class="col-md-6 col-xl-12">
                    <!--begin::Card-->
                    <div class="row justify-content-center">
                        <div class="col-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div id="jstree_modules">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->


            </div>
        </div>

    </div>


    <style>
        .sortable>li>div {
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .sortable,
        .sortable>li>div {
            display: block;
            width: 100%;
            float: left;
        }

        .sortable>li {
            display: block;
            width: 100%;
            margin-bottom: 5px;
            float: left;
            border: 1px solid #ddd;
            background: #fff;
            padding: 5px;
        }

        .sortable ul {
            padding: 5px;
        }
    </style>
@endsection

@section('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <link href="{{ asset('plugins/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/custom/jstree/jstree.bundle.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.sortable').sortable({
                connectWith: '.sortable',
                placeholder: 'placeholder',
                // sort: function(e) {
                //     console.log('Handled');
                //     $(".sortable").css("background", "yellow");
                // },
                update: function(event, ui) {
                    var struct = [];
                    var i = 0;
                    $(".sortable").each(function(ind, el) {
                        struct[ind] = {
                            index: i,
                            class: $(el).attr("class"),
                            count: $(el).children().length,
                            parent: $(el).parent().is("li") ? $(el).parent().attr("id") :
                                "",
                            parentIndex: $(el).parent().is("li") ? $(el).parent().index() :
                                "",
                            array: $(el).sortable("toArray"),
                            serial: $(el).sortable("serialize")
                        };
                        i++;
                    });

                    var orderData = {};
                    $(struct).each(function(k, v) {
                        var main = v.array[0];
                        orderData[v.parent] = v.array;
                    });
                    // var myJsonString = JSON.stringify(orderData);
                    // console.log(myJsonString);
                    $.ajax({
                        url: "modules/sort",
                        method: "POST",
                        data: {
                            'main': orderData,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            // alert('Data berhasil diperbarui');
                        }
                    });
                }
            }).disableSelection();

            //delete
            $('#sortable').on('click', '.btn-delete', function() {
                var kode = $(this).data('id');
                var nama = $(this).data('nama');
                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Untuk menghapus data: " + nama,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'ajax',
                            method: 'get',
                            url: '/modules/delete/' + kode,
                            async: true,
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
                                    Swal.fire("Hapus Data Gagal!", {
                                        icon: "warning",
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire("ERROR", "Hapus Data Gagal.", "error");
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire("Dibatalkan!", "Hapus Data Dibatalkan.", "error");
                    }
                });
            });

        });
    </script>

    <script>
        function deleteData(kode, nama) {
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Untuk menghapus data: " + nama,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'ajax',
                        method: 'get',
                        url: '/modules/delete/' + kode,
                        async: true,
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
                                Swal.fire("Hapus Data Gagal!", {
                                    icon: "warning",
                                });
                            }
                        },
                        error: function() {
                            Swal.fire("ERROR", "Hapus Data Gagal.", "error");
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire("Dibatalkan!", "Hapus Data Dibatalkan.", "error");
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {

            $.ajax({
                url: "{{ route('modules.tree') }}",
                method: "GET",
                success: function(data) {
                    var treeData = buildTreeData(data);

                    $('#jstree_modules').jstree({
                        "core": {
                            "themes": {
                                "responsive": false
                            },
                            "check_callback": true,
                            'data': treeData
                        },
                        "contextmenu": {
                            "items": function(node) {
                                return {
                                    "customItem1": {
                                        "label": "<i class='fa fa-edit'></i> Edit",
                                        "action": function() {
                                            window.location.href =
                                                `/modules/${node.id}/edit`;
                                        }
                                    },
                                    "customItem2": {
                                        "label": "<i class='fa fa-info'></i> Detail",
                                        "action": function() {
                                            window.location.href =
                                            `/modules/${node.id}`;
                                        }
                                    },
                                    "customItem3": {
                                        "label": "<i class='fa fa-trash'></i> Delete",
                                        "action": function() {
                                            deleteData(node.id, node.text);
                                        }
                                    }
                                };
                            }
                        },
                        "plugins": ["dnd", "contextmenu"]
                    });
                }
            });

            // Recursive function to build tree data
            function buildTreeData(modules) {
                return modules.map(module => {
                    var moduleIcon = $(module.icon).attr("class") || "ki-solid ki-folder";
                    return {
                        id: module.id,
                        text: module.text,
                        icon: moduleIcon.replace("ki-duotone", "ki-solid"),
                        children: module.children.length > 0 ? buildTreeData(module.children) : []
                    };
                });
            }

            $('#jstree_modules').on('move_node.jstree', function(event, data) {
                var currentData = $(this).jstree(true).get_json('#', {
                    flat: false
                });
                if (data.node.parents.length >= 3) {
                    console.log(data.node.parents);

                    // return;
                }
                //send currentData to ajax
                $.ajax({
                    url: "{{ route('modules.sort_tree') }}",
                    method: "POST",
                    data: {
                        modules: currentData,
                        _token: '{{ csrf_token() }}',
                    },
                });
            });
        })
    </script>
    <!--end::Javascript-->
@endsection
