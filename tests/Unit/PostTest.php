<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_path()
    {	
        $post = factory(Post::class)->create();

        $this->assertEquals('/posts/' . $post->id, $post->path());
    }

     /** @test */
     public function it_has_owner()
     {	
         $post = factory(Post::class)->create();
         $this->assertinstanceOf(User::class, $post->owner);
     }
}
