<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = "medias";
    
    public function subject()
    {
        return $this->morphTo();
    }
}
