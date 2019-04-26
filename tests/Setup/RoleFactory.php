<?php

namespace Tests\Setup;

use App\Role;
use Illuminate\Support\Str;
use Facades\Tests\Setup\PermissionFactory;

class RoleFactory{

   protected $roles = ['Guest', 'Member',  'Moderator', 'Writer', 'Admin', 'Super-Admin'];
   protected $level = 1;


   public function withPermissions($count = 1){
         $this->permissions = PermissionFactory::count($count)->create();
         return $this;
   }

   public function create($roles = null, $level = null){
      if(is_null($roles)){
         $i = 0;
         foreach($this->roles as $role){
               $roles = factory(Role::class)->create([
                  'name' => $role,
                  'slug' => Str::slug($role),
                  'description' => $role.' description',
                  'level' => $i,
               ]);
               if(isset($this->permissions)){
                  $roles->attachPermissions($this->permissions);
               }
               $i++;
         }
      }elseif(is_array($roles)){
         foreach($role as $r){
            $roles = factory(Role::class)->create([
               'name' => Str::title($r['name']),
               'slug' =>  Str::slug($r['name']),
               'level' => $r['level']
            ]);
            if(isset($this->permissions)){
               $roles->attachPermissions($this->permissions);
            }
         }
      }else{
         $roles = factory(Role::class)->create([
            'name' => Str::title($roles),
            'slug' =>  Str::slug($roles),
            'level' => $this->level
         ]);
         if(isset($this->permissions)){
            $roles->attachPermissions($this->permissions);
         }
      }

      return $roles;
   

    
   }
}