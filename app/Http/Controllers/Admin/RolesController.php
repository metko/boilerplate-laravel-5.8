<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class RolesController extends AdminController
{
    public function index()
    {
        $roles = Role::orderBy('level')->get();
        return view('admin.roles.index', compact('roles'));
    }
}
