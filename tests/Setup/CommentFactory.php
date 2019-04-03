<?php

namespace Tests\Setup;

use App\Post;
use App\User;
use App\Comment;
 

class CommentFactory{


   public function createdBy($user){
      $this->user = $user;   
      return $this; 
   }

   public function withPost($post){
      
      $this->post = $post;
      return $this;
      
   }

   public function create(){
    $comment = factory(Comment::class)->create([
        'post_id' => $this->post ?? factory(Post::class)->create()->id,
        'owner_id' => $this->user ?? factory(User::class)->create()->id
    ]);

    return $comment;
   }
}