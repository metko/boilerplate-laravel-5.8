<?php

namespace Tests\Setup;

use App\Post;
use App\User;
use App\Role;


class PostFactory{

   protected $defaultRole = "writer";

   public function createdBy($role){
      
      $this->defaultRole = $role;
      return $this;
      
   }

   public function ownedBy($user){
      
      $this->user = $user;
      return $this;
      
   }

   public function create(){

      factory(Role::class)->create([
         'name' => $this->defaultRole
      ]);

      $user = $this->user ?? factory(User::class)->create();

      $post = factory(Post::class)->create([
         'owner_id' => $user->id
      ]);
      
      $user->assignRole($this->defaultRole);

      

      return $post;
   }
}