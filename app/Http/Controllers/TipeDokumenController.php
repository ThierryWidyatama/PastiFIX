<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\TipeDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TipeDokumenController extends CrudController
{
    public function init()
    {
        $this->table = 'ms_dokumen_tipe';
        $this->module = "master-tipe-dokumen";
        $this->title = "Tipe Dokumen";
        $this->subtitle = "Home / Tipe Dokumen";
        $this->raw_columns = ['status'];


        $this->columns = [
            'name' => 'Tipe Dokumen',
            'order' => 'Urutan',
            'status' => 'Status',
            'created_at' => 'Dibuat Pada',
        ];

        $this->details = [
            'name' => 'Tipe Dokumen',
            'status' => 'Status',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diubah Pada',
        ];

        $this->fields = [
            'name' => [
                'label' => 'Tipe Dokumen',
                'type' => 'text',
                'validation' => 'required',
            ],
            'order' => [
                'label' => 'Urutan',
                'type' => 'number',
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

    public function tipeDokumenSelect(Request $request)
    {
        $searchTerm = $request->input('q');

        $data = TipeDokumen::where('name', 'like', "%$searchTerm%")
            ->orderBy('order')
            ->select('id', 'name as text')
            ->get();
            

        return response()->json(['results' => $data]);
    }
}
