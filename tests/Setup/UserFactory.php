<?php

namespace Tests\Setup;

use App\Post;
use App\Role;
use App\User;
use Illuminate\Support\Str;
use Facades\Tests\Setup\RoleFactory;


class UserFactory{

   public function __construct(){
      RoleFactory::create();
   }

   protected $role = "guest";

   public function withRole($role = null){
      $this->role = $role;
      return $this;
   }

   public function withCount($count)
   {
      $this->count = $count;
      return $this;
   }

   public function create($attributes = []){
      
      $users = factory(User::class, $this->count ?? 1)->create($attributes);
      if(!empty($this->count)){
         foreach($users as $user){
            $user->attachRole(Str::slug($this->role));
         }
         return $users;
      }
      $users->first()->attachRole(Str::slug($this->role));
      return $users->first();
   }
}