<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Support\Facades\Hash;
use Facades\Tests\Setup\CommentFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminActionsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function a_admin_can_see_all_the_posts_on_dashboard()
    {	
        $admin = UserFactory::withRole('admin')->create();
        $post = PostFactory::create();
        $this->actingAs($admin)->get(route('admin.posts.index'))->assertSee($post->title);
    }

    /** @test */
    public function a_admin_can_see_a_post_on_dashboard()
    {	
        $admin = UserFactory::withRole('admin')->create();
        $post = PostFactory::create();
        $this->actingAs($admin)->get($post->path('admin'))->assertSee($post->title);
    }

    /** @test */
    public function a_admin_can_create_post()
    {
        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create();
        //update post 
        $this->actingAs($admin)
            ->post("/posts", ['title' => 'title', 'body' => "body"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title", 'body' => "body" ]);
        
        $this->actingAs($admin)
            ->post(route('admin.posts.store'), ['title' => 'title changed', 'body' => "body changed"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title changed", 'body' => "body changed" ]); 
    }
    /** @test */
    public function a_admin_can_manage_a_post_from_others()
    {	
        $this->withoutExceptionHandling();

        $admin = UserFactory::withRole('admin')->create();
        $post = PostFactory::create();
        //update post 
        $this->actingAs($admin)
            ->patch($post->path(), ['title' => 'title changed', 'body' => "body changed"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title changed", 'body' => "body changed" ]);

        $this->actingAs($admin)
            ->patch($post->path('admin'), ['title' => 'title changed again', 'body' => "body changed again"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title changed again", 'body' => "body changed again" ]);
        //delete post
        $this->actingAs($admin)->delete($post->path());
        $this->assertDatabaseMissing('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_admin_can_add_comments()
    {
        $admin = UserFactory::withRole('admin')->create();
        $post = PostFactory::create();
        
        //update post 
        $this->actingAs($admin)
            ->post($post->path().'/comments', ['body' => 'Comment from admin'])
            ->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment from admin']);  
    }

    /** @test */
    public function a_admin_can_manage_any_comments()
    {
        $admin = UserFactory::withRole('admin')->create();
        $post = PostFactory::withComments(3)->create();
        //update post 
        $path = $post->comments->first()->path();
        $this->actingAs($admin)
            ->patch( $path, ['body' => 'Comment changed from admin'])->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment changed from admin']);  
    }

    /** @test */
    public function a_admin_can_update_infos_of_others_account()
    {	
        //$this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create();
        $guest = UserFactory::create();
        $attributes = [
            'email' => 'new@mail.com',
            'name' => 'new name',
            'first_name' => 'toto',
            'bio' => 'La bio de toto',
            'roles' => ['guest', 'moderator']
        ];

        $this->actingAs($admin)->patch(route('admin.users.update', $guest->id) , $attributes );
        $this->assertDatabasehas('users', [
            'name' => $attributes['name'],
            'email'=> $attributes['email'],
        ]);
        $this->assertDatabasehas('profiles', [
            'first_name' => $attributes['first_name'],
            'bio' => $attributes['bio']
        ]);
        $guest->refresh();
        $this->assertTrue($guest->hasRole('guest'));
        $this->assertTrue($guest->hasRole('moderator'));
    }

    /** @test */
    public function a_admin_can_update_password_of_others_account()
    {	
        $admin = UserFactory::withRole('admin')->create();
        $guest = UserFactory::create(['password' => Hash::make('oldpassword')]);
        $attributes = [
            'old_password' => 'oldpassword',
            'password' => 'newpassworddd',
            'password_confirmation' => 'newpassworddd'
        ];
        $this->actingAs($admin)->patch(route('admin.users.update.password', $guest->id), $attributes);
        $this->assertDatabasehas('users', [
            'password' => $attributes['password'],
        ]);
    }

    /** @test */
    public function a_admin_can_delete_accounts()
    {	
        $guest = UserFactory::create();
        $admin = UserFactory::withRole('admin')->create();
        $this->actingAs($admin)->delete(route('admin.users.destroy', $guest->id));
        $this->assertDatabaseMissing('users', ['name' => $guest->name]);
    }

    /** @test */
    public function a_admin_can_desactivate_an_account()
    {	
        $guest = UserFactory::create();
        $admin = UserFactory::withRole('admin')->create();
        $this->actingAs($admin)->post(route('admin.users.desactivate', $guest));
        $this->assertDatabaseHas('users', ['id' => $guest->id, 'activated' => false]);
    }

    /** @test */
    public function a_admin_can_create_user()
    {	
        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create();
        $attributes = [
            'name' => 'toto',
            'email' => 'toto@toto.com',
            'password' => 'totototo',
            'password_confirmation' => 'totototo',
            'first_name' => 'toto',
            'last_name' => 'toto',
            'location' => 'unknow',
            'bio' => 'voila une bio',
            'roles' => ['guest','writer','moderator']
        ];
        $this->actingAs($admin)->post(route('admin.users.store', $attributes));
        $user = User::whereName($attributes['name'])->first();
        $this->assertDatabaseHas('users', ['name' => $user->name]);
        $this->assertDatabaseHas('profiles', ['user_id' => $user->id, 'first_name' => $user->profile->first_name]);
        $this->assertTrue($user->hasRole( 'guest'));
        $this->assertTrue($user->hasRole( 'writer'));
        $this->assertTrue($user->hasRole( 'moderator'));
    }

    /** @test */
    public function a_admin_can_update_his_info()
    {	
        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create();
        $attributes = [
            'name' => 'toto',
            'email' => 'toto@toto.com',
            'password' => 'totototo',
            'password_confirmation' => 'totototo',
            'first_name' => 'toto',
            'last_name' => 'toto',
            'location' => 'unknow',
            'bio' => 'voila une bio',
            'roles' => ['guest','writer','moderator', 'admin']
        ];
        $this->actingAs($admin)->patch(route('admin.users.admin.update', $attributes));
        $this->assertDatabaseHas('users', ['name' =>  $attributes['name'], 'email' =>$attributes['email'] ]);
        $this->assertDatabaseHas('profiles', ['first_name' =>  $attributes['first_name'], 'location' =>$attributes['location'] ]);

    }
    
    

    


}
