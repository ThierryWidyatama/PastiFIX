@extends('admin.template.layout')
@section('content')
    <!--begin::Layout-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Summary-->
                    <!--begin::User Info-->
                    <div class="d-flex flex-center flex-column py-5">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            @if ($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="image" />
                            @else
                                <img src="{{ asset('media/avatars/blank.png') }}" alt="image" />
                            @endif
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Name-->
                        <div class="fs-3 text-gray-800 fw-bold mb-3">{{ $user->name }}</div>
                        <!--end::Name-->
                        <!--begin::Position-->
                        <div class="mb-5">
                            <!--begin::Badge-->
                            <div class="badge badge-lg badge-light-primary d-inline">{{ $user->role->name }}</div>
                            <!--begin::Badge-->
                        </div>
                        <!--end::Position-->
                    </div>
                    <!--end::User Info-->
                    <!--end::Summary-->
                    <!--begin::Details toggle-->
                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details"
                            role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details
                            <span class="ms-2 rotate-180">
                                <i class="ki-duotone ki-down fs-3"></i>
                            </span>
                        </div>
                    </div>
                    <!--end::Details toggle-->
                    <div class="separator"></div>
                    <!--begin::Details content-->
                    <div id="kt_user_view_details" class="collapse show">
                        <div class="pb-5 fs-6">
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Username</div>
                            <div class="text-gray-600">{{ $user->username }}</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Email</div>
                            <div class="text-gray-600">{{ $user->email }}</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Email Status</div>
                            <div class="text-gray-600">{!! $user->status_email !!}</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Email Verified at</div>
                            <div class="text-gray-600">{{ $user->formatted_email_verified_at }}</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Last Login</div>
                            <div class="text-gray-600">{{ $user->last_login_at }}</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Last Login IP</div>
                            <div class="text-gray-600">{{ $user->last_login_ip }}</div>
                            <!--begin::Details item-->
                        </div>
                    </div>
                    <!--end::Details content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                        href="#kt_user_view_overview_tab">Overview</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                        href="#kt_user_view_overview_security">Security</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                        href="#kt_user_view_overview_events_and_logs_tab">Sessions & Logs</a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                    <div class="card mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Profile Details</h3>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--begin::Card header-->
                        <!--begin::Form-->
                        <form id="kt_account_profile_details_form" method="POST" action="" class="form">
                            @csrf
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8">
                                        <!--begin::Image input-->
                                        <div class="">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-empty mb-10" data-kt-image-input="true"
                                                style="background-image: url({{ $user->avatar ? asset($user->avatar) : asset('media/avatars/blank.png') }})">
                                                <!--begin::Preview existing avatar-->
                                                <div class="image-input-wrapper w-125px h-125px"></div>
                                                <!--end::Preview existing avatar-->
                                                <!--begin::Edit-->
                                                <label
                                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click" aria-label="Change avatar"
                                                    data-bs-original-title="Change avatar" data-kt-initialized="1">
                                                    <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span
                                                            class="path2"></span></i>
                                                    <!--begin::Inputs-->
                                                    <input type="file" name="avatar" id="avatar"
                                                        accept=".png, .jpg, .jpeg">
                                                    <input type="hidden" name="avatar_remove">
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit-->

                                                <!--begin::Cancel-->
                                                <span
                                                    class="btn btn-icon btn-color-muted btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click" aria-label="Cancel avatar"
                                                    data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                                                    <i class="ki-outline ki-cross fs-3"></i> </span>
                                                <!--end::Cancel-->

                                                <!--begin::Remove-->
                                                <span
                                                    class="btn btn-icon btn-color-muted btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click" aria-label="Remove avatar"
                                                    data-bs-original-title="Remove avatar" data-kt-initialized="1">
                                                    <i class="ki-outline ki-cross fs-3"></i> </span>
                                                <!--end::Remove-->
                                            </div>
                                            <!--end::Image input-->
                                        </div>
                                        <!--end::Image input-->
                                        <!--begin::Hint-->
                                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="name"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="Nama" value="{{ $user->name }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Username</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="username"
                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                            placeholder="Nama" value="{{ $user->username }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Role</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" disabled
                                            class="form-control form-control-lg form-control-solid" placeholder="Role"
                                            value="{{ $user->role->name }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span class="">Email</span>
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            title="Ganti email pada tab security">
                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" disabled
                                            class="form-control form-control-lg form-control-solid"
                                            placeholder="Phone number" value="{{ $user->email }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Batal</button>
                                <button type="button" class="btn btn-primary"
                                    id="kt_account_profile_details_submit">Simpan</button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_user_view_overview_security" role="tabpanel">
                    <div class="card mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Password</h3>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--begin::Card header-->
                        <!--begin::Form-->
                        <form id="kt_account_password_form" class="form">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Password Lama</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row mb-2" data-kt-password-meter="true">
                                        <!--begin::Input wrapper-->
                                        <div class="position-relative mb-1">
                                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                type="password" id="old_password" placeholder="Password" name="old_password"
                                                autocomplete="off" />
                                            <span
                                                class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                data-kt-password-meter-control="visibility">
                                                <i class="ki-duotone ki-eye-slash fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                                <i class="ki-duotone ki-eye fs-2 d-none">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <!--end::Input wrapper-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-6">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Password Baru</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row mb-5" data-kt-password-meter="true">
                                        <!--begin::Wrapper-->
                                        <div class="mb-1">
                                            <!--begin::Input wrapper-->
                                            <div class="position-relative mb-3">
                                                <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    type="password" id="new_password" placeholder="Password" name="new_password"
                                                    autocomplete="off" />
                                                <span
                                                    class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                    data-kt-password-meter-control="visibility">
                                                    <i class="ki-duotone ki-eye-slash fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                    </i>
                                                    <i class="ki-duotone ki-eye fs-2 d-none">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <!--end::Input wrapper-->
                                            <!--begin::Meter-->
                                            <div class="d-flex align-items-center mb-3"
                                                data-kt-password-meter-control="highlight">
                                                <div class="flex-grow-1 bg-secondary bg-active-danger rounded h-5px me-2">
                                                </div>
                                                <div class="flex-grow-1 bg-secondary bg-active-warning rounded h-5px me-2">
                                                </div>
                                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px">
                                                </div>
                                            </div>
                                            <!--end::Meter-->
                                        </div>
                                        <!--end::Wrapper-->
                                        <!--begin::Hint-->
                                        <div class="text-muted"> Gunakan 8 karakter atau lebih dengan campuran huruf, angka
                                            & simbol.</div>
                                        <!--end::Hint-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-3">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Konfirmasi Password
                                        Baru</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row mb-2" data-kt-password-meter="true">
                                        <!--begin::Input wrapper-->
                                        <div class="position-relative mb-1">
                                            <input class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                type="password" id="confirm_password" placeholder="Password" name="confirm_password"
                                                autocomplete="off" />
                                            <span
                                                class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                data-kt-password-meter-control="visibility">
                                                <i class="ki-duotone ki-eye-slash fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                                <i class="ki-duotone ki-eye fs-2 d-none">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <!--end::Input wrapper-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Batal</button>
                                <button type="button" class="btn btn-primary"
                                    id="kt_account_password_submit">Simpan</button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">Verifikasi 2 Langkah</h2>
                                <div class="fs-6 fw-semibold text-muted">Jika diaktifkan maka setelah login maka anda harus mengisi kode otp atau klik tombol Verifikasi 2fa di email untuk login</div>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pb-5">
                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                    <input @disabled(is_null($user->email_verified_at)) class="form-check-input" data-id="{{ $user->id }}" id="enable_twofa" type="checkbox" value="" @if ($user->is_twofa_enabled == 1) checked
                                    @else
                                    @endif/>
                                    <label class="form-check-label">
                                        @if ($user->is_twofa_enabled == 1)
                                        <span class="badge badge-light-success">Aktif</span>
                                        @else
                                        <span class="badge badge-light-danger">Tidak Aktif</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <!--end::Item-->
                            <!--begin:Separator-->
                            <div class="separator separator-dashed my-5"></div>
                            <!--end:Separator-->
                            <!--begin::Disclaimer-->
                            <div class="text-gray-600"> Jika anda tidak menerima email verifikasi, silahkan cek folder
                                spam.
                            </div>
                            <!--end::Disclaimer-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">Verifikasi Email</h2>
                                <div class="fs-6 fw-semibold text-muted"> Jaga keamanan akun Anda dengan verifikasi.</div>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Add-->
                                @if ($user->email_verified_at)
                                    {!! $user->status_email !!}
                                @else
                                @endif
                                <!--end::Menu-->
                                <!--end::Add-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pb-5">
                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Content-->
                                <div class="d-flex flex-column">
                                    <span>Email</span>
                                    <span class="text-muted fs-6">{{ $user->email }}</span>
                                </div>
                                <!--end::Content-->
                                <!--begin::Action-->
                                <div class="d-flex justify-content-end align-items-center">
                                    <!--begin::Button-->
                                    <button type="button"
                                        class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto me-5"
                                        data-bs-toggle="modal" data-bs-target="#change_email">
                                        <i class="ki-duotone ki-pencil fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <!--end::Button-->
                                    <!--begin::Button-->
                                    @if (is_null($user->email_verified_at))
                                    <button type="button"
                                        class="btn btn-icon btn-active-light-success w-30px h-30px ms-auto me-5"
                                        id="verify_email">
                                        <i class="ki-duotone ki-shield-tick fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        </i>
                                    </button>
                                    @endif
                                    <!--end::Button-->
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Item-->
                            <!--begin:Separator-->
                            <div class="separator separator-dashed my-5"></div>
                            <!--end:Separator-->
                            <!--begin::Disclaimer-->
                            <div class="text-gray-600"> Jika anda tidak menerima email verifikasi, silahkan cek folder
                                spam.
                            </div>
                            <!--end::Disclaimer-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_user_view_overview_events_and_logs_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Login Sessions</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th class="min-w-120px">IP Address</th>
                                            <th class="min-w-150px">Device</th>
                                            <th>Time</th>
                                            <th class="min-w-70px text-end">Payload</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        @foreach ($user->sessions as $session)
                                            <tr>
                                                <td>{{ $session->ip_address }}</td>
                                                <td>{{ $session->user_agent }}</td>
                                                <td>{{ date('Y-m-d H:i:s', $session->last_activity) }}</td>
                                                <td class="text-end">
                                                    @livewire('show-payload', ['session_id' => $session->id])
                                                    {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#modal_show_payload"
                                                    wire:click="showPayload({{ $session->id }})"
                                                    class="btn btn-icon btn-sm btn-info">
                                                    <i class="ki-duotone ki-magnifier fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Logs</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body py-0">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5"
                                    id="kt_table_users_logs">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th class="min-w-100px">IP Address</th>
                                            <th>Device</th>
                                            <th class="min-w-125px">Activity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->logs as $log)
                                            <tr>
                                                <td class="min-w-125px">{{ $log->ip }}</td>
                                                <td class="min-w-300px">{{ $log->browser }}</td>
                                                <td class="pe-0 min-w-200px">{{ $log->activity }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Layout-->
    <div class="modal fade" tabindex="-1" id="change_email">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Ubah Email</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form action="" id="change_email_form">
                        @csrf
                        <div>
                            <p class="text-danger">Jika anda merubah email anda, maka anda harus memverifikasi kembali email anda.</p>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="{{ $user->email }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Silahkan Konfirmasi Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="change_email_btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#kt_table_users_login_session').DataTable({});

            $('#kt_table_users_logs').DataTable({});

            $('#enable_twofa').on('change', function() {
                let isEnabled = $(this).is(':checked') ? true : false;
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: isEnabled ? 'Apakah Anda yakin ingin mengaktifkan 2FA?' : 'Apakah Anda yakin ingin menonaktifkan 2FA?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('user-profile.twofa.update', $user->id) }}', // Adjust the URL to your endpoint for enabling/disabling 2FA
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}', // Include the CSRF token for Laravel
                                is_twofa_enabled: isEnabled
                            },
                            success: function(response) {
                                if (response.status) {
                                    if (isEnabled) {
                                        $('.form-check-label').html('<span class="badge badge-light-success">Aktif</span>');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: '2FA berhasil diaktifkan.'
                                        });
                                    } else {
                                        $('.form-check-label').html('<span class="badge badge-light-danger">Tidak Aktif</span>');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: '2FA berhasil dinonaktifkan.'
                                        });
                                    }
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Terjadi kesalahan. Silakan coba lagi.'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan. Silakan coba lagi.'
                                });
                                // Optionally, revert the checkbox state if there's an error
                                $('#enable_twofa').prop('checked', !isEnabled);
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // Optionally, revert the checkbox state if the user cancels the confirmation
                        $('#enable_twofa').prop('checked', !isEnabled);
                    }
                });
            });

            $('#kt_account_profile_details_submit').click(function(e) {
                e.preventDefault();
                var form = $('#kt_account_profile_details_form'); // Replace with your actual form's ID
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyimpan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        var formData = new FormData(form[0]);
                        formData.append('_token', $('input[name="_token"]').val());

                        $.ajax({
                            url: '{{ route('user-profile.update', $user->id) }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.status === true) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: "Data berhasil disimpan",
                                        icon: "success",
                                    }).then(() => {
                                        window.location.href =
                                            `{{ route('user-profile.index') }}`;
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal menyimpan',
                                        text: response.message,
                                        icon: "error",
                                    });
                                    errorForm(response.errors);
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire({
                                    title: 'Gagal menyimpan',
                                    text: xhr.responseJSON.message,
                                    icon: "error",
                                });
                                errorForm(xhr.responseJSON.errors);
                            }
                        });
                    }
                });
            });

            $('#kt_account_password_submit').click(function(e) {
                e.preventDefault();
                var form = $('#kt_account_password_form'); // Replace with your actual form's ID
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyimpan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        var formData = new FormData(form[0]);
                        formData.append('_token', $('input[name="_token"]').val());

                        $.ajax({
                            url: '{{ route('user-profile.password.update', $user->id) }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.status === true) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: "Data berhasil disimpan",
                                        icon: "success",
                                    }).then(() => {
                                        window.location.href =
                                            `{{ route('user-profile.index') }}`;
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal menyimpan',
                                        text: response.message,
                                        icon: "error",
                                    });
                                    errorForm(response.errors);
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire({
                                    title: 'Gagal menyimpan',
                                    text: xhr.responseJSON.message,
                                    icon: "error",
                                });
                                errorForm(xhr.responseJSON.errors);
                            }
                        });
                    }
                });
            });

            $('#change_email_btn').click(function(e) {
                e.preventDefault();
                var form = $('#change_email_form'); // Replace with your actual form's ID
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin mengubah email?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        var formData = new FormData(form[0]);
                        formData.append('_token', $('input[name="_token"]').val());

                        $.ajax({
                            url: '{{ route('user-profile.email.update', $user->id) }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.status === true) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: "Data berhasil disimpan",
                                        icon: "success",
                                    }).then(() => {
                                        window.location.href =
                                            `{{ route('user-profile.index') }}`;
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal menyimpan',
                                        text: response.message,
                                        icon: "error",
                                    });
                                    errorForm(response.errors);
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire({
                                    title: 'Gagal menyimpan',
                                    text: xhr.responseJSON.message,
                                    icon: "error",
                                });
                                errorForm(xhr.responseJSON.errors);
                            }
                        });
                    }
                });
            });

            $('#verify_email').click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin memverifikasi email?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '{{ route('user-profile.email.verify', $user->id) }}',
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.status === true) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: "Email berhasil dikirim, silahkan cek email anda",
                                        icon: "success",
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal mengirim email',
                                        text: response.message,
                                        icon: "error",
                                    });
                                    errorForm(response.errors);
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire({
                                    title: 'Gagal mengirim email',
                                    text: xhr.responseJSON.message,
                                    icon: "error",
                                });
                                errorForm(xhr.responseJSON.errors);
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
