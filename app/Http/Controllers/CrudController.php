<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class CrudController extends Controller
{
    public $table;
    public $module;
    public $title;
    public $subtitle;
    public $columns;
    public $details;
    public $fields;
    public $fields_filter;
    public $column_datatables;
    public $url;
    public $raw_columns;
    public $actions;
    private $postdata;
    public $primary_key = 'id';
    public $buttons;
    public $js_code;
    public $custom_script;
    public $html_code;
    public $access;
    public $disable_action = true;
    public $disable_create = true;
    public $disable_delete = true;
    public $disable_filter = true;

    public function init()
    {
    }

    public function index()
    {
        $this->init();
        $this->validationCheck();
        $this->preproccess();

        insert_log('Mengunjungi menu ' . $this->title);

        return view(config('template.crud.list'), [
            'title' => $this->title,
            'module' => $this->module,
            'subtitle' => $this->subtitle,
            'columns' => $this->columns,
            'column_datatables' => $this->column_datatables,
            'fields_filter' => $this->fields_filter,
            'url' => $this->url,
            'primary_key' => $this->primary_key,
            'buttons' => $this->buttons,
            'js_code' => $this->js_code,
            'html_code' => $this->html_code,
            'disable_action' => $this->disable_action,
            'disable_create' => $this->disable_create,
            'disable_filter' => $this->disable_filter,
        ]);
    }

    public function create()
    {
        $this->init();
        $this->validationCheck();
        $this->preproccess();
        $this->url['store'] = "/" . $this->module;

        insert_log('Mengunjungi tambah menu ' . $this->title);

        return view(config('template.crud.create'), [
            'title' => $this->title,
            'module' => $this->module,
            'subtitle' => $this->subtitle,
            'fields' => $this->fields,
            'url' => $this->url,
            'js_code' => $this->js_code,
            'custom_script' => $this->custom_script,
            'primary_key' => $this->primary_key
        ]);
    }

    public function data(Request $request)
    {
        $this->init();
        $query = DB::table($this->table);
        $this->queryBuilder($query);


        $this->filterDatatabaseQuery($query, $request);
        $datatables = DataTables::of($query);
        $this->datatableBuilder($datatables);
        $this->filterQuery($datatables);

        if ($this->disable_action) {
            $this->setAction($datatables);
        }
        if (isset($this->raw_columns) && count($this->raw_columns) > 0) {
            $datatables->rawColumns(array_merge($this->raw_columns, ['action']));
        } else {
            $datatables->rawColumns(['action']);
        }
        return $datatables->toJson();
    }


    public function queryBuilder(&$query)
    {
    }

    public function datatableBuilder(&$datatables)
    {
    }

    public function filterQuery(&$datatables)
    {
    }

    public function filterDatatabaseQuery(&$query, $request)
    {
        if (isset($this->fields_filter)) {
            foreach ($this->fields_filter as $search => $data_search) {
                if ($request->filled($search)) {
                    $query->where($search, 'LIKE', '%' . $request->$search . '%');
                } elseif ($search == 'tahun'){
                    if ($request->filled($search)) {
                        $query->where($search, 'LIKE', '%' . $request->$search . '%');
                    } else {
                        $query->where($search, 'LIKE', '%' . date('Y') . '%');
                    }
                }
            }
        }
    }

    private function setAction($datatables)
    {
        $datatables->addColumn('action', function ($row) {
            $id = $this->primary_key;
            $this->setActionRule($row);

            $detail_action = "";
            $edit_action = "";
            $delete_action = "";

            $editAccess = $this->access['update'] ?? true;
            $deleteAccess = $this->access['delete'] ?? true;
            $showAccess = $this->access['show'] ?? true;

            if (isAccess('show', get_module_id($this->module), auth()->user()->role) && $showAccess) {
                $detail_action = '<button type="button" onclick="location.href=' . "'" . $this->module . '/' . $row->$id . "'" . ';" class="btn btn-icon btn-info btn-sm" title="Detail Data">
                <i class="fa fa-eye"></i></button>';
            }
            if (isAccess('update', get_module_id($this->module), auth()->user()->role) && $editAccess) {
                $edit_action = ' <button type="button" onclick="location.href=' . "'" . $this->module . '/' . $row->$id . "/edit'" . ';" class="btn btn-icon btn-warning btn-sm" title="Edit Data">
                <i class="ki-outline ki-pencil fs-2"></i></button>';
            }
            if (isAccess('delete', get_module_id($this->module), auth()->user()->role) && $deleteAccess) {
                $delete_action = '<button type="button" onclick="deleteData(\'' . $row->$id . '\')" data-id="' . $this->module . '/' . $row->$id . '" class="btn btn-icon btn-danger btn-sm btn-hapus" title="Hapus Data">
            <i class="fas fa-trash"></i></button>';
            }

            $actions = " ";
            if (isset($this->actions)) {
                foreach ($this->actions as $method => $action) {
                    $this->access[$method] = $this->access[$method] ?? true;
                    if ($this->access[$method]) {
                        $actions .= setAction($action['label'], $action['icon'], str_replace('{id}', $row->$id, $action['url']), $action['color']) . ' ';
                    }
                }
            }

            return '<div class="text-end">' . $actions . ' ' . $detail_action . ' ' . $edit_action . ' ' . $delete_action . '</div>';
        });
    }

    public function setActionRule(&$row)
    {
    }

    private function validationCheck()
    {
        if ($this->columns == null) {
            throw new \Exception('Please set columns in your controller');
        }

        if ($this->details == null) {
            throw new \Exception('Please set details in your controller');
        }

        if ($this->title == null) {
            throw new \Exception('Please set title in your controller');
        }

        if ($this->module == null) {
            throw new \Exception('Please set module in your controller');
        }

        if ($this->table == null) {
            throw new \Exception('Please set table in your controller');
        }
    }

    private function preproccess()
    {

        //set Columm Datatables
        foreach ($this->columns as $column => $data_column) {
            $this->column_datatables[] = [
                'data' => $column,
                'name' => isset($data_column['column']) ? $data_column['column'] : $column
            ];
        }
        if ($this->disable_action) {
            $this->column_datatables[] = [
                'data' => 'action',
                'width' => '20%',
            ];
        }
        $this->column_datatables = json_encode($this->column_datatables);

        //set Url
        $this->url['baseurl'] = "/" . $this->module;
        $this->url['create'] = "/" . $this->module . "/create";
        $this->url['datatables'] = "/" . $this->module . "/data";
    }

    public function show($id)
    {
        $this->init();
        $this->validationCheck();
        $this->preproccess();

        $query = DB::table($this->table);
        $this->queryBuilder($query);
        $data = $query->where($this->table . '.' . $this->primary_key, $id)->first();

        $this->editDetail($data);

        insert_log('Mengunjungi detail menu ' . $this->title);
        return view(config('template.crud.show'), [
            'title' => $this->title,
            'module' => $this->module,
            'subtitle' => $this->subtitle,
            'columns' => $this->details,
            'url' => $this->url,
            'primary_key' => $id,
            'data' => $data
        ]);
    }

    public function edit($id)
    {
        $this->init();
        $this->validationCheck();
        $this->preproccess();

        $query = DB::table($this->table);
        $this->queryBuilder($query);
        $data = $query->where($this->table . '.' . $this->primary_key, $id)->first();

        $this->editValue($data);

        insert_log('Mengunjungi edit menu ' . $this->title);

        $this->url['update'] = "/" . $this->module . "/" . $id;
        return view(config('template.crud.edit'), [
            'title' => $this->title,
            'module' => $this->module,
            'subtitle' => $this->subtitle,
            'columns' => $this->columns,
            'column_datatables' => $this->column_datatables,
            'url' => $this->url,
            'primary_key' => $id,
            'fields' => $this->fields,
            'data' => $data,
            'js_code' => $this->js_code,
            'custom_script' => $this->custom_script,
            'raw_columns' => $this->raw_columns,
        ]);
    }

    public function validationForm($type)
    {
        $this->init();
        $validation = [];
        foreach ($this->fields as $field_name => $value) {
            if ($type == 'update' && $value['type'] == 'file') {
                $value['validation'] = str_replace('required|', '', $value['validation']);
                $value['validation'] = str_replace('required', '', $value['validation']);
                $value['validation'] = str_replace('|required', '', $value['validation']);
                $value['validation'] = str_replace('mimes|', '', $value['validation']);
                $value['validation'] = str_replace('mimes', '', $value['validation']);
                $value['validation'] = str_replace('|mimes', '', $value['validation']);
            }
            $validation[$field_name] = $value['validation'] ?? "";
        }

        return $validation;
    }

    public function beforeAdd(&$postdata)
    {
    }
    public function beforeEdit(&$postdata, $id)
    {
    }

    public function editValue(&$data)
    {
    }

    public function afterAdd(&$postdata, &$result)
    {
    }
    public function afterEdit(&$postdata, &$result)
    {
    }
    public function afterDelete(&$id)
    {
    }

    public function addUuid(&$postdata)
    {
        $postdata[$this->primary_key] = Uuid::uuid4();
    }

    public function store(Request $request)
    {
        $this->init();
        $this->validationCheck();
        $this->preproccess();


        $request->validate($this->validationForm('store'), $messages = [
            'required' => 'Data wajib diisi.',
            'email' => 'Format email salah.',
            'mimes' => 'Format dokumen tidak sesuai',
        ]);


        $this->postdata = $request->except(['_token', '_method']);
        $this->beforeAdd($this->postdata);

        $this->uploadFields($request, $this->postdata);

        $this->addUuid($this->postdata);

        $query = DB::table($this->table);
        $id = $query->insertGetId($this->postdata);

        $data = $query->where($this->primary_key, $this->postdata[$this->primary_key])->first();
        $this->afterAdd($this->postdata, $data);

        $pk = $this->primary_key;
        insert_log('menambahkan data pada menu ' . $this->title, $data->$pk, json_encode($data));

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->init();
        $this->validationCheck();
        $this->preproccess();

        $request->validate($this->validationForm('update'), $messages = [
            'required' => 'Data wajib diisi.',
            'email' => 'Format email salah.',
        ]);
        //upload
        $this->postdata = $request->except(['_token', '_method']);
        $this->beforeEdit($this->postdata, $id);
        $this->uploadFields($request, $this->postdata);

        $query = DB::table($this->table);
        $data = $query->where($this->primary_key, $id)->update($this->postdata);

        $data = DB::table($this->table)->where($this->primary_key, $id)->first();
        $this->afterEdit($this->postdata, $data);

        insert_log("memperbarui data pada menu " . $this->title, $id, json_encode($data));

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diupdate'
        ]);
    }

    public function uploadFields(&$request, &$postdata)
    {
        foreach ($this->fields as $field_name => $value) {
            if ($value['type'] == 'file') {
                if ($request->hasFile($field_name)) {
                    $file = $request->file($field_name);
                    $filename = $file->getClientOriginalName();
                    $filename = md5($filename . time()) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/' . $field_name), $filename);

                    //path upload to database
                    $filename = 'uploads/' . $field_name . '/' . $filename;
                    $postdata[$field_name] = $filename;
                } else {
                    unset($postdata[$field_name]);
                }
            }
        }
    }

    public function destroy($id)
    {
        $this->init();
        $this->validationCheck();

        $query = DB::table($this->table);
        $data = $query->where($this->primary_key, $id);
        insert_log("menghapus data pada menu " . $this->title, $id, json_encode($data->first()));
        $data->delete();
        $this->afterDelete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function editDetail(&$data)
    {
    }


    public function filterTable(Request $request)
    {
        if (!empty($this->table_filter)) {
            $this->query->where(function ($query) {
                $query->where('column1', '=', 'value1')
                    ->where('column2', '=', 'value2');
            });
        }
    }
}
