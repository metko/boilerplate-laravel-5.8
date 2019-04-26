<?php

namespace App\Policies;

use App\Post;
use App\User;
use App\Permission;
use App\Traits\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use Permissions;
    use HandlesAuthorization;
    
    public function before(User $user)
    {
        if($user->isAdmin() || $user->isSuperAdmin()){
            return true;
        }
    }

    public function view(User $user)
    {
       $action = $this->getAction('post.view');
       if($action){
        foreach($user->roles as $role){
            foreach($role->permissions as $permission){
                if($permission->slug == $action->slug){
                    return true;
                }
            }
        }
       } 
    }

    public function update(User $user, $post)
    {
        if($this->manage($user, $post)){
            return true;
        }
       $action = $this->getAction('post.update');
       if($action){
        foreach($user->roles as $role){
            foreach($role->permissions as $permission){
                if($permission->slug == $action->slug){
                    return true;
                }
            }
        }
       } 
    }

    public function delete(User $user, $post)
    {
        if($this->manage($user, $post)){
            return true;
        }
       $action = $this->getAction('post.delete');
       if($action){
        foreach($user->roles as $role){
            foreach($role->permissions as $permission){
                if($permission->slug == $action->slug){
                    return true;
                }
            }
        }
       } 
    }

    public function create(User $user)
    {    
        $action = $this->getAction('post.create');
       if($action){
        foreach($user->roles as $role){
            foreach($role->permissions as $permission){
                if($permission->slug == $action->slug){
                    return true;
                }
            }
        }
       }
    }

    public function manage(User $user, Post $post)
    {
        return $user->id == $post->owner_id; 
    }
}
