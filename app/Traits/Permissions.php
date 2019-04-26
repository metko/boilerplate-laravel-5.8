<?php

namespace App\Traits;

use App\Post;
use App\User;
use App\Permission;
use Illuminate\Auth\Access\AuthorizationException;

trait Permissions
{
      protected $permissions = ['view', 'create', 'edit', 'delete'];

      /**
       * If the user is admin or superAdmin
       *
       * @User $user
       *
       * @return boolean
       */
      public function before(User $user)
      { 
            if($user->isAdmin() || $user->isSuperAdmin()){
                  return true;
            }
      }

      /**
       * If the user is the owner of the model
       *
       * @User $user
       * @Post $post
       *
       * @return bool
      */
      public function manage(User $user, Post $post)
      {
            return $user->id == $post->owner_id; 
      }
        
      /**
       * If the user van view the model
       *
       * @User $user
       *
       * @return bool
      */
      public function view(User $user)
      {
            foreach($user->roles as $role){
                  if($roles->permissions->contains('slug', $this->slug.'.view')){
                        return true;
                  }
            }  
      }

      /**
       * If the user can create the model
       *
       * @User $user
       *
       * @return bool
      */
      public function create(User $user)
      {    
            
            foreach($user->roles as $role){
                  if($role->permissions->contains('slug', $this->slug.'.create')){
                        return true;
                  }
            } 
      }

      /**
       * If the user can upadate the model
       *
       * @User $user
       * @Post $post
       *
       * @return bool
      */
      public function update(User $user, $post)
      {
            if($this->manage($user, $post)){
                  return true;
            }
            foreach($user->roles as $role){
                  if($role->permissions->contains('slug', $this->slug.'.update')){
                        return true;
                  }
            } 
      }

      /**
       * If the user can delete the model
       *
       * @User $user
       * @Post $post
       *
       * @return bool
      */
      public function delete(User $user, $post)
      {
            if($this->manage($user, $post)){
                  return true;
            }
            foreach($user->roles as $role){
                  if($role->permissions->contains('slug', $this->slug.'.delete')){
                        return true;
                  }
            } 
      }

}
