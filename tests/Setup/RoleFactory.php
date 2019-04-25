<?php

namespace Tests\Setup;

use App\Role;
use Illuminate\Support\Str;

class RoleFactory{

   protected $roles = ['Guest', 'Moderator', 'Writer', 'Admin', 'Super-Admin'];
   protected $level = 1;
   public function create($roles = null, $level = null){
      if(is_null($roles)){
         $i = 0;
         foreach($this->roles as $role){
               factory(Role::class)->create([
                  'name' => $role,
                  'slug' => Str::slug($role),
                  'description' => $role.' description',
                  'level' => $i,
               ]);
               $i++;
         }
      }elseif(is_array($roles)){
         foreach($role as $r){
            factory(Role::class)->create([
               'name' => Str::title($r['name']),
               'slug' =>  Str::slug($r['name']),
               'level' => $r['level']
            ]);
         }
      }else{
         return factory(Role::class)->create([
            'name' => Str::title($roles),
            'slug' =>  Str::slug($roles),
            'level' => $this->level
         ]);;
      }
   

    
   }
}