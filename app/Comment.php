<?php

namespace App;

use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];


    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function owner()
    {	
        return $this->belongsTo(User::class);
    }

    public function addComment($body){
        
    }

    public function path()
    {	
        return '/comments/'.$this->id;
    }
    
    


}
