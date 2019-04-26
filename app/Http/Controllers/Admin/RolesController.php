<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Permission;
use App\Traits\Permissions;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class RolesController extends AdminController
{
    use Permissions;

    public function index()
    {
        $roles = Role::orderBy('level')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function show(Role $role)
    {
        $permissions = Permission::all();
        $arr = [];
        foreach($permissions as $permission){
            
            if ( ! array_key_exists($permission->model, $arr)) {
                $arr[$permission->model] = [];
            }
            if(array_key_exists($permission->model, $arr)){
                $arr[$permission->model][] = $permission->id; 
            }
        }
        return view('admin.roles.show', compact('role', 'permissions', 'arr'));
    }

   
}
