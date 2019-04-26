<?php

namespace App\Policies;

use App\User;
use App\Comment;
use App\Traits\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostCommentsPolicy
{
    use Permissions;
    use HandlesAuthorization;

    public $slug = "post_comment";

    


}
