<?php

namespace Tests\Feature;

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
    public function a_admin_can_create_post(){
        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('admin')->create();
        //update post 
        $this->actingAs($user)
            ->post("/posts", ['title' => 'title', 'body' => "body"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title", 'body' => "body" ]);  
    }
    /** @test */
    public function a_admin_can_manage_a_post_from_others()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('admin')->create();
        $post = PostFactory::createdBy('writer')->create();
        //update post 
        $this->actingAs($user)
            ->patch($post->path(), ['title' => 'title changed', 'body' => "body changed"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title changed", 'body' => "body changed" ]);

        //delete post
        $this->actingAs($user)->delete($post->path());
        $this->assertDatabaseMissing('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_admin_can_add_comments(){

        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('admin')->create();
        $post = PostFactory::createdBy('writer')->create();
        
        //update post 
        $this->actingAs($user)
            ->post($post->path().'/comments', ['body' => 'Comment from admin'])
            ->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment from admin']);  
    }

    /** @test */
    public function a_admin_can_manage_any_comments(){

        $this->withoutExceptionHandling();
        $user = UserFactory::withRole('admin')->create();
        $post = PostFactory::createdBy('writer')->create();
        $comment = CommentFactory::withPost($post)->create();
        
        //update post 
        $this->actingAs($user)
            ->patch( $comment->path(), ['body' => 'Comment changed from admin'])->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment changed from admin']);  
    }

    /** @test */
    public function a_admin_can_update_his_info()
    {	
        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create();
        $attributes = [
            'email' => 'new@mail.com',
            'name' => 'new name'
        ];
        $this->actingAs($admin)->patch(route('admin.users.update', $admin->id), $attributes);
        $this->assertDatabasehas('users', [
            'name' => $attributes['name'],
            'email'=> $attributes['email']
        ]);
    }
    /** @test */
    public function a_admin_can_update_his_password()
    {	
        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create(['password' => Hash::make('oldpassword')]);
        $attributes = [
            'old_password' => 'oldpassword',
            'password' => 'newpassworddd',
            'password_confirmation' => 'newpassworddd'
        ];
        $this->actingAs($admin)->patch(route('admin.users.update.password',$admin->id), $attributes)
            ->assertSessionHasNoErrors(['old_password']);
        $this->assertDatabasehas('users', [
            'password' => $attributes['password'],
        ]);
        
    }

    /** @test */
    public function a_admin_cannot_update_his_password_without_oldpassword_confirmation()
    {	
        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create(['password' => Hash::make('oldpassssword')]);
        $attributes = [
            'old_password' => 'oldpassword',
            'password' => 'newpassworddd',
            'password_confirmation' => 'newpassworddd'
        ];
        $this->actingAs($admin)->patch(route('admin.users.update.password',$admin->id), $attributes)
            ->assertSessionHasErrors(['old_password']);
        $this->assertDatabaseMissing('users', [
            'password' => $attributes['password'],
        ]);
        
    }

    

    /** @test */
    public function a_admin_can_update_infos_of_others_account()
    {	
        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create();
        $member = UserFactory::withRole('member')->create();
        $attributes = [
            'email' => 'new@mail.com',
            'name' => 'new name'
        ];
        $this->actingAs($admin)->patch(route('admin.users.update', $member->id) , $attributes );
        $this->assertDatabasehas('users', [
            'name' => $attributes['name'],
            'email'=> $attributes['email']
        ]);
    }

    /** @test */
    public function a_admin_can_update_password_of_others_account()
    {	
        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create();
        $writer = UserFactory::withRole('writer')->create(['password' => Hash::make('oldpassword')]);
        $attributes = [
            'old_password' => 'oldpassword',
            'password' => 'newpassworddd',
            'password_confirmation' => 'newpassworddd'
        ];
        $this->actingAs($admin)->patch(route('admin.users.update.password', $writer->id), $attributes);
        $this->assertDatabasehas('users', [
            'password' => $attributes['password'],
        ]);
    }

    /** @test */
    public function a_admin_can_delete_accounts()
    {	
        $this->withoutExceptionHandling();
        $writer = UserFactory::withRole('writer')->create();
        $admin = UserFactory::withRole('admin')->create();
        $this->actingAs($admin)->delete(route('admin.users.destroy', $writer->id));
        $this->assertDatabaseMissing('users', ['name' => $writer->name]);
    }


}
