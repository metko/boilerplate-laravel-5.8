<?php

namespace Tests\Setup;

use App\Post;
use App\User;
use App\Role;


class PostFactory{

   protected $role = "member";

   public function createdBy($role){
      
      $this->role = $role;
      return $this;
      
   }

   public function ownedBy($user){
      
      $this->user = $user;
      return $this;
      
   }

   public function create(){

      factory(Role::class)->create([
         'name' => $this->role
      ]);

      $user = $this->user ?? factory(User::class)->create();

      $post = factory(Post::class)->create([
         'owner_id' => $user->id
      ]);
      
      $user->assignRole($this->role);

      

      return $post;
   }
}