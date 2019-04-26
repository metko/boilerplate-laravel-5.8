<?php

namespace Tests\Setup;

use App\Permission;
 

class PermissionFactory{

   protected $count = 1;

   public function count($count){
      $this->count = $count;
      return $this;  
   }

   public function create($attributes = []){

      $permission = factory(Permission::class, $this->count)->create($attributes);
      if($this->count == 1){
         return $permission->first();
      }
      return $permission;
   }

   public function all(){
      $permissions = [
         'Post' => [
            'all', 'view' , 'create' , 'edit', 'delete' 
         ],
         'Comment' => [
            'all', 'view' , 'create' , 'edit', 'delete' 
         ],
      ];
      foreach($permissions as $modelName => $actions){
         foreach($actions as $action){
            factory(Permission::class)->create([
               'name' => $action,
               'slug' => strtolower($modelName).".".$action,
               'description' => $modelName. ' '.$action. ' description',
               'model' => $modelName 
            ]);
         }   
      }
      return;
   }


}