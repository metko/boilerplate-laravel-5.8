<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use App\Comment;
use Tests\TestCase;
use Facades\Tests\Setup\UserFactory;
use Facades\Tests\Setup\CommentFactory;
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

    /** @test */
    public function it_can_add_a_comment()
    {	
        $this->signIn();
        $post = factory(Post::class)->create();
        $comment = $post->addComment(['body' => 'My comment']);
        $this->assertCount(1, $post->comments); 
        $this->assertTrue($post->comments->contains($comment));
    }

    /** @test */
    public function it_has_comments()
    {	
        $post = factory(Post::class)->create();
        $comment1 = CommentFactory::withPost($post)->create();
        $this->assertInstanceOf(Comment::class, $post->comments->first());
    }
}
