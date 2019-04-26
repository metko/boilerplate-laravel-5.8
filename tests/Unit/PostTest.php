<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use App\Comment;
use App\PostStatus;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
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
        $this->assertEquals(route('posts.show', $post->id), $post->path());
    }
    /** @test */
    public function it_has_path_admin()
    {	
        $post = PostFactory::create();
        $this->assertEquals('/admin/posts/' . $post->id, $post->path('admin'));
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

    // /** @test */
    // public function it_has_status()
    // {	
    //     $this->withoutExceptionHandling();  
    //     $post = PostFactory::create();
    //     $this->assertInstanceOf(PostStatus::class, $post->status);

    // }

    /** @test */
    public function it_has_last_update()
    {	
        $date = Carbon::now();
        $post = PostFactory::withComments(2)->create([
            'created_at' => $date
        ]);
        $date = $post->created_at->locale('pt');
        $date = ucfirst($date->shortDayName)." ".$date->day." ".ucfirst($date->shortMonthName)." ".$date->year;
        $this->assertEquals($date, $post->lastUpdate());
    }
}
