<?php

namespace App\Policies;

use App\Traits\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;


class PostPolicy
{
    use Permissions;
    use HandlesAuthorization;

    public $slug = "post";
      
}
