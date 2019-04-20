<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function index()
    {
        return view('users.index');
    }
    public function destroy()
    {	
        $user = auth()->user();
        $user->delete();
    }

    public function update(User $user, Request $request)
    {
        $user = auth()->user();
        $attributes = $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users|email',
        ]);
        $user->update($attributes);
    }

   
    public function updatePassword(User $user, Request $request)
    {	
        $user = auth()->user();
        
        $attributes = $this->validate($request, [
            'old_password' => 'required', 
            'password' => 'required|min:8|max:20|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
        if(Hash::check($attributes['old_password'], $user->password)){
            $user->update(['password' => $attributes['password']]);
        }else{
            return redirect(route('profil.edit.password'))
                    ->withErrors(['old_password'=>'the  old password does not match'])
                    ->withInput();
        }
        
    }
}
