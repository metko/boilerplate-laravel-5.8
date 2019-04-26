<?php

namespace Tests\Feature;

use App\Post;
use App\Role;
use App\User;
use App\Permission;
use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Facades\Tests\Setup\PermissionFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_all_the_posts_only_published()
    {	
        $this->withoutExceptionHandling();
        $post = PostFactory::create();
        $this->get(route('posts.index'))
                ->assertSee($post->title); 
    }

    /** @test */
    public function a_post_must_be_validated()  
    {	
        //$this->withoutExceptionHandling();
        $user = UserFactory::withRole('writer')->create();
        PermissionFactory::all();
        $action = Permission::whereSlug('post.create')->first();
        $user->roles->first()->attachPermissions($action);
        $this->actingAs($user)->post('/posts', [
                'title' => '',
                'body' => ''
            ])
            ->assertSessionHasErrors('title')
            ->assertSessionHasErrors('body');

        $this->assertDatabaseMissing('posts', ['owner_id' =>  $user->id]);
    }

}
