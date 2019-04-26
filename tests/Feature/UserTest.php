<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Permission;
use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\RoleFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Support\Facades\Hash;
use Facades\Tests\Setup\PermissionFactory;
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
    public function it_cannot_attach_twice_the_same_role()
    {	
        $user = UserFactory::withRole('moderator')->create();
        $user->attachRole('moderator');
        $this->assertCount(1 , $user->roles);
    }

    /** @test */
    public function a_user_can_have_multiple_differents_roles()
    {	
        $user = UserFactory::create();
        $user->attachRole(['Moderator','Writer']);
        $this->assertCount(3, $user->roles);
        $this->assertTrue($user->isGuest());
        $this->assertTrue($user->isModerator());
        $this->assertTrue($user->isWriter());
    }

    /** @test */
    public function a_new_user_is_level_0_by_default()
    {	  
        RoleFactory::create() ; 
        $attributes = [
            'name' => "toto",
            'email' => 'toto@toto.com',
            'password' => 'totototo',
            'password_confirmation' => 'totototo'
        ];
        $this->post('register', $attributes);
        $user = User::whereName($attributes['name'])->first();
        $this->assertTrue($user->hasLevel(1));
    }

    /** @test */
    public function a_user_can_update_his_info()
    {	
        $guest = UserFactory::create();
        $attributes = [
            'email' => 'new@mail.com',
            'name' => 'new name'
        ];
        $this->actingAs($guest)->patch(route('profile.update', $attributes));
        $this->assertDatabasehas('users', [
            'name' => $attributes['name'],
            'email'=> $attributes['email']
        ]);
    }
    /** @test */
    public function a_user_can_update_his_password()
    {	
        $user = UserFactory::create(['password' => Hash::make('oldpassword')]);
        $attributes = [
            'old_password' => 'oldpassword',
            'password' => 'newpassworddd',
            'password_confirmation' => 'newpassworddd'
        ];
    
        $this->actingAs($user)->patch(route('profile.update.password', $attributes));
        $this->assertTrue(Hash::check($attributes['password'],$user->password));

    }

    /** @test */
    public function a_user_cannot_update_his_password_without_the_old_password_confirmation()
    {	
        $user = UserFactory::create(['password' => Hash::make('oldpasswordfake')]);
        $attributes = [
            'old_password' => 'oldpassword',
            'password' => 'newpassworddd',
            'password_confirmation' => 'newpassworddd'
        ];
        $this->actingAs($user)->patch(route('profile.update.password', $attributes))
                ->assertSessionHasErrors(['old_password']);
    }


    /** @test */
    public function a_user_can_desactivate_his_account()
    {	
        $user = UserFactory::create();
        $this->actingAs($user)->post(route('account.desactivate'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'activated' => false]);
        $this->get(route('profile.index'))->assertStatus(500);
        //dd($user);
    }
    
}
