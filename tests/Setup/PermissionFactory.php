<?php

namespace Tests\Setup;

use App\Permission;
 

class PermissionFactory{

   protected $count = 1;
   public function count($count){
      $this->count = $count;
      return $this;  
   }

   public function create(){
    $permission = factory(Permission::class, $this->count)->create([
        
    ]);
    if($this->count == 1){
      return $permission->first();
    }
    return $permission;
    
   }
}