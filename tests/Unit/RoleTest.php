<?php

namespace Tests\Unit;

use App\Role;
use App\User;
use App\Permission;
use Tests\TestCase;
use Facades\Tests\Setup\PermissionFactory;
use Facades\Tests\Setup\RoleFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_has_getClass()
    {
        RoleFactory::create();
        $role = Role::first();
        $this->assertEquals('light', $role->getClass());
    }

    /** @test */
    public function it_has_users()
    {
        $users = UserFactory::withRole('writer')->create();
        $role = Role::whereSlug('writer')->first();
        $this->assertInstanceOf(User::class, $role->users->first());
    }

    /** @test */
    public function it_has_permissions()
    {
        $role = RoleFactory::withPermissions()->create('writer');
        $this->assertInstanceOf(Permission::class, $role->permissions->first());
    }

    /** @test */
    public function it_can_attach_a_permission()
    {
        $role = RoleFactory::create('writer');
        $permission = PermissionFactory::create();
        $role->attachPermissions($permission);
        $this->assertInstanceOf(Permission::class, $role->permissions->first());
    }

    /** @test */
    public function it_can_detach_a_permission()
    {
        $role = RoleFactory::withPermissions()->create('writer');
        $role->detachPermissions($role->permissions->first());
        $this->assertInstanceOf(Permission::class, $role->permissions->first());
    }

    /** @test */
    public function it_can_attach_permissions()
    {
        $role = RoleFactory::create('writer');
        $permissions = PermissionFactory::count(2)->create();
        $role->attachPermissions($permissions);
        $this->assertCount(2, $role->permissions);
    }

    /** @test */
    public function it_can_detach_all_permissions()
    {
        $role = RoleFactory::withPermissions(3)->create('writer');
        $role->detachPermissions();
        $this->assertCount(0, $role->permissions);
    }

    /** @test */
    public function a_role_must_have_permissions()
    {	
        $this->withoutExceptionHandling();
        $superAdmin = UserFactory::withRole('super-admin')->create();
        $role = Role::whereLevel(2)->first();
        $attributes = [
            "permissions" => []
        ];
        $this->actingAs($superAdmin)
            ->patch(route('admin.permissions.update', $role->id), $attributes)
            ->assertRedirect(route('admin.roles.show', $role->id));
    }

    /** @test */
    public function a_role_can_check_if_he_has_permissions()
    {	
        $role = RoleFactory::create('writer');
        $permissions = PermissionFactory::count(2)->create();
        $role->attachPermissions($permissions);
        $this->assertTrue($role->hasPermissions($permissions[0]));
    }

}
