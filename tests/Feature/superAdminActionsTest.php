<?php

namespace Tests\Feature;

use App\Role;
use App\Permission;
use Tests\TestCase;
use Illuminate\Support\Arr;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Facades\Tests\Setup\CommentFactory;
use Facades\Tests\Setup\PermissionFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuperAdminActionsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_superadmin_can_create_post()
    {
        $superAdmin = UserFactory::withRole('super-admin')->create();
        //create post 
        $this->actingAs($superAdmin)
            ->post("/posts", ['title' => 'title', 'body' => "body"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title", 'body' => "body" ]);  
    }
    /** @test */
    public function a_superdmin_can_manage_a_post_from_others()
    {	
        $superAdmin = UserFactory::withRole('super-admin')->create();
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($writer)->create();
        //update post 
        $this->actingAs($superAdmin)
            ->patch($post->path(), ['title' => 'title changed', 'body' => "body changed"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title changed", 'body' => "body changed" ]);

        //delete post
        $this->actingAs($superAdmin)->delete($post->path());
        $this->assertDatabaseMissing('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_superadmin_can_add_comments(){

        $superAdmin = UserFactory::withRole('super-admin')->create();
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($writer)->create();
        
        //update post 
        $this->actingAs($superAdmin)
            ->post($post->path().'/comments', ['body' => 'Comment from super-admin'])
            ->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment from super-admin']);  
    }

    /** @test */
    public function a_superadmin_can_manage_any_comments()
    {
        $superAdmin = UserFactory::withRole('super-admin')->create();
        $writer = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($writer)->withComments(2)->create();
        
        //update post 
        $this->actingAs($superAdmin)
            ->patch( $post->comments->first()->path(), ['body' => 'Comment changed from super-admin'])->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment changed from super-admin']);  
    }



    /** @test */
    // public function a_superadmin_can_create_roles()
    // {	
    //     $superAdmin = UserFactory::withRole('super-admin')->create();
    //     $this->actingAs($superAdmin)
    //         ->post(route('admin.roles.create'), ['name' => 'Comment changed from super-admin'])->assertRedirect($post->path());
    // }
    
    /** @test */
    public function a_superadmin_can_see_roles()
    {	
        $this->withoutExceptionHandling();
        $superAdmin = UserFactory::withRole('super-admin')->create();
        $roles = Role::all();
        $this->actingAs($superAdmin)
            ->get(route('admin.roles.index'))->assertSee($roles->first()->name);
    }

    /** @test */
    public function a_superadmin_can_see_permissions_of_roles()
    {	
        $this->withoutExceptionHandling();
        $superAdmin = UserFactory::withRole('super-admin')->create();
        $role = Role::whereLevel(2)->first();
        $this->actingAs($superAdmin)
            ->get(route('admin.roles.show', $role->id))->assertSee($role->name);
    }

    /** @test */
    public function a_superadmin_can_attribute_permissions_of_a_role()
    {	
        PermissionFactory::all();
        $this->withoutExceptionHandling();
        $superAdmin = UserFactory::withRole('super-admin')->create();
        $role = Role::whereLevel(2)->first();    
        $permission = Permission::whereModel('Post')->whereName('update')->first();
        $permission2 = Permission::whereModel('PostComment')->whereName('create')->first();
        $attributes = [
            "permissions" => [
                $permission->id => 1,
                $permission2->id => 1
            ]
        ];
        $this->actingAs($superAdmin)
            ->patch(route('admin.permissions.update', $role->id), $attributes);
        //dd($permission);
        $this->assertTrue($role->hasPermissions($permission));
        $this->assertTrue($role->hasPermissions($permission2));
        $this->assertDatabaseHas('permission_role', [
            'role_id' => $role->id, 'permission_id' => $permission->id,
            'role_id' => $role->id, 'permission_id' => $permission2->id
        ]);
    }
    /** @test */
    public function a_superadmin_can_can_create_set_of_permission()
    {
        $this->withoutExceptionHandling();
        $superAdmin = UserFactory::withRole('super-admin')->create();
        $attributes = [
            'model' =>  'Post'
        ];
        $this->actingAs($superAdmin)->post(route('admin.permissions.store'), $attributes);
        $this->assertDatabaseHas('permissions', [
            'name' => 'Create post',
        ]);
    }




}
