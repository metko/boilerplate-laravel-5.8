<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;

class UsersAdminController extends AdminController
{

    public function edit(User $user)
    {
        $roles = Role::all();
       return view('admin.users.edit', compact('user', 'roles'));
    }
    public function update(Request $request){
        $user = Auth::user();
        $attributes = $this->validate($request, [
            'name' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'first_name' => 'nullable|min:3',
            'last_name' => 'nullable|min:3',
            'location' => 'nullable|min:2',
            'bio' => 'nullable|min:5',
            'roles' => 'required'
        ]);
        $attributes = [
            'user' => [
                'name' => $request->name,
                'email' =>  $request->email,
                'password' =>  $request->password,
                'activated' => $request->activated ? 1 : 0
            ],
            'profile' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'location' => $request->location,
                'bio' => $request->BIO,
            ],
            'roles' => $request->roles
        ];

        if($user->update($attributes['user'])){
            $user->profile->update($attributes['profile']);
            $user->roles()->detach();
            foreach($attributes['roles'] as $role) {
                $user->attachRole($role);
            }
            return redirect(route('admin.users.admin.show'))->with('success', 'Profil updated');
        }else{
            abort(500);
        }
    }
}
