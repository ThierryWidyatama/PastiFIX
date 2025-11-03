<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Opd;
use App\Models\TipeDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OpdController extends CrudController
{
    public function init()
    {
        $this->table = 'ms_opd';
        $this->module = "master-opd";
        $this->title = "Opd";
        $this->subtitle = "Home / Opd";
        $this->raw_columns = ['status'];


        $this->columns = [
            'name' => 'Opd',
            'status' => 'Status',
            'created_at' => 'Dibuat Pada',
        ];

        $this->details = [
            'name' => 'Opd',
            'status' => 'Status',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diubah Pada',
        ];

        $this->fields = [
            'name' => [
                'label' => 'Opd',
                'type' => 'text',
                'validation' => 'required',
            ],
            'status' => [
                'label' => 'Status',
                'type' => 'select',
                'validation' => 'required',
                'option' => [
                    '1' => 'Aktif',
                    '0' => 'Tidak Aktif',
                ]
            ],
        ];

        $this->fields_filter = [
            'status' => [
                'label' => 'Status',
                'type' => 'select',
                'validation' => '',
                'option' => [
                    '1' => 'Aktif',
                    '0' => 'Tidak Aktif',
                ]
            ],
        ];

        // $this->disable_create = false;

        $this->buttons = [
            // 'export' => '<button type="button" id="btn-export" class="btn btn-info me-5 mt-2"><i class="fas fa-file-excel"></i> Export</button>',
        ];

        $this->actions = [
            // 'project' => [
            //     'label' => 'Tambah Project',
            //     'icon' => '<i class="fas fa-plus"></i> ',
            //     'url' => '/project/create?ro={id}',
            //     'color' => 'btn-success'
            // ],
        ];

        $this->js_code = "
        ";
    }

    public function queryBuilder(&$query)
    {
    }
    public function filterQuery(&$datatables)
    {
        $datatables->filter(function ($query) {
            if (request()->filled('status')) {
                $query->where('status', '=', request('status'));
            }
        }, true);
    }

    public function filterDatatabaseQuery(&$query, $request) {}

    public function datatableBuilder(&$datatables)
    {
        $datatables->editColumn('status', function ($row) {
            if ($row->status == '1') {
                return '<span class="badge badge-success fw-bold">Aktif</span>';
            } else {
                return '<span class="tbadge badge-danger fw-bold">Tidak Aktif</span>';
            }
        });
    }

    public function editDetail(&$data)
    {
        if ($data->status == '1') {
            $data->status = '<span class="badge badge-success fw-bold">Aktif</span>';
        } else {
            $data->status = '<span class="badge badge-danger fw-bold">Tidak Aktif</span>';
        }
    }

    public function beforeAdd(&$postdata)
    {
        $postdata['created_at'] = now();
        $postdata['updated_at'] = now();
    }

    function afterAdd(&$postdata, &$result) {}

    public function beforeEdit(&$postdata,$id)
    {
        $postdata['updated_at'] = now();
    }

    public function afterEdit(&$postdata, &$result) {}

    public function afterDelete(&$id) {}

    public function opdSelect(Request $request)
    {
        $searchTerm = $request->input('q');

        $data = Opd::where('name', 'like', "%$searchTerm%")
            ->select('id', 'name as text')
            ->get();

        return response()->json(['results' => $data]);
    }
}
