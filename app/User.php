<?php

namespace App;

use App\Role;
use App\Comment;
use App\Profile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'activated'
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
        'activated' => 'boolean'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

    public function adminPath()
    {
        return route('admin.users.show', $this->id);
    }

    public function attachRole($roleName)
    { 
        if(is_array($roleName)){
            foreach($roleName as $r){
                $role = Role::whereSlug(Str::slug($r))->first() ?? null;
                if( ! $this->hasRole($r)){
                    $user =  $this->roles()->attach($role);
                    $this->refresh();    
                }  
            }
            return $user;
        }

        $role = Role::whereSlug(Str::slug($roleName))->first() ?? null;
        if( ! $this->hasRole($roleName)){
            $user =  $this->roles()->attach($role);
            $this->refresh();
            return $user;
        }  
    } 

    public function hasRole($role)
    {
        return $this->roles->contains('slug', Str::slug($role));
    }

    public function activate()
    {
        $this->update(['activated' => 1]);
    }

    public function desactivate()
    {
        $this->update(['activated' => 0]);
        return $this;
    }

    public function hasLevel($level)
    {   
        foreach($this->roles as $role){
            if((int)$role->level >=  $level){
                return true;
            }
        } 
    }

    public function isGuest()
    {
        return $this->hasLevel(0);   
    }

    public function isMember()
    {
        return $this->hasLevel(1);   
    }

    public function isModerator()
    {
        foreach($this->roles as $role){
            if($role->level == 2 || $role->level >= 4)
            {
                return true;
            }
        }    
    }

    public function isWriter()
    {
       
        return $this->hasLevel(3);      
    }

    public function isAdmin()
    {
        return $this->hasLevel(4);       
    }

    public function isSuperAdmin()
    {
        return $this->hasLevel(5);     
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function gravatar()
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email) . '?d=mm&s=100';
    }

    public function editProfile($attributes)
    {  
        $this->update($attributes['user']);
        return $this->profile->update($attributes['profile']);
    }

    public function removeRole($role)
    {
        $role = Role::whereSlug(str::slug($role))->first();
        $this->roles()->detach($role);
        $this->refresh();
    }

    public function removeAllRole()
    {
        $this->roles()->detach();
        $this->refresh();
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'owner_id');
    }
}
