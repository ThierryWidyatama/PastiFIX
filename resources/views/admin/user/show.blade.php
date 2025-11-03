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
                    Detail Data User</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a class="text-muted">Home / Data User / Detail</a>
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
            <div class="app-main flex-column flex-row-fluid dashboard " id="detail">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">

                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container container-fluid">

                            <!--begin::Tables Widget 13-->
                            <div class="card mb-5 mb-xl-8">
                                <!--begin::Header-->

                                <div class="card-body ps-10 mt-1">
                                    <div class="row mt-3">
                                        <div class="col-md-4 mt-4">
                                            <div class="up">Nama Lengkap</div>
                                            <div class="down fw-bold">{{ $get_data->name }}</div>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <div class="up">Email</div>
                                            <div class="down fw-bold">{{ $get_data->email }}</div>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <div class="up">Role</div>
                                            <div class="down fw-bold">{{ $get_data->role->name }}</div>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <div class="up">Bergabung Pada Tanggal</div>
                                            <div class="down fw-bold">{{ \Carbon\Carbon::parse($get_data->created_at)->translatedFormat('d F Y ') }}</div>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <div class="up">No. Telepon</div>
                                            <div class="down fw-bold">{{ $get_data->phone ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <div class="up">Jenis Kelamin</div>
                                            <div class="down fw-bold">{{ $get_data->gender ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <div class="up">Tanggal Ulang Tahun</div>
                                            <div class="down fw-bold">{{ $get_data->birthdate ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
            <i class="ki-duotone ki-arrow-up">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Scrolltop-->
    </div>
@endsection
@section('script')
@endsection
