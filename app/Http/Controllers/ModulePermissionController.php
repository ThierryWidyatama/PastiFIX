<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ModulePermission;
use Illuminate\Support\Facades\DB;

class ModulePermissionController extends Controller
{
    protected $title;
    protected $subtitle;

    public function __construct(Request $request)
    {
        $this->title = 'Module Permission';
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
        if (!isAccess('list', get_module_id('module-permission'), auth()->user()->role_id)) {
            insert_log('Mencoba akses ' . $this->subtitle . ' namun tidak punya akses ' . $this->subtitle, null);
            abort(404);
        }

        if (!isPermission(request()->segment(1), auth()->user()->role_id)) {
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
        return view('admin.module-permission.index');
    }

    public function show($id)
    {
        $title = 'Hak Akses';
        $subtitle = 'Hak Akses';
        $data = Role::find($id);
        return view('admin.module-permission.show', compact('title', 'subtitle', 'data'));
    }

    public function data(Request $request){
        $query = Role::query();
        $privilege = $query->get();
        if (!$privilege->isEmpty()) {
            $id_module = get_module_id('module-permission');
            foreach ($privilege as $item) {
                $actionButtons = '';

                // Tombol Edit
                if (isAccess('update', $id_module, auth()->user()->roles)) {
                    $actionButtons .= '<button type="button" onclick="location.href=' . "'" . route('module-permission.edit', $item->id) . "'" . ';" class="btn btn-icon btn-warning btn-sm" title="Edit Data"><i class="ki-outline ki-pencil fs-2"></i></button> ';
                }

                // Tombol Roles Hak Akses
                if (isAccess('roles', $id_module, auth()->user()->roles)) {
                    $actionButtons .= '<button type="button" onclick="location.href=' . "'" . route('module-permission.roles', $item->id) . "'" . ';" class="btn btn-icon btn-primary btn-sm" title="Roles Hak Akses"><i class="fa-solid fa-users"></i></button> ';
                }

                // Tombol Detail Data
                $actionButtons .= '<button type="button" onclick="location.href=' . "'" . route('module-permission.show', $item->id) . "'" . ';" class="btn btn-icon btn-info btn-sm" title="Detail Data"><i class="fa fa-eye"></i></button> ';

                // Tombol Hapus Data
                if (isAccess('delete', $id_module, auth()->user()->roles)) {
                    $actionButtons .= '<button href="#hapus" data-id="' . $item->id . '" data-nama="' . $item->name . '" class="btn btn-icon btn-danger btn-sm btn-hapus" title="Hapus Data"><i class="fas fa-trash"></i></button>';
                }

                $item->action = $actionButtons;
            }

        }

        return response()->json([
            'status' => true,
            'data' => $privilege
        ]);
    }

    public function create()
    {
        $title = 'Hak Akses';
        $subtitle = 'Hak Akses';
        return view('admin.module-permission.create', compact('title', 'subtitle'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'code' => 'required',
            ], [
                'name.required' => 'Kolom Nama Tidak Boleh Kosong',
                'code.required' => 'Kolom Kode Tidak Boleh Kosong',
            ]);
            $data = Role::create([
                'id' => Str::uuid(),
                'name' => $request->name,
                'code' => $request->code,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }

    public function edit($id)
    {
        $title = 'Hak Akses';
        $subtitle = 'Hak Akses';
        $data = Role::find($id);
        return view('admin.module-permission.edit', compact('title', 'subtitle', 'data'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'code' => 'required',
            ], [
                'name.required' => 'Kolom Nama Tidak Boleh Kosong',
                'code.required' => 'Kolom Kode Tidak Boleh Kosong',
            ]);
            $data = Role::find($request->id);
            $data->update([
                'name' => $request->name,
                'code' => $request->code,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $data = Role::find($id);
            $data->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus Data Berhasil'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e
            ], 500);
        }
    }

    public function roles($id)
    {
        $title = 'Hak Akses';
        $subtitle = 'Hak Akses';
        $role = new ModulePermission();
        $datas = Role::select(['id', 'name', 'code', 'created_at', 'updated_at'])->get();

        $modules = Module::where('parent_id', '0')->orderby('order', 'ASC')->get();

        $priv_modules = Module::
        leftJoin('ms_module as m2', 'm2.id', '=', 'ms_module.parent_id')
        ->select('ms_module.*', 'm2.name as parent_name')
        ->orderby('m2.name', 'ASC')->get();
        // Retrieve the selected data
        $selectedData = Role::find($id);

        // Assign the selected data to the $data variable
        $data = (object) [
            'id_usergroup' => $selectedData->id,
            'name_usergroup' => $selectedData->name,
            // Assign other properties here
        ];
        return view('admin.module-permission.role', compact('data', 'priv_modules', 'datas', 'role', 'modules', 'title', 'subtitle'));
    }

    public function roles_store(Request $request)
    {
        $userGroupModule = $request->input('user_groupmodule');
        $access = $request->input('kt_roles_checkbox');
        $status = $request->input('status');

        // Get all current permissions for the given user group module
        $existingPermissions = ModulePermission::where('role_id', $userGroupModule)->get();
        $existingModuleIds = $existingPermissions->pluck('module_id')->toArray();

        // Get the module IDs from the status array in the request
        $statusModuleIds = array_keys($status);

        // Find the module IDs that are in the database but not in the status array
        $modulesToDelete = array_diff($existingModuleIds, $statusModuleIds);

        // Delete these module permissions
        ModulePermission::where('role_id', $userGroupModule)
            ->whereIn('module_id', $modulesToDelete)
            ->delete();

        // Loop through the provided status data to update or create new entries
        foreach ($status as $id_mdl => $publishStatus) {
            // Check if actions are provided for this module ID
            $actions = $access[$id_mdl] ?? null;
            $actionString = $actions ? implode(',', $actions) : null;

            // Find or create the ModulePermission record
            $data = ModulePermission::firstOrNew(['role_id' => $userGroupModule, 'module_id' => $id_mdl]);
            $data->module_id = $id_mdl;
            $data->role_id = $userGroupModule;
            $data->action = $actionString;
            $data->publish = $publishStatus; // Use the status from the request
            $data->save();
        }

        return response()->json(['status' => true]);
    }

}
