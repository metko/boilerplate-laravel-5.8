<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;
    
    public function create(User $user){
        
        return $user->isWriter();
    }

    public function delete(User $user, Post $post)
    {
        return $user->id == $post->owner_id;
    }
}
