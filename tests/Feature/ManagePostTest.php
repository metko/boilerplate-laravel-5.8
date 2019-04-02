<?php

namespace Tests\Feature;

use App\Post;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_see_a_post()
    {	
        $this->withoutExceptionHandling();
        $post = factory(Post::class)->create();
        $this->get($post->path())
                ->assertStatus(200)
                ->assertSee($post->title);
    }

     /** @test */
     public function a_writter_can_create_a_post()
     {	
         $this->withoutExceptionHandling();
         $user = factory(User::class)->create();
         $role = factory(Role::class)->create(['name' => 'writer']);
         $user->assignRole('writer');
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
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => 'writer']);
        $user->assignRole('writer');
        $this->actingAs($user)->post('/posts', [
            'title' => '', 'body' => ''
            ]
        )->assertSessionHasErrors('title')
        ->assertSessionHasErrors('body');

       $this->assertDatabaseMissing('posts', ['owner_id' =>  $user->id]);
     }


     /** @test */
     public function a_member_cannot_create_a_post()
     {	
         //$this->withoutExceptionHandling();
         $user = factory(User::class)->create();
         $this->actingAs($user)->post('/posts', [
             'title' => 'Hello', 'body' => 'body', 'owner_id' => $user->id
             ]
        );
        $this->assertDatabaseMissing('posts', ['title' => 'Hello']);
     }

     /** @test */
     public function a_member_cannot_see_the_create_form()
     {	
         //$this->withoutExceptionHandling();
         $user = factory(User::class)->create();
         $this->actingAs($user)->get('/posts/create')->assertStatus(403);
     }

     /** @test */
     public function a_member_cannot_delete_a_post()
     {	
        //$this->withoutExceptionHandling();
        $post = factory(Post::class)->create();
        $user = factory(User::class)->create();
        $this->actingAs($user)->delete($post->path());
        $this->assertDatabaseHas('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_writer_cannot_delete_a_post_from_other_writer()
    {	
       //$this->withoutExceptionHandling();
       $post = factory(Post::class)->create();
       $user = factory(User::class)->create();
       $role = factory(Role::class)->create(['name' => 'writer']);
       $user->assignRole('writer');
       $this->actingAs($user)->delete($post->path());
       $this->assertDatabaseHas('posts', ['title' =>  $post->title]);
   }

   /** @test */
   public function a_writer_can_delete_his_post()
   {	
      $this->withoutExceptionHandling();
      $role = factory(Role::class)->create(['name' => 'writer']);
      $user = factory(User::class)->create();
      $user->assignRole('writer');
      $user2 = factory(User::class)->create();
      $post = factory(Post::class)->create(['owner_id' => $user->id]);
      $this->actingAs($user)->delete($post->path());
      $this->assertDatabaseMissing('posts', ['title' =>  $post->title]);
  }
   
}
