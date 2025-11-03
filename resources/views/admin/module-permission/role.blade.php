@extends('admin.template.layout')
@section('content')
<div class="card mb-5 mb-xl-8">
    <!--begin::Header-->
    <div class="card-body ps-10 mt-1">
        <div class="col-xxl-12">
            <div class="row g-8">
                <div class="col-lg-4">
                    <div class="form-group row">
                        <div class="form-group row">
                            <label class="form-label">Kode Hak Akses</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="code_usergroup" data-control="select2"
                                    id="code_usergroup_select">
                                    @foreach ($datas as $role_data)
                                        <option value="{{ $role_data->id }}"
                                            {{ $role_data->id == $data->id_usergroup ? 'selected' : '' }}>
                                            {{ $role_data->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group row">
                        <label class="form-label">Nama Hak Akses</label>
                        <div class="col-sm-10">
                            <input type="text" name="name_usergroup" class="form-control"
                                aria-describedby="name_usergroup" value="{{ $data->name_usergroup }}"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group row">
                        <label class="form-label">Cari Module</label>
                        <div class="col-sm-10">
                            <input type="text" name="cari_module" id="cari_module"
                                class="form-control" aria-describedby="cari_module"
                                placeholder="Nama Module">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--begin::Row-->
<form action="{{ route('module-permission.role_store') }}" method="POST" id="form">
    @csrf
    <input type="hidden" name="user_groupmodule" value="{{ $data->id_usergroup }}">
    <div id="card-container" class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-5 g-xl-9">
        @foreach ($priv_modules as $mdl)
            @php
                $daction_now = $role
                    ->where('role_id', $data->id_usergroup)
                    ->where('module_id', $mdl->id)
                    ->first();
                $action_now = $daction_now ? $daction_now->action : '';
                $publish = $daction_now ? $daction_now->publish : '';
            @endphp
            <!--begin::Col-->
            <div class="col-md-3">
                <!--begin::Card-->
                <div class="card card-flush h-md-100">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>{{ $mdl->parent_name ? $mdl->parent_name.' / ':'' }}{{ $mdl->name }}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-1">
                        <!--begin::Users-->
                        <label class="form-check form-check-custom form-check-solid me-9 mb-5">
                            <input class="form-check-input widget-9-check"
                                name="status[{{ $mdl->id }}]" type="checkbox" value="1"
                                {{ $publish == 1 ? 'checked' : '' }}>
                            <span class="form-check-label" for="aktif">Aktif</span>
                        </label>
                        <div class="fw-bold text-gray-600 mb-5">Aksi</div>
                        <!--end::Users-->
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="form-check form-check-custom form-check-solid me-5 mb-5">
                                    <input class="form-check-input" type="checkbox" value=""
                                        data-loop="all"
                                        {{ count(explode(',', $action_now)) == count(explode(',', $mdl->action)) ? 'checked' : '' }}>
                                    <span class="form-check-label">Select all</span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            @php
                                $actionModule = ltrim($mdl->action, ',');
                            @endphp

                            @foreach (explode(',', $actionModule) as $action)
                                <div class="col-lg-4">
                                    <label
                                        class="form-check form-check-custom form-check-solid me-5 mb-5">
                                        <input class="form-check-input kt_roles_checkbox"
                                            name="kt_roles_checkbox[{{ $mdl->id }}][]"
                                            type="checkbox" value="{{ $action }}"
                                            data-loop="{{ $action }}"
                                            {{ in_array($action, explode(',', $action_now)) ? 'checked' : '' }}>
                                        <span class="form-check-label">{{ ucfirst($action) }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer flex-wrap pt-0">
                        <a href="{{ route('modules.edit', $mdl->id) }}"
                            class="btn btn-light btn-active-primary my-1 me-2">Edit Module</a>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->
        @endforeach
        <!--begin::Add new card-->
        <div class="col-md-3 exclude-card">
            <!--begin::Card-->
            <div class="card h-md-100">
                <!--begin::Card body-->
                <div class="card-body d-flex flex-center">
                    <!--begin::Button-->
                    <button type="button" class="btn btn-clear d-flex flex-column flex-center"
                        onclick="window.location.href = '{{ route('modules.create') }}';">
                        <!--begin::Illustration-->
                        <img src="{{ asset('media/illustrations/sketchy-1/4.png') }}" alt=""
                            class="mw-100 mh-150px mb-7">
                        <!--end::Illustration-->
                        <!--begin::Label-->
                        <div class="fw-bold fs-3 text-gray-600 text-hover-primary">+ Tambah Module
                        </div>
                        <!--end::Label-->
                    </button>
                    <!--begin::Button-->
                </div>
                <!--begin::Card body-->
            </div>
            <!--begin::Card-->
        </div>
        <!--begin::Add new card-->
    </div>
    <div class="row mt-5">
        <div class="col-lg-12">
            <button type="submit" id="btn-submit"
                class="btn btn-primary er w-100 fs-6 px-8 py-4 btn-simpan">Simpan</button>
        </div>
    </div>
</form>
<!--end::Row-->
@endsection
@section('script')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#code_usergroup_select').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue !== null) {
                window.location.href = '{{ route('module-permission.roles', ['id' => ':id']) }}'.replace(':id', selectedValue);
            }
        });

        $("input[data-loop='all']").on("change", function() {
            var isChecked = $(this).prop("checked");
            $(this).closest(".card-body").find(".kt_roles_checkbox").prop("checked", isChecked);
        });

        $(".kt_roles_checkbox").on("change", function() {
            var cardBody = $(this).closest(".card-body");
            var checkboxes = cardBody.find(".kt_roles_checkbox");
            var selectAllCheckbox = cardBody.find("input[data-loop='all']");

            // Check if all checkboxes are checked
            var isAllChecked = checkboxes.length === checkboxes.filter(":checked").length;

            // Update the "Select all" checkbox based on the checked status of individual checkboxes
            selectAllCheckbox.prop("checked", isAllChecked);
        });

        // Uncheck "Select all" checkbox if any individual checkbox is unchecked
        $(".kt_roles_checkbox").on("change", function() {
            var cardBody = $(this).closest(".card-body");
            var selectAllCheckbox = cardBody.find("input[data-loop='all']");

            if (!$(this).prop("checked")) {
                selectAllCheckbox.prop("checked", false);
            }
        });

        $('#cari_module').on('input', function() {
            var searchValue = $(this).val().toLowerCase();
            var container = $('#card-container');
            var cards = container.children('.col-md-3').not(
                '.exclude-card'); // Exclude the specific card
            var excludedCard = container.children('.col-md-3.exclude-card'); // Select the excluded card

            cards.sort(function(a, b) {
                var cardTitleA = $(a).find('.card-title h2').text().toLowerCase();
                var cardTitleB = $(b).find('.card-title h2').text().toLowerCase();

                if (cardTitleA.includes(searchValue) && !cardTitleB.includes(searchValue)) {
                    return -1;
                } else if (!cardTitleA.includes(searchValue) && cardTitleB.includes(
                        searchValue)) {
                    return 1;
                } else {
                    return 0;
                }
            });

            excludedCard.detach(); // Detach the excluded card
            cards.detach().appendTo(container); // Reorder and append other cards
            cards.show();

            cards.each(function() {
                var cardTitle = $(this).find('.card-title h2').text().toLowerCase();
                var card = $(this);

                if (!cardTitle.includes(searchValue)) {
                    card.hide();
                }
            });

            excludedCard.appendTo(container); // Append the excluded card back to the container
            excludedCard.show();
        });

        var inputs = document.querySelectorAll(".smt-tags");
        inputs.forEach(function(input) {
            new Tagify(input);
        });

        $('#form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Display the confirmation swal
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin ingin mengubah data?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                // If the user confirms the submission
                if (result.isConfirmed) {
                    // Get the values from the input field
                    var formData = new FormData($('#form')[0]);

                    // Perform the AJAX request
                    $.ajax({
                        url: '{{ route('module-permission.role_store') }}',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire("Berhasil!",
                                        "Data berhasil diubah!", "success")
                                    .then(() => {
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
                }
            });
        });

    });
</script>
@endsection
