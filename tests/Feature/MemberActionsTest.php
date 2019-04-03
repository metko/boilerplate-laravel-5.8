<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberActionsTest extends TestCase
{

    use RefreshDatabase;

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
}
