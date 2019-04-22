<?php

namespace Tests\Setup;

use App\Role;
use Illuminate\Support\Str;

class RoleFactory{


   public function create($role){

      if(is_array($role)){
         foreach($role as $r){
            factory(Role::class)->create([
               'name' => Str::title($r),
               'slug' =>  Str::slug($r),
            ]);
         }
      }else{
         return factory(Role::class)->create([
            'name' => Str::title($role),
            'slug' =>  Str::slug($role),
         ]);;
      }
   

    
   }
}