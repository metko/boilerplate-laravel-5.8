<?php

namespace Tests\Setup;

use App\Post;
use App\Role;
use App\User;
use Illuminate\Support\Str;


class UserFactory{


   protected $role = "member";
   protected $withoutRole = false;

   public function withRole($role = null){
      $this->role = $role;
      return $this;
   }

   public function withoutRole(){
      $this->withoutRole = true;
      return $this;
   }

   public function create($attributes = []){
      if($this->withoutRole == false){
         factory(Role::class)->create([
            'name' => Str::title($this->role), 
            'slug' => Str::slug($this->role)
         ]);
      }
      $user = factory(User::class)->create($attributes);
      $user->attachRole(Str::slug($this->role));
      return $user;
   }
}