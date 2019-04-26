<?php

namespace App\Policies;

use App\Post;
use App\User;
use App\Traits\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;


class PostPolicy
{
    use Permissions;
    use HandlesAuthorization;

    public $slug = "post";

    
    /**
       * If the user van view the model
       *
       * @User $user
       *
       * @return bool
      */
      public function view(User $user)
      {
            dd('dfdfd');
            return;
      }
      
}
