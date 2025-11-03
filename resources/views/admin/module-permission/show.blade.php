@extends('admin.template.layout')
@section('content')
                <!--begin::Tables Widget 13-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Header-->

                    <div class="card-body ps-10 mt-1">
                        <form action="{{ route('module-permission.store') }}" method="POST" id="form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="col-xxl-12">
                                <div class="row g-8">
                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <div class="form-group row">
                                                <label class="form-label">Kode Hak Akses</label>
                                                <div class="col-sm-10">{{ $data->code }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label class="form-label">Nama Hak Akses</label>
                                            <div class="col-sm-10">{{ $data->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

@endsection
@section('script')
<script>
</script>
@endsection
