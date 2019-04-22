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
        $admin = UserFactory::withRole('admin')->create();
        //update post 
        $this->actingAs($admin)
            ->post("/posts", ['title' => 'title', 'body' => "body"]);
        $this->assertDatabaseHas('posts', ['title' =>  "title", 'body' => "body" ]);  
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

        //delete post
        $this->actingAs($admin)->delete($post->path());
        $this->assertDatabaseMissing('posts', ['title' =>  $post->title]);
    }

    /** @test */
    public function a_admin_can_add_comments(){

        $this->withoutExceptionHandling();
        $admin = UserFactory::withRole('admin')->create();
        $post = PostFactory::create();
        
        //update post 
        $this->actingAs($admin)
            ->post($post->path().'/comments', ['body' => 'Comment from admin'])
            ->assertRedirect($post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment from admin']);  
    }

    /** @test */
    public function a_admin_can_manage_any_comments(){

        $this->withoutExceptionHandling();
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
        $writer = UserFactory::withRole('writer')->create();
        $admin = UserFactory::withRole('admin')->create();
        $this->actingAs($admin)->delete(route('admin.users.destroy', $writer->id));
        $this->assertDatabaseMissing('users', ['name' => $writer->name]);
    }

    /** @test */
    public function a_admin_can_desactivate_an_account()
    {	
        $this->withoutExceptionHandling();
        $writer = UserFactory::withRole('writer')->create();
        $admin = UserFactory::withRole('admin')->create();
        $this->actingAs($admin)->post(route('admin.users.desactivate', $writer));
        $this->assertDatabaseHas('users', ['id' => $writer->id, 'activated' => false]);
    }


}
