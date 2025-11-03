@extends(config('template.layout'))

@section('content')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Detail Data {{ $title }}</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a class="text-muted">{{ $subtitle }} / Detail</a>
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
    <div class="app-main flex-column flex-row-fluid dashboard " id="detail" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid">

                    <!--begin::Tables Widget 13-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Header-->

                        <div class="card-body ps-10 mt-1">
                            <div class="judul"> {{ $title }}</div>
                            <div class="row mt-3">
                                @foreach ($columns as $column => $label)
                                    @if (is_array($label))
                                        @if ($label['type'] == 'image')
                                            <div class="col-md-4 mt-4">
                                                <div class="up">{{ $label['name'] }}</div>
                                                <div class="down">
                                                    @if ($data->$column != null && file_exists(public_path($data->$column)))
                                                        <img src="{!! asset($data->$column) !!}" alt="{{ $label['name'] }}"
                                                            style="max-width: 300px; height: auto;">
                                                    @else
                                                        File tidak tersedia
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif ($label['type'] == 'file')
                                            <div class="col-md-6 mt-4">
                                                <div class="up mb-3">{{ $label['name'] }}</div>
                                                @if ($data->$column != null && file_exists(public_path($data->$column)))
                                                    @php
                                                        $filePath = public_path($data->$column);
                                                        $extension = \Illuminate\Support\Str::lower(pathinfo($filePath, PATHINFO_EXTENSION));
                                                    @endphp
                                                    @if ($extension === 'pdf')
                                                        <embed type="application/pdf" src="{{ asset($data->$column) }}"
                                                            height="600" width="100%">
                                                    @elseif ($extension === 'docx' || $extension === 'doc')
                                                        <embed
                                                            src="https://view.officeapps.live.com/op/embed.aspx?src={{ asset($data->$column) }}"
                                                            width="100%" height="600px">
                                                    @endif
                                                @else
                                                    File Tidak Tersedia
                                                @endif
                                            </div>
                                        @else
                                            <div class="col-md-4 mt-4">
                                                <div class="up">{{ $label['name'] }}</div>
                                                <div class="down">{!! $data->$column !!}</div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-md-4 mt-4">
                                            <div class="up">{{ $label }}</div>
                                            <div class="down">{!! $data->$column !!}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col d-flex flex-column">
                            <div class="card-footer">
                                <button type="submit" id="btn-submit"
                                    onclick="window.location.href = '{{ "/$module/" . $primary_key . '/edit' }}'"
                                    class="btn btn-primary btn-simpan">Edit Data</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
