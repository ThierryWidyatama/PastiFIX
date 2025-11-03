<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    protected $title;
    protected $subtitle;

    public function __construct(Request $request)
    {
        $this->title = 'Pengaturan Website';
        $action = $request->route()->getActionMethod();

        switch ($action) {
            case 'create':
                $this->subtitle = $this->title . ' / Tambah';
                break;
            case 'show':
                $this->subtitle = $this->title . ' / Show';
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
        // function insert_log($activity,$ref_id = null,$json = null)
        if (!isAccess('list', get_module_id('option'), auth()->user()->role_id)) {
            insert_log('Mencoba akses ' . $this->subtitle . ' namun tidak punya akses ' . $this->subtitle, null);
            abort(404);
        }

        insert_log('Mengakses halaman ' . $this->subtitle);

        view()->share([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
        ]);
    }

    public function index()
    {
        $option = Option::first();
        return view('admin.option.index' , compact('option'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'phone' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'logo_dark' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,ico|max:2048',
        ], [
            'name.required' => 'Nama website wajib diisi',
            'description.required' => 'Deskripsi website wajib diisi',
            'phone.required' => 'Nomor telepon wajib diisi',
            'start_time.required' => 'Waktu mulai wajib diisi',
            'end_time.required' => 'Waktu selesai wajib diisi',
            'logo.mimes' => 'Logo website harus berupa file: jpeg,png,jpg,gif,svg,webp',
            'logo.max' => 'Ukuran file logo website maksimal 2MB',
            'logo_dark.mimes' => 'Logo website dark harus berupa file: jpeg,png,jpg,gif,svg,webp',
            'logo_dark.max' => 'Ukuran file logo website dark maksimal 2MB',
            'favicon.mimes' => 'Favicon website harus berupa file: jpeg,png,jpg,gif,svg,webp,ico',
            'favicon.max' => 'Ukuran file favicon website maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'pesan' => $validator->errors()]);
        }

        DB::beginTransaction();
        $option = Option::find($id);
        try {
            $option->name = $request->name;
            $option->description = $request->description;
            $option->is_landing_page = $request->is_landing_page ?? 0;
            $option->phone = $request->phone;
            $option->starthour = $request->start_time;
            $option->endhour = $request->end_time;

            if ($request->hasFile('logo')) {
                if($option->logo != null){
                    $existingLogo = public_path($option->logo);
                    if (file_exists($existingLogo)) {
                        unlink($existingLogo);
                    }
                }

                $file = $request->file('logo');
                $filename = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('master-option'), $filename);
                $option->logo = 'master-option/' . $filename;
            }

            if ($request->hasFile('logo_dark')) {
                if($option->logo_dark != null){
                    $existingLogoDark = public_path($option->logo_dark);
                    if (file_exists($existingLogoDark)) {
                        unlink($existingLogoDark);
                    }
                }

                $file = $request->file('logo_dark');
                $filename = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('master-option'), $filename);
                $option->logo_dark = 'master-option/' . $filename;
            }

            if ($request->hasFile('favicon')) {
                if($option->favicon != null){
                    $existingFavicon = public_path($option->favicon);
                    if (file_exists($existingFavicon)) {
                        unlink($existingFavicon);
                    }
                }

                $file = $request->file('favicon');
                $filename = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('master-option'), $filename);
                $option->favicon = 'master-option/' . $filename;
            }

            $option->save();

            DB::commit();
            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'pesan' => $e->getMessage()]);
        }
    }
}
