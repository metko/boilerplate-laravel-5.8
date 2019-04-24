<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnauthenticatedUserActionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_unauthenticated_user_can_see_the_login_page()
    {	

        $this->get(route('login'))->assertStatus(200);
    }

    /** @test */
    public function an_unauthenticated_user_can_see_the_register_page()
    {	
        $this->get(route('register'))->assertStatus(200);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_manage_a_comment()
    {	
        //$this->withoutExceptionHandling();
        $post = PostFactory::create();

        $this->post($post->path().'/comments', ['body' => 'This is a comment', 'post_id' => $post->id])
                    ->assertStatus(403);
        $this->assertDatabaseMissing('comments', ['body' => 'This is a comment']);
               
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_accounts()
    {	
        $attributes = [
            'name' => 'new name',
            'email' => 'new@mail.com'
        ];
        $this->patch(route('profile.update', $attributes))->assertStatus(403);  
        $this->assertDatabaseMissing('users', $attributes);
    }
    
}
