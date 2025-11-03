<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\JenisDokumen;
use App\Models\TipeDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class JenisDokumenController extends CrudController
{
    public function init()
    {
        $this->table = 'ms_dokumen_jenis';
        $this->module = "master-jenis-dokumen";
        $this->title = "Jenis Dokumen";
        $this->subtitle = "Home / Jenis Dokumen";
        $this->raw_columns = ['status'];


        $this->columns = [
            'name' => 'Jenis',
            'tipeDokumen' => 'Tipe Dokumen',
            'link' => 'Link',
            'singkatan' => 'Singkatan',
        ];

        $this->details = [
            'name' => 'Jenis Dokumen',
            'tipeDokumen' => 'Tipe Dokumen',
            'link' => 'Link',
            'singkatan' => 'Singkatan',
            'description' => 'Deskripsi',
            'status' => 'Status',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diubah Pada',
        ];

        $this->fields = [
            'tipedokumen_id' => [
                'label' => 'Tipe Dokumen',
                'type' => 'select',
                'validation' => 'required',
                'option' => getOption([
                    'table' => 'ms_dokumen_tipe',
                    'value' => 'id',
                    'label' => 'name',
                ])
            ],
            'name' => [
                'label' => 'Nama Jenis',
                'type' => 'text',
                'validation' => 'required',
            ],
            'link' => [
                'label' => 'Link',
                'type' => 'text',
                'validation' => 'required',
            ],
            'singkatan' => [
                'label' => 'Singkatan',
                'type' => 'text',
                'validation' => 'required',
            ],
            'description' => [
                'label' => 'Deskripsi',
                'type' => 'textarea',
                'validation' => '',
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
                $('#name-form').on('input', function() {
                    var name = $(this).val();
                    var slug = name.toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/[\s-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    $('#link-form').val(slug);
                });
        ";
    }

    public function queryBuilder(&$query)
    {
        $query->leftJoin('ms_dokumen_tipe', 'ms_dokumen_tipe.id', '=', 'ms_dokumen_jenis.tipedokumen_id');
        $query->select(
            'ms_dokumen_jenis.*',
            'ms_dokumen_tipe.name as tipeDokumen'
        );
    }
    public function filterQuery(&$datatables)
    {
        $datatables->filter(function ($query) {
            if (request()->filled('status')) {
                $query->where('ms_dokumen_jenis.status', '=', request('status'));
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
        if (JenisDokumen::where('link', $postdata['link'])->exists()) {
            throw ValidationException::withMessages([
                'link' => ['Link sudah digunakan'],
            ]);
        }

        if (JenisDokumen::where('singkatan', $postdata['singkatan'])->exists()) {
            throw ValidationException::withMessages([
                'singkatan' => ['Singkatan sudah digunakan'],
            ]);
        }

        $postdata['created_at'] = now();
        $postdata['updated_at'] = now();
    }


    function afterAdd(&$postdata, &$result) {}

    public function beforeEdit(&$postdata, $id)
    {
        $postdata['updated_at'] = now();

        if (JenisDokumen::where('link', $postdata['link'])->where('id', '!=', $id)->exists()) {
            throw ValidationException::withMessages([
                'link' => ['Link sudah digunakan'],
            ]);
        }

        if (JenisDokumen::where('singkatan', $postdata['singkatan'])->where('id', '!=', $id)->exists()) {
            throw ValidationException::withMessages([
                'singkatan' => ['Singkatan sudah digunakan.'],
            ]);
        }
    }

    public function afterEdit(&$postdata, &$result) {}

    public function afterDelete(&$id) {}

    public function jenisDokumenSelect(Request $request)
    {   
        $searchTerm = $request->input('q');

        $data = JenisDokumen::query();

        if ($request->filled('id')) {
            $data = $data->where('tipedokumen_id', '=', $request->input('id'));
        }

        $data = $data->where('name', 'like', "%$searchTerm%");
        $data = $data->select('id', 'name as text')->orderby('name', 'asc')
        ->get();

        return response()->json(['results' => $data]);
    }
}
