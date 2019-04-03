<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
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
        //$this->withoutExceptionHandling();  
        $user = UserFactory::withRole('writer')->create();
        $this->actingAs($user)->post('/posts', [
            'title' => 'Hello', 'body' => 'body', 'owner_id' => $user->id
            ]
        );
        $this->assertDatabaseHas('posts', ['title' => 'Hello']);
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
 
}
