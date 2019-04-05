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
    public function can_view_all_the_posts()
    {	
        $this->withoutExceptionHandling();
        $post1 = PostFactory::create();
        $post2 = PostFactory::create();
        $post3 = PostFactory::create();
        $this->get(route('posts'))
                ->assertSee($post1->title)
                ->assertSee($post2->title)
                ->assertSee($post3->title);
    }

    /** @test */
    public function a_post_must_be_validated()
    {	
        //$this->withoutExceptionHandling();
        $user = UserFactory::withRole('writer')->create();
        $this->actingAs($user)->post('/posts', [
                'title' => '',
                'body' => ''
            ])
            ->assertSessionHasErrors('title')
            ->assertSessionHasErrors('body');

        $this->assertDatabaseMissing('posts', ['owner_id' =>  $user->id]);
    }

    

}
