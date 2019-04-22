<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use App\Comment;
use Tests\TestCase;
use Illuminate\Support\Str;
use Facades\Tests\Setup\PostFactory;
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
        $post = PostFactory::create();
        $this->assertEquals('/posts/' . $post->id, $post->path());
    }

    /** @test */
    public function it_has_owner()
    {	
         $post = PostFactory::create();
         $this->assertinstanceOf(User::class, $post->owner);
    }

    /** @test */
    public function it_has_add_a_comment()
    {	
        $this->signIn();
        $post = PostFactory::create();
        $comment = $post->addComment(['body' => 'My comment']);
        $this->assertCount(1, $post->comments); 
        $this->assertTrue($post->comments->contains($comment));
    }

    /** @test */
    public function it_has_excerpt()
    {	
        $this->signIn();
        $post = PostFactory::create();
        $this->assertEquals($post->excerpt(), Str::limit($post->body, 150, '...'));
    }

    /** @test */
    public function it_can_createPost()
    {	
        $this->signIn();
        $attributes = [
            'title' => 'A title', 'body' => 'A body'
        ];
        $post = new Post();
        $post->createPost($attributes);
        $this->assertDatabaseHas('posts', $attributes);
    }
    /** @test */
    public function it_has_comments()
    {	
        $post = PostFactory::withComments(2)->create();
        $this->assertInstanceOf(Comment::class, $post->comments->first());
        $this->assertEquals(2, $post->comments->count());
    }
}
