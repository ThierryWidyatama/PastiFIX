<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    protected $title;
    protected $subtitle;

    public function __construct(Request $request)
    {
        $this->title = 'Module';
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
        if (!isAccess('list', get_module_id('modules'), auth()->user()->role_id)) {
            insert_log('Mencoba akses ' . $this->subtitle . ' namun tidak punya akses ' . $this->subtitle, null);
            abort(404);
        }

        insert_log('Mengakses halaman ' . $this->subtitle);

        view()->share([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
        ]);
    }
    public function rules($request)
    {
        $rule = [
            'name'        => 'required',
            'code'        => 'required|unique:ms_module,code',
            'link'        => 'required|unique:ms_module,link',
            'icon'        => 'required',
            'order'       => 'required',
            'action'          => '',
        ];

        $pesan = [
            'name.required'        => 'Module Name Wajib Diisi',
            'code.required'        => 'Code Wajib Diisi',
            'code.unique'          => 'Code Sudah Ada',
            'link.required'        => 'Link Wajib Diisi',
            'link.unique'          => 'Link Sudah Ada',
            'icon.required'        => 'Icon Wajib Diisi',
            'order.required'       => 'Order Number Wajib Dipilih',
            'action.required' => 'Aksi Wajib Diisi',
        ];

        return Validator::make($request, $rule, $pesan);
    }
    public function json()
    {
        $datas = Module::select(['id', 'name', 'created_at', 'parent_id', 'link', 'order', 'updated_at']);

        return Datatables::of($datas)
            ->addColumn('action', function ($data) {
                $id_module = get_module_id('privileges');

                //selalu bisa
                $detailButton = '<a class="dropdown-item" href="' . route('modules.show', $data->id) . '">Detail</a>';
                $editButton = "";
                if (isAccess('update', $id_module, Auth::user()->role)) {
                    $editButton = '<button type="button" onclick="location.href=' . "'" . route('modules.edit', $data->id) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
                }
                $deleteButton = "";
                if (isAccess('delete', $id_module, Auth::user()->role)) {
                    $deleteButton = '<a class="dropdown-item btn-delete" href="#hapus" data-id="' . $data->id . '" data-nama="' . $data->name . '">Hapus</a>';
                }
                return '
                <div class="btn-group">
                    ' . $editButton . '
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        ' . $detailButton . '
                        ' . $deleteButton . '
                    </div>
                </div>
              ';
            })
            ->addColumn('module', function ($data) {
                return $data->module->name ?? "Parent";
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('Y/m/d');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->format('Y/m/d');
            })
            ->filterColumn('updated_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(updated_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
            })
            ->addIndexColumn() //increment;

            ->make(true);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = Module::select(['id', 'name', 'created_at', 'parent_id', 'link', 'order', 'updated_at'])->orderBy('order', 'ASC')->get();
        return view('admin.module-admin.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $modules = Module::all();
        return view('admin.module-admin.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = $this->rules($request->all());
        if ($validator->fails()) {
            return response()->json(['status' => false, 'pesan' => $validator->errors()]);
        } else {
            $actions = $request->input('actions', []);
            $actionString = implode(',', $actions);
            $id = Str::uuid();
            $data = new Module;
            $data->id = $id;
            $data->parent_id        = $request->post('parent_id') ?? null;
            $data->code        = $request->post('code');
            $data->name        = $request->post('name');
            $data->link        = $request->post('link');
            $data->icon        = $request->post('icon');
            $data->order       = $request->post('order');
            $data->action      = $actionString . ($request->post('action') ? ',' : '') . $request->post('action');
            $data->description = $request->post('description');
            $data->save();

            return response()->json(['status' => true]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = Module::find($id);
        return view('admin.module-admin.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $modules = Module::all();
        $data = Module::find($id);

        $excludedValues = "create,read,update,delete,list,show";
        $excludedValuesArray = explode(',', $excludedValues);

        $actionModuleArray = explode(',', $data->action);
        $data->action_other = implode(',', array_diff($actionModuleArray, $excludedValuesArray));
        return view('admin.module-admin.edit', compact('data', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $rule = [
            'name'        => 'required',
            'code'        => 'required|unique:ms_module,code,' . $id,
            'link'        => 'required|unique:ms_module,link,' . $id,
            'icon'        => 'required',
            'order'       => 'required',
            'action'          => '',
        ];

        $pesan = [
            'name.required'        => 'Module Name Wajib Diisi',
            'code.required'        => 'Code Wajib Diisi',
            'code.unique'          => 'Code Sudah Ada',
            'link.required'        => 'Link Wajib Diisi',
            'link.unique'          => 'Link Sudah Ada',
            'icon.required'        => 'Icon Wajib Diisi',
            'order.required'       => 'Order Number Wajib Dipilih',
            'action.required' => 'Aksi Wajib Diisi',
        ];

        $validator = Validator::make($request->all(), $rule, $pesan);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'pesan' => $validator->errors()]);
        } else {
            $data = Module::find($id);
            $data->parent_id        = $request->post('parent_id') ?? null;
            $data->code        = $request->post('code');
            $data->name        = $request->post('name');
            $data->link        = $request->post('link');
            $data->icon        = $request->post('icon');
            $data->order       = $request->post('order');
            $action_crud        = $request->input('actions', []);
            $data->action      = $request->post('action');
            $data->description = $request->post('description');

            if (!empty($action_crud)) {
                $actionModule = explode(',', $data->action);
                $actionModule = array_merge($actionModule, $action_crud);
                $data->action = implode(',', $actionModule);
            }
            $data->save();

            return response()->json(['status' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $module = Module::find($id);
        $module->permission()->delete();
        $module->where('parent_id', $id)->update(['parent_id' => null]);
        $module->delete();
        return response()->json(['status' => true]);
    }

    public function sort()
    {
        // $sortData = array();
        $sort = 1;
        foreach (request('main') as $key => $main) {
            if (is_array($main)) {
                $no = 1;
                foreach ($main as $a => $b) {
                    $sortData[$b]['parent'] = $key;
                    $sortData[$b]['sort'] = $no;
                    $no++;
                }
            } else {
                // echo $main."<br>";
                $sortData[$main]['parent'] = "0";
                $sortData[$main]['sort'] = $sort;
                $sort++;
            }
        }

        foreach ($sortData as $id => $data) {
            $id = str_replace("mdl-", "", $id);
            $parent = str_replace("mdl-", "", $data['parent']);

            $set =  Module::find($id);
            $set->order_module = $data['sort'];
            $set->upid_module = $parent;
            $set->save();
        }
    }

    public function get_modules_tree()
    {
        $modules = Module::with('child')->where('parent_id', null)
            ->orderBy('order', 'ASC')
            ->get();

        return response()->json($this->format_modules($modules));
    }

    private function format_modules($modules)
    {
        return $modules->map(function ($module) {
            return [
                'id' => $module->id,
                'text' => $module->name,
                'icon' => $module->icon ?? 'ki-solid ki-folder',
                'children' => $module->child->isNotEmpty()
                    ? $this->format_modules($module->child)
                    : []
            ];
        })->toArray();
    }



    public function sort_tree(Request $request)
    {
        // Begin a database transaction
        DB::beginTransaction();

        try {
            $modules = $request->modules;

            foreach ($modules as $module_order => $module) {
                // Update the main module
                Module::find($module['id'])->update([
                    'order' => $module_order,
                    'parent_id' => null
                ]);

                // Only process children if they exist
                if (isset($module['children']) && !empty($module['children'])) {
                    $this->update_children($module['children'], $module['id']);
                }
            }

            // Commit the transaction if everything went well
            DB::commit();

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollback();

            // You may log the exception or return an error response
            return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
        }
    }

    private function update_children($children, $parent_id)
    {
        // Use a while loop to handle the current level of children
        foreach ($children as $sub_module_order => $child) {
            // Update the child module
            Module::find($child['id'])->update([
                'order' => $sub_module_order, // Use the key as the order
                'parent_id' => $parent_id
            ]);

            // If this child has its own children, call the function recursively
            if (isset($child['children']) && !empty($child['children'])) {
                $this->update_children($child['children'], $child['id']);
            }
        }
    }
}
