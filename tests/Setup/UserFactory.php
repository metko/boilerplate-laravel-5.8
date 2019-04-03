<?php

namespace Tests\Setup;

use App\Post;
use App\User;
use App\Role;


class UserFactory{

   protected $role = "member";


   public function withRole($role){
      
      $this->role = $role;
      return $this;
      
   }

   public function create(){

      factory(Role::class)->create([
         'name' => $this->role
      ]);

      $user = factory(User::class)->create();
      $user->assignRole($this->role);
      
      return $user;
   }
}