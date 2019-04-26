<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Permission;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class PermissionController extends AdminController
{
    public function update(Request $request, Role $role)
    { 

        if( ! $request->permissions){
            return redirect(route('admin.roles.show', $role->id))->with('error', 'a role must have at least one permissions');
        }
        $arr = []; 
        foreach($request->permissions as $id => $value){
            array_push($arr, $id);
        }
        $role->attachPermissions($arr);
        return redirect(route('admin.roles.show', $role->id))->with('success', 'role updated');
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request){

        $attributes = $this->validate($request, [
            'model' => 'required|min:2|unique:permissions'
        ]);
        
        $permission = new Permission();
        if($permission->createPermission($attributes)){
            return redirect(route('admin.roles.index'))->with('success', 'permissions created');
        }
        
    }
}
