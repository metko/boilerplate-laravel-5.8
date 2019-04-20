<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuestActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_see_the_login_page()
    {	
        $this->get(route('login'))->assertStatus(200);
    }

    /** @test */
    public function a_guest_can_see_the_register_page()
    {	
        $this->get(route('register'))->assertStatus(200);
    }

    /** @test */
    public function a_guest_cannot_manage_a_comment()
    {	
        //$this->withoutExceptionHandling();
        $post = PostFactory::create();

        $this->post($post->path().'/comments', ['body' => 'This is a comment', 'post_id' => $post->id])
                    ->assertStatus(302);
        $this->assertDatabaseMissing('comments', ['body' => 'This is a comment']);
               
    }

    /** @test */
    public function a_guest_cannot_update_accounts()
    {	
        //$this->withoutExceptionHandling();
        $attributes = [
            'email' => 'new@mail.com',
            'name' => 'new name'
        ];
        $this->patch( route('profil.update', $attributes))->assertStatus(302);  
        $this->assertDatabaseMissing('users', $attributes);
    }
    
}
