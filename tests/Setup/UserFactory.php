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

   public function create($attributes = []){
      
      $user = factory(User::class)->create($attributes);
      $user->attachRole(Str::slug($this->role));
      return $user;
   }
}