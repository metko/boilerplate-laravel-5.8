<?php

namespace Tests\Feature;

use App\Post;
use App\Role;
use App\User;
use App\Permission;
use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Support\Facades\Hash;
use Facades\Tests\Setup\CommentFactory;
use Facades\Tests\Setup\PermissionFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WriterActionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_writter_can_create_a_post()
    {	
        $writer = UserFactory::withRole('writer')->create();
        PermissionFactory::all();
        $action = Permission::whereSlug('post.create')->first();
        $writer->roles->first()->attachPermissions($action);
        $post = ['title' => 'new title', 'body' => "new body"];
        
        $this->actingAs($writer)->post('/posts', $post);
        $this->assertDatabaseHas('posts', $post);
    }
     
    /** @test */
    public function a_writer_can_delete_his_post()
    {	
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($writer)->create();
        $this->actingAs($writer)->delete($post->path())->assertStatus(302);
        $this->assertDatabaseMissing('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_writer_can_update_his_post()
    {	
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($writer)->create();
       
        $this->actingAs($writer)
            ->patch($post->path(), ['title' => 'title changed', 'body' => "body changed"])
            ->assertRedirect($post->path());
        $this->assertDatabaseHas('posts', ['title' =>  'title changed']);
    }

    /** @test */
    public function a_writer_cannot_manage_a_post_from_other_writer()
    {	
        //$this->withoutExceptionHandling();
        $writer =  UserFactory::withRole('writer')->create();
        $post = PostFactory::create();

        //update post 
        $this->actingAs($writer)
            ->patch($post->path(), ['title' => 'title changed', 'body' => "body changed"])
            ->assertStatus(403);
        $this->assertDatabaseMissing('posts', ['title' =>  "title changed"]);

        //delete post
        $this->actingAs($writer)->delete($post->path());
        $this->assertDatabaseHas('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_writer_can_post_a_comment()
    {	
        $this->withoutExceptionHandling();
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::create();

        $this->actingAs($writer)->post($post->path().'/comments', ['body' => 'this is a com from a writer'])
                ->assertRedirect($post->path());
        // $this->assertDatabaseHas('comments', ['body' => 'this is a com from a writer']);
        // $this->assertCount(1, $post->comments);
    }

    /** @test */
    public function a_writer_cannot_delete_comments_not_owned_by_him()
    {	
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::withComments(2)->create();

        $comment = $post->comments->first();
        $this->actingAs($writer)->delete($comment->path());
        $this->assertDatabaseHas('comments', $comment->toArray());
    }

    /** @test */
    public function a_writer_cannot_update_comments_not_owned_by_him()
    {	
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::withComments(2)->create();
        $comment = $post->comments->first();
        $this->actingAs($writer)->patch($comment->path(), ['body' => 'new comment']);
        $this->assertDatabaseHas('comments', $comment->toArray() );
    }

    /** @test */
    public function a_writer_can_delete_comments_on_post_owned_by_him()
    {	
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($writer)->withComments(2)->create();

        $comment = $post->comments->first();
        $this->actingAs($writer)->delete($comment->path())
                ->assertRedirect($post->path());
        $this->assertDatabaseMissing('comments', $comment->toArray());
    }

    /** @test */
    public function a_writer_can_update_comments_on_post_owned_by_him()
    {	
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($writer)->withComments(2)->create();

        $this->actingAs($writer)->patch($post->comments->first()->path(), ['body' => 'lalala'])
                ->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'lalala']);
    }

    /** @test */
    public function a_writer_can_access_to_manage_posts_page()
    {	
        $writer = UserFactory::withRole('writer')->create();
        PermissionFactory::all();
        $createPost = Permission::whereSlug('post.create')->first();

        $writer->roles->first()->attachPermissions($createPost);
        $this->actingAs($writer)->get(route('manage.posts'))
            ->assertStatus(200);
    }

    /** @test */
    public function a_writer_and_also_moderator_can_access_to_manage_posts_page()
    {	
        //$this->withoutExceptionHandling();
        $user = UserFactory::withRole('moderator')->create();
        PermissionFactory::all();
        $createPost = Permission::whereSlug('post.create')->first();
        $user->attachRole('writer');
        $user->roles->first()->attachPermissions($createPost);
        $this->actingAs($user)->get(route('manage.posts'))
            ->assertStatus(200);
    }

     
}
