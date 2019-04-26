<?php

namespace App\Traits;

use App\Permission;

trait Permissions
{
      protected $permissions = ['view', 'create', 'edit', 'delete'];
      protected $models = ['post', 'comment'];

      public function getPermissions(){
         return $this->permissions;
      }
      public function getModels(){
         return $this->models;
      }

      public function getAction($slug){
            return Permission::whereSlug($slug)->first();
      }
}
