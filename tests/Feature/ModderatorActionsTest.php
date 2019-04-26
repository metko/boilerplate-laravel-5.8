<?php

namespace Tests\Feature;

use App\Permission;
use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Facades\Tests\Setup\PermissionFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModderatorActionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_moderator_can_manage_all_comments()
    {
        $this->withoutExceptionHandling();
        $moderator = UserFactory::withRole('moderator')->create();
        $post = PostFactory::withComments(2)->create();
        PermissionFactory::all();
        
        $permissions = Permission::whereModel('PostComment')->get();
        
        $moderator->roles->first()->attachPermissions($permissions);
        //dd( $moderator->roles->first()->permissions);
        $this->actingAs($moderator)->patch($post->comments->first()->path(), ['body' => 'new body']);
        $this->assertdatabaseHas('comments', ['body' => 'new body']);
    }
}
