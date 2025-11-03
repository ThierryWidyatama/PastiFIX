<?php

namespace App\Http\Controllers;

use App\Models\ProdukHukum;
use Illuminate\Support\Str;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProdukHukumController extends Controller
{
    protected $title;
    protected $subtitle;

    public function __construct(Request $request)
    {
        $this->title = 'Produk Hukum';
        $action = $request->route()->getActionMethod();

        switch ($action) {
            case 'create':
                $this->subtitle = $this->title . ' / Tambah';
                break;
            case 'show':
                $this->subtitle = $this->title . ' / Detail';
                break;
            case 'edit':
                $this->subtitle = $this->title . ' / Edit';
                break;
            case 'list':
                $this->subtitle = $this->title . ' / List';
                break;
            default:
                $this->subtitle = $this->title . '';
                break;
        }

        view()->share([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
        ]);
    }

    public function index()
    {
        return view('admin.master-produk-hukum.index');
    }

    public function data(Request $request)
    {
        $produkHukum = ProdukHukum::query();
        if ($request->filled('nomor_filter')) {
            $produkHukum->where('nomor', 'like', '%' . $request->nomor_filter . '%');
        }
        if ($request->filled('jenis_dokumen')) {
            $produkHukum->where('jenis_dokumen_id', $request->jenis_dokumen);
        }
        if ($request->filled('tahun')) {
            $produkHukum->where('tahun_diundang', $request->tahun);
        }
        $produkHukum = $produkHukum->get();

        $formattedData = $produkHukum->map(function ($item) {
            if ($item->jenisDokumen == null) {
                $jenisDokumen = 'Jenis Dokumen tidak ditemukan';
            } else {
                $jenisDokumen = $item->jenisDokumen->name;
            }
            $buttonHtml =
                '<a href="' . route('master-produk-hukum.index', $item->id) . '" class="btn btn-icon btn-info btn-sm mx-1" title="Edit Data"><i class="ki-outline ki-book fs-2"></i></a>'
                . '<a href="' . route('master-produk-hukum.edit', $item->id) . '" class="btn btn-icon btn-warning btn-sm mx-1" title="Edit Data"><i class="ki-outline ki-pencil fs-2"></i></a>'
                . '<a href="' . route('master-produk-hukum.show', $item->id) . '" class="btn btn-icon btn-primary btn-sm mx-1" title="Detail Data"><i class="fas fa-eye"></i></a>'
                . '<button type="button" data-id="' . $item->id . '" data-nama="' . $item->judul . '" class="btn btn-icon btn-danger btn-sm mx-1 btn-hapus" title="Hapus Data"><i class="fas fa-trash"></i></button>';

            return [
                'id' => $item->id,
                'jenisDokumen' => $jenisDokumen,
                'nomor' => $item->nomor,
                'tahun_diundang' => $item->tahun_diundang ?? '-',
                'judul' => $item->judul,
                'created_at' => $item->created_at_human,
                'publish' => $item->publish == 1 ? '<span class="badge badge-success">Publish</span>' : '<span class="badge badge-danger">Tidak</span>',
                'action' => $buttonHtml
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $formattedData
        ]);
    }

    public function create()
    {
        return view('admin.master-produk-hukum.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipe_dokumen_id' => 'required',
            'jenis_dokumen_id' => 'required',
            'opd_id' => 'required',
            'bid_hukum_id' => 'required',
            'judul' => 'required',
            'tentang' => 'required',
            'tajuk_entri_utama' => 'required',
            'abstrak' => 'nullable|mimes:pdf',
            'file' => 'nullable|mimes:pdf',
            'file_cover' => 'nullable|mimes:webp,png,jpg,jpeg',
            'status' => 'required',
            'tgl_ditetap' => 'required',
            'tgl_diundang' => 'required',
            'publish' => 'required',
        ], [
            'tipe_dokumen_id.required' => 'Tipe Dokumen harus diisi',
            'jenis_dokumen_id.required' => 'Jenis Dokumen harus diisi',
            'opd_id.required' => 'OPD harus diisi',
            'bid_hukum_id.required' => 'Bidang Hukum harus diisi',
            'judul.required' => 'Judul harus diisi',
            'tentang.required' => 'Tentang harus diisi',
            'tajuk_entri_utama.required' => 'T.E.U harus diisi',
            'tgl_ditetap.required' => 'Tanggal Ditetap harus diisi',
            'tgl_diundang.required' => 'Tanggal Diundang harus diisi',
            'status.required' => 'Status harus diisi',
            'abstrak.mimes' => 'Abstrak harus berupa file PDF',
            'file.mimes' => 'File harus berupa file PDF',
            'file_cover.mimes' => 'File cover harus berupa file dengan format webp, png, jpg, atau jpeg',
            'publish.required' => 'Publish harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'pesan' => $validator->errors()]);
        }

        DB::beginTransaction();

        try {
            $jenis = JenisDokumen::find($request->jenis_dokumen_id);

            $produkHukum = new ProdukHukum();
            $produkHukum->id = Str::uuid();
            $produkHukum->tipe_dokumen_id = $request->tipe_dokumen_id;
            $produkHukum->jenis_dokumen_id = $request->jenis_dokumen_id;
            $produkHukum->opd_id = $request->opd_id;
            $produkHukum->bid_hukum_id = $request->bid_hukum_id;
            $produkHukum->judul = $request->judul;
            $produkHukum->tentang = $request->tentang;
            $produkHukum->tajuk_entri_utama = $request->tajuk_entri_utama;
            $produkHukum->nomor = $request->nomor;
            $produkHukum->no_panggil = $request->no_panggil;
            $produkHukum->jenis_peradilan = $request->jenis_peradilan;
            $produkHukum->tahun_diundang = $request->tahun_diundang;
            $produkHukum->tempat_terbit = $request->tempat_terbit;
            $produkHukum->pengarang = $request->pengarang;
            $produkHukum->pemrakarsa = $request->pemrakarsa;
            $produkHukum->penandatangan = $request->penandatangan;
            $produkHukum->hasil_uji_materi = $request->hasil_uji_materi;
            $produkHukum->tgl_ditetap = $request->tgl_ditetap;
            $produkHukum->tgl_diundang = $request->tgl_diundang;
            $produkHukum->penerbit = $request->penerbit;
            $produkHukum->sumber = $request->sumber;
            $produkHukum->isbn = $request->isbn;
            $produkHukum->bahasa_id = $request->bahasa_id;
            $produkHukum->no_induk_buku = $request->no_induk_buku;
            $produkHukum->lokasi = $request->lokasi;
            $produkHukum->deskripsi_fisik = $request->deskripsi_fisik;
            $produkHukum->status = $request->status;
            $produkHukum->file_author = $request->file_author;
            $produkHukum->subjek = $request->subjek;
            $produkHukum->publish = $request->publish;
            $produkHukum->file_custom_status = $request->file_custom_status == 'null' ? null : $request->file_custom_status;
            if ($request->hasFile('abstrak')) {
                $file_abstrak = $request->file('abstrak');
                $filename_abstrak = md5($file_abstrak->getClientOriginalName() . time()) . '.' . $file_abstrak->getClientOriginalExtension();
                $file_abstrak->move(public_path('produk-hukum/abstrak'), $filename_abstrak);
                $produkHukum->abstrak = 'produk-hukum/abstrak/' . $filename_abstrak;
            }

            if ($request->hasFile('file')) {
                $file_file = $request->file('file');
                $filename_file = md5($file_file->getClientOriginalName() . time()) . '.' . $file_file->getClientOriginalExtension();
                $file_file->move(public_path('produk-hukum/file'), $filename_file);
                $produkHukum->file = 'produk-hukum/file/' . $filename_file;
            }

            if ($request->hasFile('file_cover')) {
                $file_cover = $request->file('file_cover');
                $filename_cover = md5($file_cover->getClientOriginalName() . time()) . '.' . $file_cover->getClientOriginalExtension();
                $file_cover->move(public_path('produk-hukum/file_cover'), $filename_cover);
                $produkHukum->file_cover = 'produk-hukum/file_cover/' . $filename_cover;
            }

            $produkHukum->save();

            if (isset($request->dokumen_terkait) && !is_null($request->dokumen_terkait) && $request->dokumen_terkait !== null) {
                foreach ($request->dokumen_terkait as $key => $value) {
                    $createDokumenTerkait = DB::table('ms_dokumen_terkait')->insert([
                        'id' => Str::uuid(),
                        'dokumen_id' => $produkHukum->id,
                        'dokumen_terkait_id' => $value,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }

            // Get existing lampiran IDs from DB
    $existingLampiranIds = DB::table('ms_dokumen_lampiran')
        ->where('dokumen_id', $produkHukum->id)
        ->pluck('id')
        ->toArray();

    // Get old lampiran IDs from request
    $oldLampiranIds = $request->old_lampiran_id ?? [];

    // Find IDs to delete (exist in DB but not in request)
    $idsToDelete = array_diff($existingLampiranIds, $oldLampiranIds);

    // Delete removed lampiran from storage and database
    if (!empty($idsToDelete)) {
        $lampiranToDelete = DB::table('ms_dokumen_lampiran')
            ->whereIn('id', $idsToDelete)
            ->get();

        foreach ($lampiranToDelete as $lampiran) {
            $filePath = public_path($lampiran->file_lampiran);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        DB::table('ms_dokumen_lampiran')->whereIn('id', $idsToDelete)->delete();
    }

    // Update old lampiran if new file is uploaded
    if ($request->old_lampiran) {
        foreach ($request->old_lampiran as $key => $lampiran) {
            if ($lampiran) { // Check if a new file is uploaded
                if ($lampiran->getClientOriginalExtension() !== 'pdf') {
                    return response()->json(['status' => 'error', 'message' => 'Jenis file yang diijinkan hanya pdf'], 400);
                }

                $file_name = uniqid('lampiran_', true) . '.' . $lampiran->getClientOriginalExtension();
                $destinationPath = public_path() . "/produk_hukum/" . $jenis->singkatan . "/lampiran/";

                if (!file_exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }

                $lampiran->move($destinationPath, $file_name);
                $filePath = "produk_hukum/" . $jenis->singkatan . "/lampiran/" . $file_name;

                // Get the existing file to delete
                $oldFile = DB::table('ms_dokumen_lampiran')->where('id', $request->old_lampiran_id[$key])->first();
                if ($oldFile) {
                    $oldFilePath = public_path($oldFile->file_lampiran);
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }

                // Update the file path in the database
                DB::table('ms_dokumen_lampiran')
                    ->where('id', $request->old_lampiran_id[$key])
                    ->update(['file_lampiran' => $filePath]);
            }
        }
    }

    // Insert new lampiran
    if ($request->lampiran) {
        foreach ($request->lampiran as $lampiran) {
            if ($lampiran->getClientOriginalExtension() !== 'pdf') {
                return response()->json(['status' => 'error', 'message' => 'Jenis file yang diijinkan hanya pdf'], 400);
            }

            $file_name = uniqid('lampiran_', true) . '.' . $lampiran->getClientOriginalExtension();
            $destinationPath = public_path() . "/produk_hukum/" . $jenis->singkatan . "/lampiran/";

            if (!file_exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $lampiran->move($destinationPath, $file_name);
            $filePath = "produk_hukum/" . $jenis->singkatan . "/lampiran/" . $file_name;

            DB::table('ms_dokumen_lampiran')->insert([
                'id' => Str::uuid(),
                'dokumen_id' => $produkHukum->id,
                'file_lampiran' => $filePath,
                'status' => '1',
            ]);
        }
    }

            DB::commit();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error storing Produk Hukum: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'pesan' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $produkHukum = ProdukHukum::find($id);
        return view('admin.master-produk-hukum.show', compact('produkHukum'));
    }

    public function edit($id)
    {
        $produkHukum = ProdukHukum::with(['jenisDokumen', 'produkHukumTerkait'])->find($id);
        return view('admin.master-produk-hukum.edit', compact('produkHukum'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tipe_dokumen_id' => 'required',
            'jenis_dokumen_id' => 'required',
            'opd_id' => 'required',
            'bid_hukum_id' => 'required',
            'judul' => 'required',
            'tentang' => 'required',
            'tajuk_entri_utama' => 'required',
            'abstrak' => 'nullable|mimes:pdf',
            'file' => 'nullable|mimes:pdf',
            'file_cover' => 'nullable|mimes:webp,png,jpg,jpeg',
            'status' => 'required',
            'tgl_ditetap' => 'required',
            'tgl_diundang' => 'required',
            'publish' => 'required',
        ], [
            'tipe_dokumen_id.required' => 'Tipe Dokumen harus diisi',
            'jenis_dokumen_id.required' => 'Jenis Dokumen harus diisi',
            'opd_id.required' => 'OPD harus diisi',
            'bid_hukum_id.required' => 'Bidang Hukum harus diisi',
            'judul.required' => 'Judul harus diisi',
            'tentang.required' => 'Tentang harus diisi',
            'tajuk_entri_utama.required' => 'T.E.U harus diisi',
            'tgl_ditetap.required' => 'Tanggal Ditetap harus diisi',
            'tgl_diundang.required' => 'Tanggal Diundang harus diisi',
            'status.required' => 'Status harus diisi',
            'abstrak.mimes' => 'Abstrak harus berupa file PDF',
            'file.mimes' => 'File harus berupa file PDF',
            'file_cover.mimes' => 'File cover harus berupa file dengan format webp, png, jpg, atau jpeg',
            'publish.required' => 'Publish harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'pesan' => $validator->errors()]);
        }

        DB::beginTransaction();

        try {

            $jenis = JenisDokumen::find($request->jenis_dokumen_id);

            $produkHukum = ProdukHukum::find($id);
            $produkHukum->tipe_dokumen_id = $request->tipe_dokumen_id;
            $produkHukum->jenis_dokumen_id = $request->jenis_dokumen_id;
            $produkHukum->opd_id = $request->opd_id;
            $produkHukum->bid_hukum_id = $request->bid_hukum_id;
            $produkHukum->judul = $request->judul;
            $produkHukum->tentang = $request->tentang;
            $produkHukum->tajuk_entri_utama = $request->tajuk_entri_utama;
            $produkHukum->nomor = $request->nomor;
            $produkHukum->no_panggil = $request->no_panggil;
            $produkHukum->jenis_peradilan = $request->jenis_peradilan;
            $produkHukum->tahun_diundang = $request->tahun_diundang;
            $produkHukum->tempat_terbit = $request->tempat_terbit;
            $produkHukum->pengarang = $request->pengarang;
            $produkHukum->pemrakarsa = $request->pemrakarsa;
            $produkHukum->penandatangan = $request->penandatangan;
            $produkHukum->hasil_uji_materi = $request->hasil_uji_materi;
            $produkHukum->tgl_ditetap = $request->tgl_ditetap;
            $produkHukum->tgl_diundang = $request->tgl_diundang;
            $produkHukum->penerbit = $request->penerbit;
            $produkHukum->sumber = $request->sumber;
            $produkHukum->isbn = $request->isbn;
            $produkHukum->bahasa_id = $request->bahasa_id;
            $produkHukum->no_induk_buku = $request->no_induk_buku;
            $produkHukum->lokasi = $request->lokasi;
            $produkHukum->deskripsi_fisik = $request->deskripsi_fisik;
            $produkHukum->status = $request->status;
            $produkHukum->file_author = $request->file_author;
            $produkHukum->subjek = $request->subjek;
            $produkHukum->publish = $request->publish;
            $produkHukum->file_custom_status = $request->file_custom_status == 'null' ? null : $request->file_custom_status;

            if ($request->hasFile('abstrak')) {
                if ($produkHukum->abstrak) {
                    if (file_exists(public_path($produkHukum->abstrak))) {
                        unlink(public_path($produkHukum->abstrak));
                    }
                }
                $file_abstrak = $request->file('abstrak');
                $filename_abstrak = md5($file_abstrak->getClientOriginalName() . time()) . '.' . $file_abstrak->getClientOriginalExtension();
                $file_abstrak->move(public_path('produk-hukum/abstrak'), $filename_abstrak);
                $produkHukum->abstrak = 'produk-hukum/abstrak/' . $filename_abstrak;
            }

            if ($request->hasFile('file')) {
                if ($produkHukum->file) {
                    if (file_exists(public_path($produkHukum->file))) {
                        unlink(public_path($produkHukum->file));
                    }
                }
                $file_file = $request->file('file');
                $filename_file = md5($file_file->getClientOriginalName() . time()) . '.' . $file_file->getClientOriginalExtension();
                $file_file->move(public_path('produk-hukum/file'), $filename_file);
                $produkHukum->file = 'produk-hukum/file/' . $filename_file;
            }

            if ($request->hasFile('file_cover')) {
                if ($produkHukum->file_cover) {
                    if (file_exists(public_path($produkHukum->file_cover))) {
                        unlink(public_path($produkHukum->file_cover));
                    }
                }
                $file_cover = $request->file('file_cover');
                $filename_cover = md5($file_cover->getClientOriginalName() . time()) . '.' . $file_cover->getClientOriginalExtension();
                $file_cover->move(public_path('produk-hukum/file_cover'), $filename_cover);
                $produkHukum->file_cover = 'produk-hukum/file_cover/' . $filename_cover;
            }

            $produkHukum->save();

            // delete all dokumen terkait
            DB::table('ms_dokumen_terkait')->where('dokumen_id', $produkHukum->id)->delete();

            if (isset($request->dokumen_terkait) && !is_null($request->dokumen_terkait) && $request->dokumen_terkait !== null) {
                foreach ($request->dokumen_terkait as $key => $value) {
                    $createDokumenTerkait = DB::table('ms_dokumen_terkait')->insert([
                        'id' => Str::uuid(),
                        'dokumen_id' => $produkHukum->id,
                        'dokumen_terkait_id' => $value,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
            // Get existing lampiran IDs from DB
            $existingLampiranIds = DB::table('ms_dokumen_lampiran')
            ->where('dokumen_id', $produkHukum->id)
            ->pluck('id')
            ->toArray();

            // Get old lampiran IDs from request
            $oldLampiranIds = $request->old_lampiran_id ?? [];

            // Find IDs to delete (exist in DB but not in request)
            $idsToDelete = array_diff($existingLampiranIds, $oldLampiranIds);

            // Delete removed lampiran from storage and database
            if (!empty($idsToDelete)) {
            $lampiranToDelete = DB::table('ms_dokumen_lampiran')
                ->whereIn('id', $idsToDelete)
                ->get();

            foreach ($lampiranToDelete as $lampiran) {
                $filePath = public_path($lampiran->file_lampiran);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            DB::table('ms_dokumen_lampiran')->whereIn('id', $idsToDelete)->delete();
            }

            // Update old lampiran if new file is uploaded
            if ($request->old_lampiran) {
                foreach ($request->old_lampiran as $key => $lampiran) {
                    if ($lampiran) { // Check if a new file is uploaded
                        if ($lampiran->getClientOriginalExtension() !== 'pdf') {
                            return response()->json(['status' => 'error', 'message' => 'Jenis file yang diijinkan hanya pdf'], 400);
                        }

                        $file_name = uniqid('lampiran_', true) . '.' . $lampiran->getClientOriginalExtension();
                        $destinationPath = public_path() . "/produk_hukum/" . $jenis->singkatan . "/lampiran/";

                        if (!file_exists($destinationPath)) {
                            File::makeDirectory($destinationPath, 0777, true, true);
                        }

                        $lampiran->move($destinationPath, $file_name);
                        $filePath = "produk_hukum/" . $jenis->singkatan . "/lampiran/" . $file_name;

                        // Get the existing file to delete
                        $oldFile = DB::table('ms_dokumen_lampiran')->where('id', $request->old_lampiran_id[$key])->first();
                        if ($oldFile) {
                            $oldFilePath = public_path($oldFile->file_lampiran);
                            if (File::exists($oldFilePath)) {
                                File::delete($oldFilePath);
                            }
                        }

                        // Update the file path in the database
                        DB::table('ms_dokumen_lampiran')
                            ->where('id', $request->old_lampiran_id[$key])
                            ->update(['file_lampiran' => $filePath]);
                    }
                }
            }

            // Insert new lampiran
            if ($request->lampiran) {
                foreach ($request->lampiran as $lampiran) {
                    if ($lampiran->getClientOriginalExtension() !== 'pdf') {
                        return response()->json(['status' => 'error', 'message' => 'Jenis file yang diijinkan hanya pdf'], 400);
                    }

                    $file_name = uniqid('lampiran_', true) . '.' . $lampiran->getClientOriginalExtension();
                    $destinationPath = public_path() . "/produk_hukum/" . $jenis->singkatan . "/lampiran/";

                    if (!file_exists($destinationPath)) {
                        File::makeDirectory($destinationPath, 0777, true, true);
                    }

                    $lampiran->move($destinationPath, $file_name);
                    $filePath = "produk_hukum/" . $jenis->singkatan . "/lampiran/" . $file_name;

                    DB::table('ms_dokumen_lampiran')->insert([
                        'id' => Str::uuid(),
                        'dokumen_id' => $produkHukum->id,
                        'file_lampiran' => $filePath,
                        'status' => '1',
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating Produk Hukum: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'pesan' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $produkHukum = ProdukHukum::find($id);

        if ($produkHukum) {
            if ($produkHukum->abstrak) {
                if (file_exists(public_path($produkHukum->abstrak))) {
                    unlink(public_path($produkHukum->abstrak));
                }
            }
            if ($produkHukum->file) {
                if (file_exists(public_path($produkHukum->file))) {
                    unlink(public_path($produkHukum->file));
                }
            }
            if ($produkHukum->file_cover) {
                if (file_exists(public_path($produkHukum->file_cover))) {
                    unlink(public_path($produkHukum->file_cover));
                }
            }

            $produkHukum->delete();
        }

        return response()->json(['status' => true]);
    }

    public function selectProdukHukum(Request $request)
    {
        $searchTerm = $request->input('q');

        $data = ProdukHukum::where('judul', 'like', "%$searchTerm%")
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'text' => $item->jenisDokumen->name . ' - ' . $item->judul, // Customize the name here
                ];
            })
            ->sortBy('text');

            return response()->json(['results' => $data->values()]); // Use `values()` to reset keys
    }

    public function subjekSelect(Request $request)
    {
        $query = $request->input('search', ''); // Get the search query or default to an empty string

        $data = ProdukHukum::pluck('subjek');

        $uniqueSubjek = $data->flatMap(function ($item) {
            return collect(json_decode($item, true))->pluck('value');
        })->unique()->values();

        // Filter results based on the search query (case-insensitive)
        $filtered = $uniqueSubjek->filter(function ($value) use ($query) {
            return str_contains(strtolower($value), strtolower($query));
        });

        return response()->json($filtered->values()); // Return as JSON
    }
}
