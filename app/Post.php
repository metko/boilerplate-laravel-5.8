<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];  

    public function path($admin = null){
        if($admin) {
            return "/admin/posts/".$this->id;
        }
        return route('posts.show', $this->id);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }


    public function status()
    {
        return $this->belongsTo(PostStatus::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest('id');
    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'subject');
    }

    public function excerpt()
    {	
        return \Illuminate\Support\Str::limit($this->body, 150, '...');
    }

    public function addComment($attributes)
    {
        return $this->comments()->create([
            'body' => $attributes['body'],
            'owner_id' => auth()->user()->id
        ]);
    }

    public function createPost($attributes)
    {   
        return $this->create([
            'title' => $attributes['title'],
            'body' => $attributes['body'],
            'owner_id' => auth()->user()->id,
        ]);
    }

    public function lastUpdate()
    {
        $date = $this->updated_at->locale('pt');
        return ucfirst($date->shortDayName)." ".$date->day." ".ucfirst($date->shortMonthName)." ".$date->year;
    }

}
