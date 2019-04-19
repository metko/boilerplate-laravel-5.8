<?php

namespace Tests\Setup;

use App\Post;
use App\User;
use App\Role;


class UserFactory{


   private $role = null;
   protected $defaultRole = "member";

   public function withRole($role = null){
      
      if($role){
         $this->role = $role;
      }else{
         $this->role = $this->defaultRole;
      }

      return $this;
      
   }

   public function create($attributes = []){

      
      if($this->role){
         
         factory(Role::class)->create([
            'name' => $this->role
         ]);
      }
      


      $user = factory(User::class)->create($attributes);

      if($this->role){
         $user->assignRole($this->role);
         
      }
      return $user;
   }
}