<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   protected $guarded = [];
    
   public function users()
   {
      return $this->belongsToMany(User::class)->withTimestamps();
   }

   public function permissions()
   { 
      return $this->belongsToMany(Permission::class)->withTimestamps();
   }

   public function attachPermissions($permission)
   { 
      if(is_array($permission)){
         foreach($permission as $p){
            $this->permissions()->attach($p);
         }
         return;
      }
      return $this->permissions()->attach($permission);
   }

   public function detachPermissions($permission = null)
   { 
      if($permission){
         return $this->permissions()->detach($permission);
      }
      return $this->permissions()->detach();
   }

   public function getClass()
   {
      if($this->level == 0){
         return 'light';
      }elseif($this->level == 1){
         return 'primary';
      }elseif($this->level == 2){
         return 'dark';
      }elseif($this->level == 3){
         return 'info';
      }elseif($this->level == 4){
         return 'warning';
      }
   }
}