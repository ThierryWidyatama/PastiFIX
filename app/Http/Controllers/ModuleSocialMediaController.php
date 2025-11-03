<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleSocialMediaController extends CrudController
{
    public function init()
    {
        $this->table = 'ms_social_media';
        $this->module = "master-social-media";
        $this->title = "Sosial Media";
        $this->subtitle = "Master Data / Sosial Media";
        $this->raw_columns = ['status', 'icon'];


        $this->columns = [
            'name' => 'Nama Sosial Media',
            'link' => 'Link',
            'icon' => 'Icon',
            'status' => 'Status',
        ];

        $this->details = [
            'name' => 'Nama Sosial Media',
            'link' => 'Link',
            'icon' => 'Icon',
            'status' => 'Status',
        ];

        $this->fields = [
            'name' => [
                'label' => 'Nama Sosial Media',
                'type' => 'text',
                'validation' => 'required',
            ],
            'link' => [
                'label' => 'Link',
                'type' => 'text',
                'validation' => 'required',
            ],
            'icon' => [
                'label' => 'Icon Sosial Media, Ambil dari Bootstrap Icons',
                'type' => 'textarea',
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
            // 'ref_jenis_sewa' => [
            //     'label' => 'Jenis Sewa',
            //     'type' => 'select',
            //     'validation' => 'required',
            //     'option' => getOption([
            //         'table' => 'ms_jenis_sewa',
            //         'value' => 'id',
            //         'label' => 'nama_jenis',
            //     ])
            // ],

        ];


        $this->fields_filter = [
            'name' => [
                'label' => 'Nama Sosial Media',
                'type' => 'text',
                'validation' => '',
            ],
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
        $('#nilai_proyek-form').on('input', function() {
            var inputValue = $(this).val().replace(/,/g, '');
            var numericValue = inputValue.replace(/[^0-9]/g, '');

            if (numericValue !== '') {
                var formattedValue = parseInt(numericValue).toLocaleString(
                    'en-US');
                $(this).val(formattedValue);
            } else {
                $(this).val('');
            }
        });
        ";

    }

    public function queryBuilder(&$query)
    {
        // $query->leftJoin('ms_client', 'ms_client.id', '=', 'tb_request_order.ref_client_id');
        // $query->leftJoin('ms_jenis_sewa', 'ms_jenis_sewa.id', '=', 'tb_request_order.ref_jenis_sewa');
        // $query->leftJoin('users', 'users.id', '=', 'tb_request_order.created_by');
        // $query->select(
        //     'tb_request_order.*',
        //     'ms_client.nama_client as namaClient',
        //     'ms_client.no_hp as noHp',
        //     'ms_jenis_sewa.nama_jenis as namaJenis',
        //     'tb_request_order.status AS statusRo',
        //     'users.name AS createdby_name',
        // );
    }
    public function filterQuery(&$datatables)
    {
        $datatables->filter(function ($query) {
            if (request()->filled('name')) {
                $query->where('ms_social_media.name', 'like', "%" . request('name') . "%");    }
            if (request()->filled('status')) {
                $query->where('ms_social_media.status', '=' ,request('status'));
            }
        }, true);
    }

    public function filterDatatabaseQuery(&$query, $request)
    {

    }

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
        } else{
            $data->status = '<span class="badge badge-danger fw-bold">Tidak Aktif</span>';
        }
    }

    public function beforeAdd(&$postdata)
    {
        $postdata['created_at'] = now();
        $postdata['updated_at'] = now();
    }

    function afterAdd(&$postdata, &$result)
    {
    }

    public function beforeEdit(&$postdata)
    {
        $postdata['updated_at'] = now();
    }

    public function afterEdit(&$postdata, &$result)
    {
    }

    public function afterDelete(&$id)
    {
    }

    // public function fakultasSelect(Request $request){
    //     $searchTerm = $request->input('q');
    //     $id_province = $request->input('id');

    //     $data = Fakultas::where('name', 'like', "%$searchTerm%");
    //         $data = $data->select('id', 'name as text')
    //         ->get();

    //     return response()->json(['results' => $data]);
    // }

}
