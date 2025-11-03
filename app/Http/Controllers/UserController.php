<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\ModulePermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $title;
    protected $subtitle;

    public function __construct(Request $request)
    {
        $this->title = 'Data Pengguna';
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
        if (!isAccess('list', get_module_id('user'), auth()->user()->role_id)) {
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
            'roles' => 'required',
            'password' => 'required',
            'username' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Check if the username is unique when deleted_at is null
                    $count = DB::table('users')
                        ->where('username', $value)
                        ->count();

                    if ($count > 0) {
                        $fail('Username Sudah digunakan');
                    }
                },
            ],
            // 'employee_user' => 'required',
            'status' => 'required',
        ];
        $pesan = [
            'roles.required' => 'Hak Akses Wajib di isi',
            'password.required' => 'Password Wajib di isi',
            'username.required' => 'Username Wajib di isi',
            'username.unique' => 'Username Sudah digunakan',
            // 'employee_user.required' => 'Pegawai Wajib di isi',
            'status.required' => 'Status Wajib di isi',
        ];

        return Validator::make($request, $rule, $pesan);
    }

    public function index()
    {
        $get_module = get_module_id('user');
        return view('admin.user.index', compact('get_module'));
    }

    public function data(){
        $datas = User::select(['id', 'name as nama', 'username', 'users.status as status', 'users.role_id', ])->get();
        $user = $datas;
        if (!$user->isEmpty()) {
            $id_module = get_module_id('user');
                foreach ($user as $item) {
                    //init btn
                    $actionButtons = '';
                    $showButtons = '';
                    if (isAccess('show', $id_module, auth()->user()->role->id)) {
                        $showButtons = '<button type="button" onclick="location.href=' . "'" . route('user.show', $item->id) . "'" . ';" class="btn btn-icon btn-info btn-sm" title="Detail Data"><i class="fa fa-eye"></i></button> ';
                    }
                    //edit
                    $editButtons = '';
                    if (isAccess('update', $id_module, auth()->user()->role->id)) {
                        $editButtons = '<button type="button" onclick="location.href=' . "'" . route('user.edit', $item->id) . "'" . ';" class="btn btn-icon btn-warning btn-sm" title="Edit Data"><i class="ki-outline ki-pencil fs-2"></i></button> ';
                    }
                    //delete
                    $deleteButtons = '';
                    if (isAccess('delete', $id_module, auth()->user()->role->id)) {
                        $deleteButtons = '<button href="#hapus" data-id="' . $item->id . '" data-nama="' . $item->nama . '" class="btn btn-icon btn-danger btn-sm btn-hapus" title="Hapus Data"><i class="fas fa-trash"></i></button> ';
                    }

                    //reset passwrod
                    $resetButtons = '';
                    if (isAccess('reset', $id_module, auth()->user()->role->id)) {
                        $resetButtons = '<button href="#reset" data-id="' . $item->id . '" data-nama="' . $item->nama . '" class="btn btn-icon btn-secondary btn-sm btn-reset" title="Reset Password"><i class="fas fa-rotate-right"></i></button> ';
                    }
                    $item->action = $showButtons . $editButtons . $deleteButtons . $resetButtons;
                    $item->set_status = '<button type="button" class="btn btn-sm btn-' . ($item->status == "1" ? "success" : "warning") . ' btn-status" data-val="' . $item->status . '" data-id="' . $item->id . '" data-nama="' . $item->nama . '">' . ($item->status == "1" ? "Aktif" : "Tidak Aktif") . '</button> ';
                    $item->set_role = Role::where('id', $item->role_id)->value('code');
                }

            }

            // dd($user);
            return response()->json([
                'status' => true,
                'data' => $user
            ]);
    }

    public function create()
    {
        $role = Role::orderBy('name')->get();

        return view('admin.user.create', compact('role'));
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
            //get data employee
            // $get_data = Employee::find($request->post('employee_user'));

            if (User::where('email', $request->email)->exists()) {
                return response()->json(['status' => false, 'email' => 'Email sudah terdaftar.']);
            }

            $new_user = new User;
            $new_user->id = Uuid::uuid4()->toString();
            $new_user->name = $request->name;
            $new_user->email = $request->email;
            $new_user->username = $request->post('username');
            $new_user->role_id = $request->post('roles');
            // $new_user->employee_user = $request->post('employee_user');
            $new_user->status = $request->post('status');
            // $new_user->kab_kota = $request->post('kab_kota');
            $new_user->password = \Hash::make($request->post('password'));
            $new_user->save();

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
        $data = User::find($id);
        $role = Role::orderBy('name')->get();

        return view('admin.user.show', ['get_data' => $data, 'role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = User::find($id);
        $role = Role::orderBy('name')->get();
        return view('admin.user.edit', ['get_data' => $data, 'role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // $validator = $this->rules($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'roles' => 'required',
                'username' => 'required',
                'name' => 'required',
                'email' => 'required',
                // 'employee_user' => 'required',
                'status' => 'required',
            ],
            [
                'roles.required' => 'Hak Akses Wajid di isi',
                'username.required' => 'Username Wajid di isi',
                'name.required' => 'Nama Wajid di isi',
                'email.required' => 'Email Wajid di isi',
                // 'employee_user.required' => 'Pegawai Wajid di isi',
                'status.required' => 'Status Wajid di isi',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['status' => false, 'pesan' => $validator->errors()]);
        } else {

            $new_user = User::find($id);
            $new_user->name = $request->name;
            $new_user->email = $request->email;
            $new_user->username = $request->post('username');
            $new_user->role_id = $request->post('roles');
            // $new_user->employee_user = $request->post('employee_user');
            $new_user->status = $request->post('status');
            if ($request->post('password')) {
                $new_user->password = \Hash::make($request->post('password'));
            }
            $new_user->save();

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
        $user = User::find($id);
        if ($user->u_avatar) {
            unlink(public_path($user->u_avatar));
        }
        $hapus = User::destroy($user->id);

        //jika data berhasil dihapus, akan kembali ke halaman utama
        if ($hapus) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    // public function export()
    // {
    //     $set = User::find($id);
    //     $set->deleted_at = date('Y-m-d H:i:s');
    //     $set->save();
    //     return response()->json(true);
    // }

    //reset password
    public function ResetPass($id)
    {
        $set = User::find($id);
        $set->password = \Hash::make($set->username);
        $set->save();
        return response()->json(['status' => true, 'pesan' => $set->username]);
    }

    //ganti status
    public function ChangeStatus($id, $val)
    {
        $set = User::find($id);
        if ($val == "1") {
            $set->status = "0";
        } else {
            $set->status = "1";
        }
        $set->save();
        return response()->json(true);
    }


}
