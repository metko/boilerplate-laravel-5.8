<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\CommentFactory;
use Facades\Tests\Setup\UserFactory;
use Facades\Tests\Setup\PostFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class superAdminActionsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_superadmin_can_create_post(){

        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('super_admin')->create();
        //create post 
        $this->actingAs($user)
            ->post("/posts", ['title' => 'title', 'body' => "body"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title", 'body' => "body" ]);  
    }
    /** @test */
    public function a_superdmin_can_manage_a_post_from_others()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('super_admin')->create();
        $post = PostFactory::createdBy('writer')->create();
        //update post 
        $this->actingAs($user)
            ->patch($post->path(), ['title' => 'title changed', 'body' => "body changed"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title changed", 'body' => "body changed" ]);

        //delete post
        $this->actingAs($user)->delete($post->path());
        $this->assertDatabaseMissing('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_superadmin_can_add_comments(){

        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('super_admin')->create();
        $post = PostFactory::createdBy('writer')->create();
        
        //update post 
        $this->actingAs($user)
            ->post($post->path().'/comments', ['body' => 'Comment from super-admin'])
            ->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment from super-admin']);  
    }

    /** @test */
    public function a_superadmin_can_manage_any_comments(){

        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('super_admin')->create();
        $post = PostFactory::createdBy('writer')->create();
        $comment = CommentFactory::withPost($post)->create();
        
        //update post 
        $this->actingAs($user)
            ->patch( $comment->path(), ['body' => 'Comment changed from super-admin'])->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment changed from super-admin']);  
    }
}
