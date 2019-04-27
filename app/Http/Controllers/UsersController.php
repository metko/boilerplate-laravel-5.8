<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Traits\MediaUploadTrait;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use MediaUploadTrait;

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $user = auth()->user();
        return view('users.index', compact('user'));
    }

    /**
     * edit
     *
     * @return void
     */
    public function edit(){
        $user = auth()->user();
        return view('users.edit', compact('user'));
    }
    
    /**
     * update
     *
     * @param  mixed $user
     * @param  mixed $request
     *
     * @return void
     */
    public function update(User $user, Request $request)
    {
        $user = auth()->user();
        $user->editProfile($this->validateRequestProfile($request, $user));
        return redirect(route('profile.index'))->with('succes', 'profil edited');
    }
    

    public function editPassword()
    {	
        return view('users.editPassword');
    }
    /**
     * updatePassword
     *
     * @param  mixed $user
     * @param  mixed $request
     *
     * @return void
     */
    public function updatePassword(User $user, Request $request)
    {	
        $user = auth()->user();
        $attributes = $this->validate($request, [
            'old_password' => 'required', 
            'password' => 'required|min:8|max:20|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);
        if(Hash::check($attributes['old_password'], $user->password)){
            $user->update(['password' => Hash::make($attributes['password'])]);
            toast('password edited', 'success', 'top-right');
            return redirect(route('profile.index'));
        }else{
            return redirect(route('profile.edit.password'))
                    ->withErrors(['old_password'=>'the  old password does not match'])
                    ->withInput();
        }
    }

    /**
     * destroy
     *
     * @return void
     */
    public function destroy()
    {	
        $user = auth()->user();
        $user->delete();
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
            $this->validate($request, ['name' => 'required|unique:users',]);
        }
        if($user->email != $request->email){
            $this->validate($request, ['email' => 'required|unique:users',]);
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



    public function storeAvatar(Request $request)
    {
        $media = $request->file('file');
        $filename = auth()->user()->id.'_'.auth()->user()->name;
        $model = auth()->user();
        $this->uploadMedia($media, $model , $filename);     
    }
}
