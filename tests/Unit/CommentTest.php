<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use App\Comment;
use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\CommentFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_post()
    {	
        //$this->withoutExceptionHandling();
       
        $comment = CommentFactory::create();
        $this->assertInstanceOf(Post::class, $comment->post);
    }

    /** @test */
    public function it_has_path()
    {	
        $comment = CommentFactory::create();
        $this->assertEquals('/comments/'.$comment->id, $comment->path());
    }

    /** @test */
    public function it_has_owner()
    {	
        $comment = CommentFactory::create();
        $this->assertInstanceOf(User::class, $comment->owner);
    }
}
