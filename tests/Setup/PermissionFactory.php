<?php

namespace Tests\Setup;

use App\Permission;
use Illuminate\Support\Str;
 

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
            'all', 'view' , 'create' , 'update', 'delete' 
         ],
         'PostComment' => [
            'all', 'view' , 'create' , 'update', 'delete' 
         ],
      ];
      foreach($permissions as $modelName => $actions){
         foreach($actions as $action){
            factory(Permission::class)->create([
               'name' => $action,
               'slug' => Str::snake($modelName).".".$action,
               'description' => $modelName. ' '.$action. ' description',
               'model' => $modelName 
            ]);
         }   
      }
      return;
   }


}