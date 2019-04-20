<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;
    
    public function before(User $user)
    {
       
        if($user->isAdmin() || $user->isSuperAdmin()){
            
            return true;
        }
    }

    public function create(User $user)
    {    
        return $user->isWriter();
    }

    public function manage(User $user, Post $post)
    {
        if($user->isWriter()){
            return $user->id == $post->owner_id;
        }
    }
}
