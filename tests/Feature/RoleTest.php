<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Permission;
use Tests\TestCase;
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
        $this->withoutExceptionHandling();
        RoleFactory::create();
        $role = Role::first();
        $this->assertEquals('light', $role->getClass());
    }

    /** @test */
    public function it_has_users()
    {
        //$this->withoutExceptionHandling();
        $users = UserFactory::withCount(3)->withRole('writer')->create();
        $role = Role::whereSlug('writer')->first();
        $this->assertEquals(3, $role->users->count());
        $this->assertInstanceOf(User::class, $role->users->first());
    }

    /** @test */
    public function it_has_permissions()
    {
        $this->withoutExceptionHandling();
        $role = RoleFactory::create('writer');
        $permission = factory(Permission::class)->create();
        $role->permissions()->attach($permission);
        $this->assertInstanceOf(Permission::class, $role->permissions->first());
    }

    

    /** @test */
    public function it_can_attach_a_permission()
    {
        $this->withoutExceptionHandling();
        $role = RoleFactory::create('writer');
        $permission = factory(Permission::class)->create();
        $role->attachPermissions($permission);
        $this->assertInstanceOf(Permission::class, $role->permissions->first());
    }

    /** @test */
    public function it_can_detach_a_permission()
    {
        $this->withoutExceptionHandling();
        $role = RoleFactory::create('writer');
        $permission = factory(Permission::class)->create();
        $role->attachPermissions($permission);
        $this->assertInstanceOf(Permission::class, $role->permissions->first());
        $role->detachPermissions($permission);
        $this->assertInstanceOf(Permission::class, $role->permissions->first());
    }

    /** @test */
    public function it_can_attach_permissions()
    {
        $this->withoutExceptionHandling();
        $role = RoleFactory::create('writer');
        $permission1 = factory(Permission::class)->create();
        $permission2 = factory(Permission::class)->create();
        $role->attachPermissions([$permission1, $permission2]);
        $this->assertInstanceOf(Permission::class, $role->permissions->first());
        $this->assertCount(2, $role->permissions);
    }

    /** @test */
    public function it_can_detach_all_permissions()
    {
        $this->withoutExceptionHandling();
        $role = RoleFactory::create('writer');
        $permission1 = factory(Permission::class)->create();
        $permission2 = factory(Permission::class)->create();
        $role->attachPermissions([$permission1, $permission2]);
        $this->assertCount(2, $role->permissions);
        $role->detachPermissions();
        $role->refresh();
        $this->assertCount(0, $role->permissions);

    }

    

    


}
