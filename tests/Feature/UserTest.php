<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Facades\Tests\Setup\RoleFactory;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_register_user_cannot_make_new_registration()
    {	
        $user = UserFactory::create();
        $attributes = factory(User::class)->raw();
        $this->actingAs($user)->post(route('register'))->assertStatus(302);
        $this->assertDatabaseMissing('users', ['name' => $attributes['name']]);
    }

    /** @test */
    public function a_user_can_have_multiple_roles()
    {	
        RoleFactory::create(['Member','Writer']);
        $user = UserFactory::withoutRole()->create();
        $user->attachRole(['Member','Writer']);
        $this->assertCount(2, $user->roles);
    }

    /** @test */
    public function a_new_user_is_member_by_default()
    {	    
        $role =  RoleFactory::create("Member");   
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

    /** @test */
    public function a_user_can_update_his_info()
    {	
        $writer = UserFactory::withRole('writer')->create();
        $attributes = [
            'email' => 'new@mail.com',
            'name' => 'new name'
        ];
        $this->actingAs($writer)->patch(route('profile.update', $attributes));
        $this->assertDatabasehas('users', [
            'name' => $attributes['name'],
            'email'=> $attributes['email']
        ]);
    }
    /** @test */
    public function a_user_can_update_his_password()
    {	
        $admin = UserFactory::withRole('admin')->create(['password' => Hash::make('oldpassword')]);
        $attributes = [
            'old_password' => 'oldpassword',
            'password' => 'newpassworddd',
            'password_confirmation' => 'newpassworddd'
        ];
    
        $this->actingAs($admin)->patch(route('profile.update.password', $attributes));
        $this->assertTrue(Hash::check($attributes['password'],$admin->password));

    }

    /** @test */
    public function a_user_cannot_update_his_password_without_the_old_password_confirmation()
    {	
        $member = UserFactory::withRole('member')->create(['password' => Hash::make('oldpasswordfake')]);
        $attributes = [
            'old_password' => 'oldpassword',
            'password' => 'newpassworddd',
            'password_confirmation' => 'newpassworddd'
        ];
        $this->actingAs($member)->patch(route('profile.update.password', $attributes))
                ->assertSessionHasErrors(['old_password']);
    }
    
}
