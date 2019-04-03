<?php

namespace Tests\Unit;

use App\Role;
use App\User;
use Tests\TestCase;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_role()
    {	
        $user = UserFactory::create();
        $this->assertInstanceOf(Role::class, $user->roles->first());
    }

    /** @test */
    public function it_can_assign_roles()
    {	
        $user = UserFactory::withRole('role-test')->create();
        $this->assertEquals("role-test" , $user->roles->first()->name);
    }

    /** @test */
    public function it_cant_assign_roles_that_doesnt_exists()
    {	
        $user = UserFactory::create();
        $user->assignRole("fake-role");
        $this->assertCount(2 , $user->roles);
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
        $user = UserFactory::withRole('writer')->create();
        $this->assertTrue($user->isWriter());
    }
    

}
