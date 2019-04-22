<?php

namespace Tests\Unit;

use App\Post;
use App\Role;
use App\User;
use App\Profile;
use Tests\TestCase;
use Facades\Tests\Setup\RoleFactory;
use Facades\Tests\Setup\PostFactory;
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
    public function it_can_attach_roles()
    {	
        $role = RoleFactory::create('role-test');
        $user = UserFactory::create();
        $user->attachRole("role-test");
        $this->assertEquals("role-test" , $user->roles->first()->slug);
        $this->assertEquals("Role-Test" , $user->roles->first()->name);
    }

    /** @test */
    public function has_activate()
    {	
        $user = UserFactory::withRole('member')->create();
        $user->activate();
        $this->assertEquals(1, $user->activated);

    }

    /** @test */
    public function has_desactivate()
    {	
        $user = UserFactory::withRole('member')->create(['activated' => 1]);
        $user->desactivate();
        $this->assertEquals(0, $user->activated);

    }

    /** @test */
    public function it_cannot_attach_twice_the_same_role()
    {	
        $user = UserFactory::withRole('role-test')->create();
        $user->attachRole('role-test');
        $this->assertCount(1 , $user->roles);
    }

    /** @test */
    public function it_has_has_role()
    {	
        $user = UserFactory::withRole('role-test')->create();
        $this->assertTrue($user->hasRole('role-test'));
    }

    /** @test */
    public function it_cant_attach_roles_that_doesnt_exists()
    {	
        $user = UserFactory::withRole('member')->create();
        $user->attachRole("fake-role");
        $this->assertCount(1 , $user->roles);
    }

    /** @test */
    public function it_has_member()
    {	
        $user = UserFactory::withRole('member')->create();
        $this->assertTrue($user->isMember());
    }

    /** @test */
    public function it_has_writter()
    {	
        $user = UserFactory::withRole('writer')->create();
        $this->assertTrue($user->isWriter());
    }

    /** @test */
    public function it_has_admin()
    {	
        $user = UserFactory::withRole('admin')->create();
        $this->assertTrue($user->isAdmin());
    }

    /** @test */
    public function it_has_superAdmin()
    {	
        $user = UserFactory::withRole('super_admin')->create();
        $this->assertTrue($user->isSuperAdmin());
    }

    /** @test */
    public function it_has_posts()
    {	
        $user = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($user)->create();
        $this->assertInstanceOf(Post::class, $user->posts->first());
    }
    
    /** @test */
    public function it_has_gravatar()
    {	
        $user = UserFactory::withRole('writer')->create(); 
        $this->assertEquals($user->gravatar(), 'https://www.gravatar.com/avatar/' . md5($user->email) . '?d=mm&s=100');
    }

    /** @test */
    public function it_has_profile(){
        $user = UserFactory::create(); 
        $this->assertInstanceOf(Profile::class, $user->profile);
    }

     

}
