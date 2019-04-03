<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostCommentsPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Comment $comment)
    {
        return $user->is($comment->owner);
    }


}
