<?php

namespace Tests\Setup;

use App\Post;
use App\Role;
use App\User;
use App\Comment;
use Illuminate\Support\Str;


class PostFactory{

   protected $role = "writer";
   protected $withoutRole = false;
   protected $commentsCount = false;


   public function ownedBy($user){
      $this->user = $user;
      return $this;
   }

   public function withComments($count = 1)
   {
      $this->commentsCount  = $count;
      return $this;
   }

   public function create(){
     
      if( empty($this->user )) {
         $this->user = factory(User::class)->create();
         $this->user->attachRole(Str::slug($this->role));
      }

      $post = factory(Post::class)->create([
         'owner_id' => $this->user->id
      ]);  

      if($this->commentsCount){
         factory(Comment::class, $this->commentsCount)->create(['post_id' => $post->id, 'owner_id' => $this->user->id]);
      }

      return $post;
   }
}