<?php

namespace App\Traits;

use App\User;
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
      public function manage(User $user, $model)
      {
            $pivot = $this->getPivot();
            if($user->id == $model->owner_id){
                  return true;
            }elseif($pivot != $this->slug){
                  return $user->id == $model->$pivot->owner_id;
            }
      }

      /**
       * getPivot
       *
       * @return void
       */
      public function getPivot(){
            return explode('_', $this->slug)[0];
      }
        
      /**
       * If the user van view the model
       *
       * @User $user
       *
       * @return bool
      */
      public function view(User $user, $model)
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
      public function update(User $user, $model)
      {
            if($this->manage($user, $model)){
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
      public function delete(User $user, $model)
      {
            if($this->manage($user, $model )){
                  return true;
            }
            foreach($user->roles as $role){
                  if($role->permissions->contains('slug', $this->slug.'.delete')){
                        return true;
                  }
            } 
      }

      /**
     * Determine whether the user can restore the test.
     *
     * @param  \App\User  $user
     * @param  \App\Model  $model
     * @return mixed
     */
    public function restore(User $user, $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the test.
     *
     * @param  \App\User  $user
     * @param  \App\Model  $model
     * @return mixed
     */
    public function forceDelete(User $user, $model)
    {
        //
    }

}
