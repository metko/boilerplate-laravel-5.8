<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function only_admin_can_login_to_dahsboard()
    {
        $this->withoutExceptionHandling();
        $member = UserFactory::withRole('member')->create(['email'=>'member@test.com','password'=>bcrypt('member')]);
        $writer = UserFactory::withRole('writer')->create(['email'=>'writer@test.com','password'=>bcrypt('writer')]);
        $admin = UserFactory::withRole('admin')->create(['email'=>'admin@test.com','password'=>bcrypt('admin')]);
        $superAdmin = UserFactory::withRole('superAdmin')->create(['email'=>'superadmin@test.com','password'=>bcrypt('superadmin')]);

        $this->post(route('admin.login', ['email' => $admin->email, 'password' => 'admin']))
                ->assertstatus(302)
                ->assertRedirect(route('admin.dashboard'));
        auth()->logout();
        $this->post(route('admin.login', ['email' => $writer->email, 'password' => 'writer']))
                ->assertstatus(302)
                ->assertRedirect(route('home'));
        auth()->logout();
        $this->post(route('admin.login', ['email' => $writer->email, 'password' => 'writer']))
                ->assertstatus(302)
                ->assertRedirect(route('home'));
        
        // $this->post(route('admin.login', ['email' => $member->email, 'password' => 'member']))
        //         ->assertstatus(302);

    }

    /** @test */
    public function only_admin_can_access_to_dashboard()
    {	
        $this->withoutExceptionHandling();
        $member = UserFactory::withRole('member')->create(['email'=>'member@test.com','password'=>bcrypt('member')]);
        $writer = UserFactory::withRole('writer')->create(['email'=>'writer@test.com','password'=>bcrypt('writer')]);
        $admin = UserFactory::withRole('admin')->create(['email'=>'admin@test.com','password'=>bcrypt('admin')]);
        $superAdmin = UserFactory::withRole('superAdmin')->create(['email'=>'superadmin@test.com','password'=>bcrypt('superadmin')]);

        $this->actingAs($member)->get(route('admin.dashboard'))->assertStatus(302);
        $this->actingAs($writer)->get(route('admin.dashboard'))->assertStatus(302);
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertStatus(200);
        // $this->actingAs($superAdmin)->get(route('admin.dashboard'))->assertStatus(200);
    }


    /** @test */
    public function it_show_count_of_posts()
    {	
        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create();
        $posts = factory(Post::class, 10)->create();
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertSee('10');
    }

    /** @test */
    public function it_show_count_of_users()
    {	
        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create();
        $users = factory(User::class, 123)->create();
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertSee('124');
    }
}
