<?php

namespace Tests\Feature;

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
    public function a_guest_can_see_the_login_page()
    {	
        $this->get(route('login'))->assertStatus(200);
    }

    /** @test */
    public function a_guest_can_see_the_register_page()
    {	
        $this->get(route('register'))->assertStatus(200);
    }

    /** @test */
    public function a_register_user_cant_make_new_registration()
    {	
        $user = UserFactory::create();
        $attributes = factory(User::class)->raw();
        $this->actingAs($user)->post(route('register'))->assertStatus(302);
        $this->assertDatabaseMissing('users', ['name' => $attributes['name']]);
    }


    /** @test */
    public function a_user_can_have_multiple_roles()
    {	
        $user = UserFactory::create();
        $user->assignRole('writer');
        $this->assertCount(2, $user->roles);
    }

    /** @test */
    public function a_new_user_is_member_by_default()
    {	        
        $role = factory(Role::class)->create(['name' => 'member']);
        $attributes = [
            'name' => "toto",
            'email' => 'toto@toto.com',
            'password' => 'totototo',
            'password_confirmation' => 'totototo'
        ];
        $this->post('register', $attributes);
        $user = User::whereName($attributes['name'])->first();
        $this->assertTrue($user->isMember());
        
    }


}
