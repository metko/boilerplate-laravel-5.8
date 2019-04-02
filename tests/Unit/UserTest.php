<?php

namespace Tests\Unit;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_role()
    {	
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user->assignRole($role->name);
        $this->assertInstanceOf(Role::class, $user->roles->first());

    }

    /** @test */
    public function it_can_assign_roles()
    {	
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create(['name' => "role-test"]);
        $user->assignRole($role->name);
        $this->assertEquals("role-test" , $user->roles->first()->name);
    }

    /** @test */
    public function it_cant_assign_roles_that_doesnt_exists()
    {	
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();
        $user->assignRole("fake-role");
        $this->assertDatabaseMissing("role_user" , ['user_id' => $user->id]);
    }

    /** @test */
    public function it_has_member()
    {	
        $this->withoutExceptionHandling();
        $role = factory(Role::class)->create(['name' => 'member']);
        $user = factory(User::class)->create();
        $this->assertTrue($user->isMember());
    }

    /** @test */
    public function it_has_writter()
    {	
        $this->withoutExceptionHandling();
        $role = factory(Role::class)->create(['name' => 'writer']);
        $user = factory(User::class)->create();
        $user->assignRole('writer');
        $this->assertTrue($user->isWriter());
    }
    

}
