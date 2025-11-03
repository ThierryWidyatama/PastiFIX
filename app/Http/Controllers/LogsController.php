<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LogsController extends CrudController
{

    public function __construct(Request $request)
    {
        $this->title = 'Log History';
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
        if (!isAccess('list', get_module_id('logs'), auth()->user()->role_id)) {
            insert_log('Mencoba akses ' . $this->subtitle . ' namun tidak punya akses ' . $this->subtitle, null);
            abort(404);
        }

        insert_log('Mengakses halaman ' . $this->subtitle);

        view()->share([
            'title' => $this->title,
            'subtitle' => $this->subtitle,
        ]);
    }
    public function init()
    {
        $this->table = 'logs';
        $this->module = "logs";
        $this->title = "Log History";
        $this->subtitle = "Home / Log History";
        $this->disable_action = false;
        $this->disable_create = false;
        $this->primary_key = "logs.id";

        $this->columns = [
            'userName' => [
                'label' => 'User',
                'column' => 'users.name'
            ],
            'ip' => 'IP',
            'browser' => 'Browser',
            'activity' => 'Aktivitas',
            'ref_id' => 'ID Data',
            'created_at' => 'Waktu',
        ];
        $this->details = [
            'user_id' => 'User ID',
        ];
    }


    public function queryBuilder(&$query)
    {
        $query->leftJoin('users', 'users.id', '=', 'logs.user_id');
        $query->select(
            'logs.*',
            'users.name as userName'
        );
    }
}
