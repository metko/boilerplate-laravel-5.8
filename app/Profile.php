<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];
    protected $touches = ['User'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
