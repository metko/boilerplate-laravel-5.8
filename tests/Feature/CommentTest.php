<?php

namespace Tests\Feature;

use App\Comment;
use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function a_comment_must_have_valide_data()
    {	
        
        //$this->withoutExceptionHandling();
        $user = UserFactory::create();
        $post = PostFactory::create();
        
        //Create no validated
        $this->actingAs($user)->post($post->path().'/comments', [
                'body' => 'Th',
                'post_id' => $post->id
            ]);
       
        $this->assertDatabaseMissing('comments', ['body' => 'The body']);
        //Create validated
        $this->actingAs($user)->post($post->path().'/comments', [
            'body' => 'The body',
            'post_id' => $post->id
        ]);
        $this->assertDatabaseHas('comments', ['body' => 'The body']);
         
        $comment = Comment::latest()->first();
        //update
        $this->actingAs($user)->patch($comment->path().'/comments', [
            'body' => 'The body changed',
            'post_id' => $post->id
        ]);
        $this->assertDatabaseMissing('comments', ['body' => 'The body changed']);
    }
}
