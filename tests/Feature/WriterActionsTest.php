<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Facades\Tests\Setup\CommentFactory;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WriterActionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_writter_can_create_a_post()
    {	
        $user = UserFactory::withRole('writer')->create();
        $post = ['title' => 'new title', 'body' => "new body"];
        
        $this->actingAs($user)->post('/posts', $post);
        $this->assertDatabaseHas('posts', $post);
    }
     
    /** @test */
    public function a_writer_can_delete_his_post()
    {	
        $user = factory(User::class)->create();
        $post = PostFactory::createdBy('writer')->ownedBy($user)->create();
        $this->actingAs($user)->delete($post->path())->assertStatus(302);
        $this->assertDatabaseMissing('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_writer_can_update_his_post()
    {	
        $user = factory(User::class)->create();
        $post = PostFactory::createdBy('writer')->ownedBy($user)->create();
        $this->actingAs($user)
            ->patch($post->path(), ['title' => 'title changed', 'body' => "body changed"])
            ->assertRedirect($post->path());
        $this->assertDatabaseHas('posts', ['title' =>  'title changed']);
    }

    /** @test */
    public function a_writer_cannot_manage_a_post_from_other_writer()
    {	
        //$this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $post = PostFactory::createdBy('writer')->create();
        //update post 
        $this->actingAs($user)
            ->patch($post->path(), ['title' => 'title changed', 'body' => "body changed"])
            ->assertStatus(403);
        $this->assertDatabaseMissing('posts', ['title' =>  "title changed"]);

        //delete post
        $this->actingAs($user)->delete($post->path());
        $this->assertDatabaseHas('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_writer_can_post_a_comment()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('writer')->create();
        $post = PostFactory::create();
        $this->actingAs($user)->post($post->path().'/comments', ['body' => 'this is a com from a writer']);
        $this->assertDatabaseHas('comments', ['body' => 'this is a com from a writer']);
        $this->assertCount(1, $post->comments);
    }

    /** @test */
    public function a_writer_cannot_delete_comments_not_owned_by_him()
    {	
        $user = UserFactory::withRole('writer')->create();
        $comment = CommentFactory::create();
        $this->actingAs($user)->delete($comment->path());
        $this->assertDatabaseHas('comments', $comment->toArray());
    }

    /** @test */
    public function a_writer_cannot_update_comments_not_owned_by_him()
    {	
        $user = UserFactory::withRole('writer')->create();
        $comment = CommentFactory::create();
        $this->actingAs($user)->patch($comment->path(), ['body' => 'new comment']);
        $this->assertDatabaseHas('comments', $comment->toArray() );
    }

    /** @test */
    public function a_writer_can_delete_comments_on_post_owned_by_him()
    {	
        //$this->withoutExceptionHandling();
        $user = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($user)->create();
        $comment = CommentFactory::withPost($post)->create();
        $this->actingAs($user)->delete($comment->path());
        $this->assertDatabaseMissing('comments', $comment->toArray());
    }

    /** @test */
    public function a_writer_can_update_comments_on_post_owned_by_him()
    {	
        //$this->withoutExceptionHandling();
        $user = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($user)->create();
        $comment = CommentFactory::withPost($post)->create();
        $this->actingAs($user)->patch($comment->path(), ['body' => 'lalala']);
        $this->assertDatabaseHas('comments', ['body' => 'lalala']);
    }
 
}
