<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\CommentFactory;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberActionsTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function a_member_can_see_a_post()
    {	
        $user = UserFactory::create();
        $post = PostFactory::create();
        $this->actingAs($user)->get($post->path())
                ->assertStatus(200)
                ->assertSee($post->title);
    }

    /** @test */
    public function members_cannot_manage_posts()
    {	
        //Form to create a post
        $user = UserFactory::create();
        $post = PostFactory::create();
        $this->actingAs($user)->get('/posts/create')->assertStatus(403);

        //Can't a post
        $this->actingAs($user)->post('/posts', [
                'title' => 'Hello', 'body' => 'body', 'owner_id' => $user->id
                ]
            )->assertStatus(403);

        //Can't update a post
        $this->actingAs($user)->patch($post->path(), [
                'title' => 'Hello', 'body' => 'body'])
                ->assertStatus(403);
        $this->assertDatabaseMissing('posts', ['title' => 'Hello']);

        //Can't delete post
        $this->actingAs($user)->delete($post->path())->assertStatus(403);
        $this->assertDatabaseHas('posts', ['title' =>  $post->title]);
    }


    /** @test */
    public function a_member_can_create_a_comment()
    {	
        $user = UserFactory::create();
        $post = PostFactory::create();
       
        $this->actingAs($user)->post($post->path().'/comments', ['body' => 'This is a comment'] );
        $this->assertDatabaseHas('comments', ['body' => 'This is a comment']);
    }

    /** @test */
    public function a_member_can_update_his_comment()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::create();
        $comment = CommentFactory::createdBy($user)->create();

        $this->actingAs($user)->patch($comment->path(), ['body' => 'Comment changed'])
                ->assertRedirect($comment->post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment changed']);
    }

    /** @test */
    public function a_member_can_delete_his_comment()
    {	
        $user = UserFactory::create();
        $comment = CommentFactory::createdBy($user)->create();

        $this->actingAs($user)->delete($comment->path())->assertRedirect($comment->post->path());
        $this->assertDatabaseMissing('comments', ['body' => $comment->body]);   
    }

    /** @test */
    public function a_member_cannot_manage_comments_of_others()
    {	
        $user = UserFactory::create();
        $post = PostFactory::create();
        $comment = CommentFactory::withPost($post)->create();

        $this->actingAs($user)->patch($comment->path(),['body' => 'body changed']);
        $this->assertDatabaseMissing('comments', ['body' => 'body changed']);  

        $this->actingAs($user)->delete($comment->path());
        $this->assertDatabaseHas('comments', ['body' => $comment->body]);   
        $this->assertTrue($post->comments->contains($comment));
    }

    /** @test */
    public function a_member_cant_see_manage_posts_page()
    {	
        //$this->withoutExceptionHandling();
        $member = UserFactory::create();
        $post = PostFactory::create();
        $this->actingAs($member)->get(route('manage.posts'))->assertStatus(403);
    }


}
