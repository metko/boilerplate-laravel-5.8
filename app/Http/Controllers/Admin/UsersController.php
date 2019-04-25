<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\AdminController;

class UsersController extends AdminController
{   

    public function index()
    {
        $users = User::all();
        $count = [
            'users' => User::count()
        ];
        return view('admin.users.index', compact('users', 'count'));
    }

    public function show(User $user)
    {	
        return view('admin.users.show', compact('user'));
    }

    public function edit(Request $request, User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }


    public function create(User $user)
    {
        $roles = Role::all();
        $user->activated = 1;
        return view('admin.users.create', compact('user', 'roles'));
    }

    public function store(Request $request){
        
        $attributes = $this->validate($request, [
            'name' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|max:20|confirmed',
            'password_confirmation' => 'required|same:password',
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
        

        $user = new User();
        if($user = $user->create($attributes['user'])){
            $user->profile->update($attributes['profile']);
           
            foreach($attributes['roles'] as $role) {
                $user->attachRole($role);
            }
            return redirect(route('admin.users.index'))->with('success', 'User created');
        }else{
            abort(500);
        }
    }

    public function update(User $user, Request $request)
    { 
        if($user->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:users|min:5']);
        }
        if($user->email != $request->email){
            $this->validate($request, ['email' => 'required|unique:users']);
        }

        $attributes = $this->validate($request, [
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
            ],
            'profile' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'location' => $request->location,
                'bio' => $request->bio,
            ],
            'roles' => $request->roles
        ];
        if($user->update($attributes['user'])){
            $user->profile->update($attributes['profile']);
            $user->roles()->detach();
            foreach($attributes['roles'] as $role) {
                $user->attachRole($role);
            }
            return redirect($user->adminPath())->with('success', 'User created');
        }else{
            abort(500);
        }
    }
    
    public function updatePassword(User $user, Request $request)
    {	
        $attributes = $this->validate($request, [
            'old_password' => 'required', 
            'password' => 'required|min:8|max:20|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
        if(Hash::check($attributes['old_password'], $user->password)){
            $user->update(['password' => $attributes['password']]);
        }else{
            return redirect(route('profile.edit.password'))
                    ->withErrors(['old_password'=>'the  old password does not match'])
                    ->withInput();
        }   
    }

    public function destroy(User $user, Request $request)
    {
        $user = User::find($user->id);
        if($user && $user->delete()){
            return redirect(route('admin.users.index'))->with('success', 'User deleted');
        }else{
            //TODO RETURN ERROR
        }
    }

    public function desactivate(Request $request, $user)
    {
        $user = User::find($user);
        $user->desactivate();
        return redirect(route('admin.dashboard'));
    }

    /**
     * validateRequestProfile
     *
     * @param  mixed $request
     * @param  mixed $user
     *
     * @return void
     */
    public function validateRequestProfile(Request $request, $user)
    {
        if($user->name != $request->name){
            $this->validate($request, ['name' => 'required|unique:users|min:5']);
        }
        if($user->email != $request->email){
            $this->validate($request, ['email' => 'required|unique:users']);
        }
       
        $attributesProfile = $this->validate($request, [
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'bio' => 'nullable|min:5',
            'location' => 'nullable',
        ]);
        $attributes = [
            'user' => [
                'name' => $request->name,
                'email' => $request->email
            ],
            'profile' => $attributesProfile
        ];

        return $attributes;
    }
}
