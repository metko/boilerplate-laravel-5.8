<?php

namespace Tests\Unit;

use App\Post;
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
        $user = UserFactory::withRole("role-test")->create();
        $this->assertInstanceOf(Role::class, $user->roles->first());
    }

    /** @test */
    public function it_can_assign_roles()
    {	
        $role = factory(Role::class)->create(['name' => 'role-test']);
        $user = UserFactory::create();
        $user->assignRole("role-test");
        $this->assertEquals("role-test" , $user->roles->first()->name);
    }

    /** @test */
    public function it_cannot_assign_twice_the_same_role()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::create();
        $role = factory(Role::class)->create(['name' => 'role-test']);
        $user->assignRole('role-test');
        $user->assignRole('role-test');
        $this->assertCount(1 , $user->roles);
    }

    /** @test */
    public function it_has_already()
    {	
        $user = UserFactory::withRole('role-test')->create();
        $this->assertTrue($user->isActually('role-test'));
    }

    /** @test */
    public function it_cant_assign_roles_that_doesnt_exists()
    {	
        $user = UserFactory::create();
        $user->assignRole("fake-role");
        $this->assertCount(0 , $user->roles);
    }

    /** @test */
    public function it_has_member()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('member')->create();
        $this->assertTrue($user->isMember());
    }

    /** @test */
    public function it_has_writter()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('writer')->create();
        $this->assertTrue($user->isWriter());
    }

    /** @test */
    public function it_has_admin()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('admin')->create();
        $this->assertTrue($user->isAdmin());
    }

    /** @test */
    public function it_has_superAdmin()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('super-admin')->create();
        $this->assertTrue($user->isSuperAdmin());
    }

    /** @test */
    public function it_has_posts()
    {	
        $this->withoutExceptionHandling();
        $role = factory(Role::class)->create(['name' => 'member']);
        $user = UserFactory::withRole('writer')->create();
        $post = factory(Post::class)->create(['owner_id' => $user->id]);
        $this->assertInstanceOf(Post::class, $user->posts->first());
    }
    
    /** @test */
    public function it_has_gravatar()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('writer')->create(); 
        $this->assertEquals($user->gravatar(), 'https://www.gravatar.com/avatar/' . md5($user->email) . '?d=mm&s=100');
    }

}
