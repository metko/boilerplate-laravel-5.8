<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuestActiontest extends TestCase
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
        
        $this->post($post->path().'/comments', ['body' => 'This is a comment', 'post_id' => $post->id]);
        $this->assertDatabaseMissing('comments', ['body' => 'This is a comment'])
                ->assert->status(302);  
    }
    
}
