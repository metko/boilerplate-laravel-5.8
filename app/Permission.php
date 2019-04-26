<?php

namespace App;

use App\Permission;
use App\Traits\Permissions;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use Permissions;

    protected $guarded = [];
 
    public function roles()
    {
        return $this->belongsToMany(Role::class); 
    }

    public function createPermission($model){
        $model = $model['model'];

        foreach($this->getPermissions() as $perm){
            $attributes =  [
                'name' => ucfirst($perm).' '.strtolower($model),
                'slug' => strtolower($model).'.'.$perm,
                'description' => $model.' '.$perm.' description',
                'model' => ucfirst($model)
            ];
            $this->create($attributes);
        }
        return true;
      
    }

}
