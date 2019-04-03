<?php

namespace Tests\Feature;

use App\Post;
use App\Role;
use App\User;
use Tests\TestCase;
use Facades\Tests\Setup\UserFactory;
use Facades\Tests\Setup\PostFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_see_a_post()
    {	
        //$this->withoutExceptionHandling();
        $post = Postfactory::create();
        $this->get($post->path())
                ->assertStatus(200)
                ->assertSee($post->title);
    }

    /** @test */
    public function members_cannot_manage_posts()
    {	
        //$this->withoutExceptionHandling();
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
    public function a_writter_can_create_a_post()
    {	
        //$this->withoutExceptionHandling();  
        $user = UserFactory::withRole('writer')->create();
        $this->actingAs($user)->post('/posts', [
            'title' => 'Hello', 'body' => 'body', 'owner_id' => $user->id
            ]
        );
        $this->assertDatabaseHas('posts', ['title' => 'Hello']);
    }

    /** @test */
    public function a_post_must_be_validated()
    {	
        //$this->withoutExceptionHandling();
        $user = UserFactory::withRole('writer')->create();
        $this->actingAs($user)->post('/posts', [
                'title' => '', 'body' => ''
            ])
            ->assertSessionHasErrors('title')
            ->assertSessionHasErrors('body');

        $this->assertDatabaseMissing('posts', ['owner_id' =>  $user->id]);
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
    public function a_writer_can_delete_his_post()
    {	
        //$this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $post = PostFactory::createdBy('writer')->ownedBy($user)->create();

        $this->actingAs($user)->delete($post->path())->assertStatus(302);
        $this->assertDatabaseMissing('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_writer_can_update_his_post()
    {	
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $post = PostFactory::createdBy('writer')->ownedBy($user)->create();

        $this->actingAs($user)
            ->patch($post->path(), ['title' => 'title changed', 'body' => "body changed"])
            ->assertRedirect($post->path());
        $this->assertDatabaseHas('posts', ['title' =>  'title changed']);
    }
 
}
