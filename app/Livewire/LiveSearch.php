<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Module;
use Livewire\Component;

class LiveSearch extends Component
{
    public $search = '';
    public $route;

    public function mount($route)
    {
        $this->route = $route;
    }

    public function render()
    {
        $base_route = explode('/', $this->route)[0];
        $module = Module::where('link', $base_route)->first();


        $parent_module_id = null;

        if ($module) {
            $parent_module_id = $module->id;
            while ($module->parent_id) {
                $module = Module::find($module->parent_id);
                $parent_module_id = $module->id;
            }
        }

        $modules = Module::with([
            'child.permission' => function ($query) {
                $query->where('role_id', auth()->user()->role_id);
            },
            'permission' => function ($query) {
                $query->where('role_id', auth()->user()->role_id);
            }
        ])
        ->where('parent_id', $parent_module_id)
        ->whereHas('permission', function ($query) {
            $query->where('role_id', auth()->user()->role_id)
                ->where('publish', 1);
        })
        ->where(function ($query) {
            $query->where('name', 'LIKE', "%{$this->search}%")
                ->orWhereHas('child', function ($query) {
                    $query->where('name', 'LIKE', "%{$this->search}%");
                });
        })
        ->whereNull('parent_id')
        ->orderBy('order')
        ->get();


        // You may not need this `each` loop anymore since permissions are already filtered in the `with` method.
        // If you still need to ensure a single permission is attached, you can use the following:
        $modules->each(function ($module) {
            $module->permission = $module->permission->first();
        });

        return view('livewire.live-search', [
            'modules' => $modules
        ]);
    }
}
