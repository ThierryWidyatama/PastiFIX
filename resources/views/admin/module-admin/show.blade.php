@extends('admin.template.layout')

@section('css')
@endsection

@section('page-title')
@endsection

@section('content')
                    <!--begin::Tables Widget 13-->
                    <div class="card mb-5 mb-xl-8">

                        <div class="card-body ps-10 mt-1">
                            <div class="card-body p-9">
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Parent Module</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">
                                            @if ($data->parent_id == null)
                                                Parent Module
                                            @else
                                                {{ $data->parent->name }}
                                            @endif
                                            
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Kode Module</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $data->code }}</span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Nama Module</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $data->name }}</span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Link Module</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $data->link }}</span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Icon Module</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $data->icon }}</span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Urutan Module</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $data->order }}</span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Aksi Module</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $data->action }}</span>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Deskripsi Module</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800">{{ $data->description }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col d-flex flex-column">
                            <div class="card-footer">
                                <button type="submit" id="btn-submit"
                                    onclick="window.location.href = '{{ route('modules.edit', [$data->id]) }}'"
                                    class="btn btn-primary btn-simpan">Edit Data</button>
                            </div>
                        </div>
                    </div>
@endsection

@section('script')
    <script>
        //tag input
        var input1 = document.querySelector("#smt-tags");
        new Tagify(input1);
    </script>
@endsection
