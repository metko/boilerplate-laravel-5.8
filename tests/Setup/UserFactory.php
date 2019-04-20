<?php

namespace Tests\Setup;

use App\Post;
use App\User;
use App\Role;


class UserFactory{


   private $role = null;
   protected $defaultRole = "member";

   public function withRole($role = null){
      
      $this->role = $role;
      return $this;
      
   }

   public function create($attributes = []){

     $role = $this->role ?? $this->defaultRole;
      
      
      factory(Role::class)->create([
         'name' => $role
      ]);
      
      $user = factory(User::class)->create($attributes);
      $user->assignRole($role);
      return $user;
   }
}