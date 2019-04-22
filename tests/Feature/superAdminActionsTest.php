<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\CommentFactory;
use Facades\Tests\Setup\UserFactory;
use Facades\Tests\Setup\PostFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuperAdminActionsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_superadmin_can_create_post()
    {
        $superAdmin = UserFactory::withRole('super-admin')->create();
        //create post 
        $this->actingAs($superAdmin)
            ->post("/posts", ['title' => 'title', 'body' => "body"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title", 'body' => "body" ]);  
    }
    /** @test */
    public function a_superdmin_can_manage_a_post_from_others()
    {	
        $superAdmin = UserFactory::withRole('super-admin')->create();
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($writer)->create();
        //update post 
        $this->actingAs($superAdmin)
            ->patch($post->path(), ['title' => 'title changed', 'body' => "body changed"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title changed", 'body' => "body changed" ]);

        //delete post
        $this->actingAs($superAdmin)->delete($post->path());
        $this->assertDatabaseMissing('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_superadmin_can_add_comments(){

        $superAdmin = UserFactory::withRole('super-admin')->create();
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($writer)->create();
        
        //update post 
        $this->actingAs($superAdmin)
            ->post($post->path().'/comments', ['body' => 'Comment from super-admin'])
            ->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment from super-admin']);  
    }

    /** @test */
    public function a_superadmin_can_manage_any_comments()
    {
        $superAdmin = UserFactory::withRole('super-admin')->create();
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($writer)->withComments(2)->create();
        
        //update post 
        $this->actingAs($superAdmin)
            ->patch( $post->comments->first()->path(), ['body' => 'Comment changed from super-admin'])->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment changed from super-admin']);  
    }

}
