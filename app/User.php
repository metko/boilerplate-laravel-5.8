<?php

namespace App;

use App\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

    public function assignRole($roleName)
    { 
        $role = Role::whereName($roleName)->first() ?? null;
        if( ! $this->isActually($roleName)){
            $user =  $this->roles()->attach($role);
            $this->refresh();
            return $user;
        }  
    } 

    public function isActually($role)
    {
        return $this->roles->contains('name', $role);
    }

    public function isMember()
    {
        foreach($this->roles as $role){
            return $role->name == 'member';
        }    
    }

    public function isWriter()
    {
        foreach($this->roles as $role){
            return $role->name == 'writer';
        }    
    }

    public function isAdmin()
    {
        foreach($this->roles as $role){
            return $role->name == 'admin';
        }    
    }

    public function isSuperAdmin()
    {
        foreach($this->roles as $role){
            return $role->name == 'super_admin';
        }   
    }

    public function gravatar()
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?d=mm&s=100';
    }
}
