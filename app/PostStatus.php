<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostStatus extends Model
{
    protected $table = 'post_status';

    public function post()
    {
        return $this->hasMany(Post::class);
    }
}
