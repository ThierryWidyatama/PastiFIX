@extends('admin.template.layout')
@section('content')
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Edit Produk Hukum</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Form-->
        <form action="" method="POST" class="form" id="produkhukum-form">
            @csrf
            @method('PUT')
            <input type="hidden" name="_token" autocomplete="off">
            <input type="hidden" name="id" value="{{$produkHukum->id}}">
            <div class="card-body border-top p-9">
                <div class="d-flex justify-content-start align-items-center mb-6 bg-light-primary rounded">
                    <div class="me-3">
                        <span data-kt-element="bullet"
                            class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                    </div>
                    <div class="fw-bold fs-4 py-2">
                        Metadata
                        <div class="fw-light fs-7 text-danger">
                            kosongkan input jika tidak digunakan
                        </div>
                    </div>
                </div>
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tipe Dokumen</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select class="form-select min-w-250px" data-control="select2" data-placeholder="Pilih Tipe Dokumen"
                            id="tipe_dokumen_id-form" data-allow-clear="true" name="tipe_dokumen_id">
                            <option value="{{$produkHukum->tipe_dokumen_id}}" selected>{{$produkHukum->tipeDokumen->name}}</option>
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Jenis</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select class="form-select min-w-250px" data-control="select2"
                            data-placeholder="Pilih tipe dokumen terlebih dahulu" id="jenis_dokumen_id-form"
                            data-allow-clear="true" name="jenis_dokumen_id">
                            <option value="{{$produkHukum->jenis_dokumen_id}}" selected>{{$produkHukum->jenisDokumen->name}}</option>
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">OPD</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select class="form-select min-w-250px" data-control="select2" data-placeholder="Pilih OPD"
                            id="opd_id-form" data-allow-clear="true" name="opd_id">
                            <option value="{{$produkHukum->opd_id}}" selected>{{$produkHukum->opd->name}}</option>
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Bidang Hukum </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select class="form-select min-w-250px" data-control="select2" data-placeholder="Pilih Bidang Hukum"
                            id="bid_hukum_id-form" data-allow-clear="true" name="bid_hukum_id">
                            <option value="{{$produkHukum->bid_hukum_id}}" selected>{{$produkHukum->bidangHukum->name}}</option>
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Judul</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <textarea name="judul" class="form-control" id="judul-form" cols="30" rows="3">{{$produkHukum->judul}}</textarea>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tentang</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <textarea name="tentang" class="form-control" id="tentang-form" cols="30" rows="3">{{$produkHukum->tentang}}</textarea>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">T.E.U</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="tajuk_entri_utama" id="tajuk_entri_utama-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="T.E.U" value="{{$produkHukum->tajuk_entri_utama}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Nomor</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="nomor" id="nomor-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Nomor dokumen" value="{{$produkHukum->nomor}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Nomor Panggil</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="no_panggil" id="no_panggil-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Nomor Panggil" value="{{$produkHukum->no_panggil}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Jenis Peradilan</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="jenis_peradilan" id="jenis_peradilan-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Jenis Peradilan"
                            value="{{$produkHukum->jenis_peradilan}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Tahun</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="tahun_diundang" id="tahun_diundang-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Tahun" value="{{$produkHukum->tahun_diundang}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Tempat Terbit</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="tempat_terbit" id="tempat_terbit-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Tempat Terbit" value="{{$produkHukum->tempat_terbit}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Pengarang</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="pengarang" id="pengarang-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Pengarang" value="{{$produkHukum->pengarang}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Pemrakarsa</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="pemrakarsa" id="pemrakarsa-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Pemrakarsa" value="{{$produkHukum->pemrakarsa}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Penandatangan</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="penandatangan" id="penandatangan-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Penandatangan" value="{{$produkHukum->penandatangan}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Hasil Uji Materi</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <textarea name="hasil_uji_materi" class="form-control" id="hasil_uji_materi-form" cols="30" rows="3">{{$produkHukum->hasil_uji_materi}}</textarea>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tanggal Ditetapkan</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input name="tgl_ditetap" id="tgl_ditetap-form"
                            class="form-control form-control-lg mb-3 mb-lg-0 date-pick" placeholder="Tanggal Ditetapkan"
                            value="{{$produkHukum->tgl_ditetap}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tanggal Diundang</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input name="tgl_diundang" id="tgl_diundang-form"
                            class="form-control form-control-lg mb-3 mb-lg-0 date-pick" placeholder="Tanggal Diundang"
                            value="{{$produkHukum->tgl_diundang}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Abstrak <span
                            class="text-danger fs-7">(pdf)</span></label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="file" name="abstrak" id="abstrak-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Abstrak" value="">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Penerbit</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="penerbit" id="penerbit-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Penerbit" value="{{$produkHukum->penerbit}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Sumber</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="sumber" id="sumber-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Sumber" value="{{$produkHukum->sumber}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">ISBN</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="isbn" id="isbn-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="ISBN" value="{{$produkHukum->isbn}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Bahasa</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select class="form-select min-w-250px" data-control="select2" data-placeholder="Pilih Bahasa"
                            id="bahasa_id-form" data-allow-clear="true" name="bahasa_id">
                            <option value="{{$produkHukum->bahasa_id}}" {{$produkHukum->bahasa_id ? 'selected' : ''}}>
                                {{$produkHukum->bahasa_id ? $produkHukum->bahasa->name : 'Pilih Bahasa'}}
                            </option>
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">No Induk Buku</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="no_induk_buku" id="no_induk_buku-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="No Induk Buku" value="{{$produkHukum->no_induk_buku}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Lokasi</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="lokasi" id="lokasi-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Lokasi" value="{{$produkHukum->lokasi}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Deskripsi Fisik</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="deskripsi_fisik" id="deskripsi_fisik-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Deskripsi Fisik"
                            value="{{$produkHukum->deskripsi_fisik}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Status</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select name="status" class="form-control" data-control="select2" id="status-form"
                            data-placeholder="Pilih Status">
                            <option value=""></option>
                            <option value="1" {{$produkHukum->status == 1 ? 'selected' : ''}}>Berlaku</option>
                            <option value="0" {{$produkHukum->status == 0 ? 'selected' : ''}}>Tidak Berlaku</option>
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">File Dokumen <span
                            class="text-danger fs-7">(pdf)</span></label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="file" name="file" id="file-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="File Dokumen" value="">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Author</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="file_author" id="file_author-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Author" value="{{$produkHukum->file_author}}">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Keterangan Status</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row h-100">
                        <div id="file_custom_status-form">
                            <input type="hidden" name="file_custom_status" id="file_custom_status">
                            {!! $produkHukum->file_custom_status !!}
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">File Cover <span
                            class="text-danger fs-7">(webp,png,jpg)</span></label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input type="file" name="file_cover" id="file_cover-form"
                            class="form-control form-control-lg mb-3 mb-lg-0" placeholder="File Cover" value="">
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Subjek</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <input class="form-control form-control-lg mb-3 mb-lg-0" value="{{$produkHukum->subjek}}" name="subjek"
                            id="subjek-form" placeholder="gunakan enter atau koma(,) untuk menambah subjek lain" />
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Publish</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <select name="publish" class="form-control" data-control="select2" id="publish-form"
                            data-placeholder="Pilih Publish">
                            <option value="1" {{$produkHukum->publish == 1 ? 'selected' : ''}}>Publish</option>
                            <option value="0" {{$produkHukum->publish == 0 ? 'selected' : ''}}>Tidak Publish</option>
                        </select>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <div class="separator separator-dashed my-10"></div>
                <div class="d-flex justify-content-between align-items-center mb-6 bg-light-primary rounded">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="me-3">
                            <span data-kt-element="bullet"
                                class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                        </div>
                        <div class="fw-bold fs-4 py-2">
                            Dokumen Terkait
                            <div class="fw-light fs-7 text-danger">
                                buat dokumen jika dokumen tidak ada
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center pe-3">
                        <button type="button" class="btn btn-sm btn-light btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_scrollable_2"><i class="fas fa-plus"></i>Buat
                            Dokumen Terkait</button>
                    </div>
                </div>

                <div class="">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 gy-3">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th>Dokumen</th>
                                    <th class="text-start">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dokumenterkait-section">
                                @foreach ($produkHukum->produkHukumTerkait as $item)
                                <tr>
                                    <td class="w-75">
                                        <input type="hidden" name="dokumen_terkait_id[]" value="{{$item->id}}">
                                        <select name="dokumen_terkait[]" class="form-control select-dokumenterkait" data-control="select2" data-placeholder="Pilih Dokumen">
                                            <option value="{{ $item->id }}">{{ $item->jenisDokumen->name . ' - ' . $item->judul }}</option>
                                        </select>
                                    </td>
                                    <td class="text-start">
                                        <button type="button" class="btn btn-sm mt-1 btn-icon btn-danger btn-remove-row" title="Hapus Dokumen Terkait">
                                        <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-light btn-primary" id="append-dokumenterkait"><i
                        class="fas fa-plus"></i>Tambah Dokumen
                    Terkait</button>

                <div class="separator separator-dashed my-10"></div>
                <div class="d-flex justify-content-between align-items-center mb-6 bg-light-primary rounded">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="me-3">
                            <span data-kt-element="bullet"
                                class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                        </div>
                        <div class="fw-bold fs-4">
                            Lampiran
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 gy-3">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800">
                                    <th>Lampiran</th>
                                    <th class="text-start">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="lampiran-section">
                                @foreach ($produkHukum->produkHukumLampiran as $item)
                                <tr>
                                    <td class="w-75">
                                        <input type="hidden" name="old_lampiran_id[]" value="{{$item->id}}">
                                        <iframe class="w-100" height="300" src="{{ asset($item->file_lampiran) }}" frameborder="0"></iframe>
                                        <input type="file" name="old_lampiran[]" class="form-control" placeholder="Lampiran">
                                    </td>
                                    <td class="text-start">
                                        <button type="button" class="btn btn-sm mt-1 btn-icon btn-danger btn-remove-row" title="Hapus lampiran">
                                        <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-light btn-primary" id="append-lampiran"><i
                        class="fas fa-plus"></i>Tambah Lampiran
                </button>
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-submit">Simpan</button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <div class="modal fade" tabindex="-1" id="kt_modal_scrollable_2">
        <div class="modal-dialog modal-dialog-scrollable d-flex justify-content-center">
            <form action=""  method="POST" id="dokumenterkait-form-modal">
                @csrf
                <div class="modal-content" style="width: 700px">
                    <div class="modal-header">
                        <h5 class="modal-title">Buat Dokumen Baru</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="card-body border-top p-9">
                            <div class="d-flex justify-content-start align-items-center mb-6 bg-light-primary rounded">
                                <div class="me-3">
                                    <span data-kt-element="bullet"
                                        class="bullet bullet-vertical d-flex align-items-center h-40px bg-primary"></span>
                                </div>
                                <div class="fw-bold fs-4 py-2">
                                    Metadata
                                    <div class="fw-light fs-7 text-danger">
                                        kosongkan input jika tidak digunakan
                                    </div>
                                </div>
                            </div>
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tipe Dokumen</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select class="form-select min-w-250px" data-control="select2" data-placeholder="Pilih Tipe Dokumen"
                                        id="tipe_dokumen_id-form-modal" data-allow-clear="true" name="tipe_dokumen_id">
                                        <option></option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Jenis</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select class="form-select min-w-250px" data-control="select2"
                                        data-placeholder="Pilih tipe dokumen terlebih dahulu" id="jenis_dokumen_id-form-modal"
                                        data-allow-clear="true" name="jenis_dokumen_id">
                                        <option></option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">OPD</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select class="form-select min-w-250px" data-control="select2" data-placeholder="Pilih OPD"
                                        id="opd_id-form-modal" data-allow-clear="true" name="opd_id">
                                        <option></option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Bidang Hukum </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select class="form-select min-w-250px" data-control="select2" data-placeholder="Pilih Bidang Hukum"
                                        id="bid_hukum_id-form-modal" data-allow-clear="true" name="bid_hukum_id">
                                        <option></option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Judul</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <textarea name="judul" class="form-control" id="judul-form-modal" cols="30" rows="3"></textarea>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tentang</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <textarea name="tentang" class="form-control" id="tentang-form-modal" cols="30" rows="3"></textarea>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">T.E.U</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="tajuk_entri_utama" id="tajuk_entri_utama-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="T.E.U" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Nomor</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="nomor" id="nomor-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Nomor dokumen" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Nomor Panggil</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="no_panggil" id="no_panggil-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Nomor Panggil" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Jenis Peradilan</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="jenis_peradilan" id="jenis_peradilan-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Jenis Peradilan"
                                        value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Tahun</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="tahun_diundang" id="tahun_diundang-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Tahun" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Tempat Terbit</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="tempat_terbit" id="tempat_terbit-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Tempat Terbit" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Pengarang</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="pengarang" id="pengarang-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Pengarang" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Pemrakarsa</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="pemrakarsa" id="pemrakarsa-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Pemrakarsa" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Penandatangan</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="penandatangan" id="penandatangan-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Penandatangan" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Hasil Uji Materi</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <textarea name="hasil_uji_materi" class="form-control" id="hasil_uji_materi-form-modal" cols="30" rows="3"></textarea    tarea>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tanggal Ditetapkan</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input name="tgl_ditetap" id="tgl_ditetap-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0 date-pick" placeholder="Tanggal Ditetapkan"
                                        value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tanggal Diundang</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input name="tgl_diundang" id="tgl_diundang-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0 date-pick" placeholder="Tanggal Diundang"
                                        value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Abstrak <span
                                        class="text-danger fs-7">(pdf)</span></label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="file" name="abstrak" id="abstrak-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Abstrak" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Penerbit</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="penerbit" id="penerbit-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Penerbit" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Sumber</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="sumber" id="sumber-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Sumber" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">ISBN</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="isbn" id="isbn-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="ISBN" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Bahasa</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select class="form-select min-w-250px" data-control="select2" data-placeholder="Pilih Bahasa"
                                        id="bahasa_id-form-modal" data-allow-clear="true" name="bahasa_id">
                                        <option></option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">No Induk Buku</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="no_induk_buku" id="no_induk_buku-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="No Induk Buku" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Lokasi</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="lokasi" id="lokasi-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Lokasi" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Deskripsi Fisik</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="deskripsi_fisik" id="deskripsi_fisik-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Deskripsi Fisik"
                                        value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Status</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="status" class="form-control" data-control="select2" id="status-form-modal"
                                        data-placeholder="Pilih Status">
                                        <option value=""></option>
                                        <option value="1">Berlaku</option>
                                        <option value="0">Tidak Berlaku</option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">File Dokumen <span
                                        class="text-danger fs-7">(pdf)</span></label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="file" name="file" id="file-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="File Dokumen" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Author</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="file_author" id="file_author-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="Author" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Keterangan Status</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row h-100">
                                    <div id="file_custom_status-form-modal">
                                        <input type="hidden" name="file_custom_status" id="file_custom_status-form-modal">
                                    </div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">File Cover <span
                                        class="text-danger fs-7">(webp,png,jpg)</span></label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input type="file" name="file_cover" id="file_cover-form-modal"
                                        class="form-control form-control-lg mb-3 mb-lg-0" placeholder="File Cover" value="">
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Subjek</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <input class="form-control form-control-lg mb-3 mb-lg-0" value="" name="subjek"
                                        id="subjek-form-modal" placeholder="gunakan enter atau koma(,) untuk menambah subjek lain"
                                        autocomplete="off" />
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Publish</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="publish" class="form-control" data-control="select2" id="publish-form-modal"
                                        data-placeholder="Pilih Publish">
                                        <option value="1">Publish</option>
                                        <option value="0">Tidak Publish</option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-submit-modal">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            initSelect2('{{ route('master-produk-hukum.selectProdukHukum') }}', '.select-dokumenterkait');
            $('#append-dokumenterkait').on('click', function() {
                // Clone the existing row
                const newRow = `
                    <tr>
                        <td class="w-75">
                            <select name="dokumen_terkait[]" class="form-control select-dokumenterkait" data-control="select2" data-placeholder="Pilih Dokumen">
                                <option></option>
                            </select>
                        </td>
                        <td class="text-start">
                            <button type="button" class="btn btn-sm mt-1 btn-icon btn-danger btn-remove-row" title="Hapus Dokumen Terkait">
                            <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                // Append the new row to the tbody
                $('#dokumenterkait-section').append(newRow);

                // Reinitialize Select2 for dynamically added elements if needed
                initSelect2('{{ route('master-produk-hukum.selectProdukHukum') }}', '.select-dokumenterkait');
            });
            $('#append-dokumenterkait-form-modal').on('click', function() {
                // Clone the existing row
                const newRow = `
                    <tr>
                        <td class="w-75">
                            <select name="dokumen_terkait[]" class="form-control select-dokumenterkait" data-control="select2" data-placeholder="Pilih Dokumen">
                                <option></option>
                            </select>
                        </td>
                        <td class="text-start">
                            <button type="button" class="btn btn-sm mt-1 btn-icon btn-danger btn-remove-row" title="Hapus Dokumen Terkait">
                            <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                // Append the new row to the tbody
                $('#dokumenterkait-section-form-modal').append(newRow);

                // Reinitialize Select2 for dynamically added elements if needed
                initSelect2('{{ route('master-produk-hukum.selectProdukHukum') }}', '.select-dokumenterkait');
            });
            $('#append-lampiran').on('click', function() {
                // Clone the existing row
                const newRow = `
                    <tr>
                        <td class="w-75">
                        <input type="file" name="lampiran[]" class="form-control" placeholder="Lampiran">
                        </td>
                        <td class="text-start">
                            <button type="button" class="btn btn-sm mt-1 btn-icon btn-danger btn-remove-row" title="Hapus lampiran">
                            <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                // Append the new row to the tbody
                $('#lampiran-section').append(newRow);
            });
            $('#append-lampiran-form-modal').on('click', function() {
                // Clone the existing row
                const newRow = `
                    <tr>
                        <td class="w-75">
                        <input type="file" name="lampiran[]" class="form-control" placeholder="Lampiran">
                        </td>
                        <td class="text-start">
                            <button type="button" class="btn btn-sm mt-1 btn-icon btn-danger btn-remove-row" title="Hapus lampiran">
                            <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                // Append the new row to the tbody
                $('#lampiran-section-form-modal').append(newRow);
            });

            // Add event listener to remove row on click
            $(document).on('click', '.btn-remove-row', function() {
                $(this).closest('tr').remove();
            });

            var quill = new Quill('#file_custom_status-form', {
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline', 'link'],
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }, {
                            'list': 'check'
                        }],
                        ['clean']
                    ]
                },
                placeholder: 'Type your text here...',
                theme: 'snow' // or 'bubble'
            });

            var quill = new Quill('#file_custom_status-form-modal', {
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline', 'link'],
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }, {
                            'list': 'check'
                        }],
                        ['clean']
                    ]
                },
                placeholder: 'Type your text here...',
                theme: 'snow' // or 'bubble'
            });

            var subjekForm = document.querySelector("#subjek-form");
            var subjek = new Tagify(subjekForm, {
                whitelist: ['css', 'html', 'javascript'],
                dropdown: {
                    classname: "color-blue",
                    enabled: 0,
                    maxItems: 5
                }
            });

            var subjekFormModal = document.querySelector("#subjek-form-modal");
            var subjekModal = new Tagify(subjekFormModal, {
                whitelist: ['css', 'html', 'javascript'],
                dropdown: {
                    classname: "color-blue",
                    enabled: 0,
                    maxItems: 5
                }
            });

            $(".date-pick").flatpickr();

            initSelect2('{{ route('master-tipe-dokumen.tipeDokumenSelect') }}', '#tipe_dokumen_id-form');
            initSelect2('{{ route('master-bidang-hukum.bidHukumSelect') }}', '#bid_hukum_id-form');
            initSelect2('{{ route('master-opd.opdSelect') }}', '#opd_id-form');
            initSelect2('{{ route('master-bahasa.bahasaSelect') }}', '#bahasa_id-form');

            initSelect2('{{ route('master-tipe-dokumen.tipeDokumenSelect') }}', '#tipe_dokumen_id-form-modal');
            initSelect2('{{ route('master-bidang-hukum.bidHukumSelect') }}', '#bid_hukum_id-form-modal');
            initSelect2('{{ route('master-opd.opdSelect') }}', '#opd_id-form-modal');
            initSelect2('{{ route('master-bahasa.bahasaSelect') }}', '#bahasa_id-form-modal');

            $('#tipe_dokumen_id-form').on('change', function() {
                var tipeDokumenId = $(this).val();
                if (tipeDokumenId) {
                    $('#jenis_dokumen_id-form').prop('disabled', false);
                    initSelect2('{{ route('master-jenis-dokumen.jenisDokumenSelect') }}', '#jenis_dokumen_id-form', tipeDokumenId);
                } else {
                    $('#jenis_dokumen_id-form').prop('disabled', true);
                    $('#jenis_dokumen_id-form').empty();
                    $('#jenis_dokumen_id-form').append('<option></option>');
                }
            });

            $('#tipe_dokumen_id-form-modal').on('change', function() {
                var tipeDokumenId = $(this).val();
                if (tipeDokumenId) {
                    $('#jenis_dokumen_id-form-modal').prop('disabled', false);
                    initSelect2('{{ route('master-jenis-dokumen.jenisDokumenSelect') }}', '#jenis_dokumen_id-form-modal', tipeDokumenId);
                } else {
                    $('#jenis_dokumen_id-form-modal').prop('disabled', true);
                    $('#jenis_dokumen_id-form-modal').empty();
                    $('#jenis_dokumen_id-form-modal').append('<option></option>');
                }
            });

            if ($('#tipe_dokumen_id-form').val()) {
                $('#jenis_dokumen_id-form').prop('disabled', false);
                initSelect2('{{ route('master-jenis-dokumen.jenisDokumenSelect') }}', '#jenis_dokumen_id-form', $('#tipe_dokumen_id-form').val());
            } else {
                $('#jenis_dokumen_id-form').prop('disabled', true);
                $('#jenis_dokumen_id-form').empty();
                $('#jenis_dokumen_id-form').append('<option></option>');
            }

            // Initially disable the jenis_dokumen_id select

            $('#tahun-form').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $('#tahun-form-modal').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            function resetErrors() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            }

            function setErrors(errors) {

                resetErrors();
                $.each(errors, function(index, value) {
                    $("#" + index + "-form").addClass('is-invalid');
                    $("#" + index + "-form").after(`<div class="invalid-feedback">` + value + `</div>`);
                });

                Swal.fire({
                    title: "Error!",
                    text: "Terdapat kesalahan dalam pengisian form",
                    icon: "error"
                });
            }

            $('#btn-submit').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data?',
                    text: "Data akan tersimpan ke dalam database",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan data',
                            text: 'Silahkan tunggu...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                        });
                        Swal.showLoading();
                        // Retrieve the form element
                        var form = $('#produkhukum-form')[0];
                        var formData = new FormData(form);
                        formData.append('_token', '{{ csrf_token() }}');
                        // Get the content from the Quill editor
                        var quillContent = quill.root.innerHTML.trim(); // Trim whitespace

                        // Check if Quill editor content is effectively empty and set as null
                        if (quillContent === '<p><br></p>') {
                            quillContent = null; // Treat Quill's empty state as null
                        }

                        // Append the Quill content to FormData
                        formData.append('file_custom_status', quillContent);

                        $.ajax({
                            url: `{{ route('master-produk-hukum.update', ':id') }}`.replace(':id', $('input[name="id"]').val()),
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                Swal.close();

                                if (response.status == 'error') {
                                    setErrors(response.pesan);
                                    return;
                                }

                                Swal.fire({
                                    title: "Success!",
                                    text: "Berhasil Menyimpan Data",
                                    icon: "success"
                                }).then(function() {
                                    window.location =
                                        '{{ route('master-produk-hukum.index') }}';
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Gagal Menyimpan Data",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });

            $('#btn-submit-modal').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah anda yakin ingin menyimpan data?',
                    text: "Data akan tersimpan ke dalam database",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan data',
                            text: 'Silahkan tunggu...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                        });
                        Swal.showLoading();
                        // Retrieve the form element
                        var form = $('#dokumenterkait-form-modal')[0];
                        var formData = new FormData(form);
                        formData.append('_token', '{{ csrf_token() }}');
                        // Get the content from the Quill editor
                        var quillContent = quill.root.innerHTML.trim(); // Trim whitespace

                        // Check if Quill editor content is effectively empty and set as null
                        if (quillContent === '<p><br></p>') {
                            quillContent = null; // Treat Quill's empty state as null
                        }

                        // Append the Quill content to FormData
                        formData.append('file_custom_status', quillContent);

                        $.ajax({
                            url: '{{ route('master-produk-hukum.store') }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                Swal.close();

                                if (response.status == 'error') {
                                    setErrors(response.pesan);
                                    return;
                                }

                                Swal.fire({
                                    title: "Success!",
                                    text: "Berhasil Menyimpan Data",
                                    icon: "success"
                                }).then(function() {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Gagal Menyimpan Data",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
