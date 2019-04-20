<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Support\Facades\Hash;
use Facades\Tests\Setup\CommentFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberActionsTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function a_member_can_see_a_post()
    {	
        $user = UserFactory::create();
        $post = PostFactory::create();
        $this->actingAs($user)->get($post->path())
                ->assertStatus(200)
                ->assertSee($post->title);
    }

    /** @test */
    public function members_cannot_manage_posts()
    {	
        //Form to create a post
        $user = UserFactory::create();
        $post = PostFactory::create();
        $this->actingAs($user)->get('/posts/create')->assertStatus(403);

        //Can't a post
        $this->actingAs($user)->post('/posts', [
                'title' => 'Hello', 'body' => 'body', 'owner_id' => $user->id
                ]
            )->assertStatus(403);

        //Can't update a post
        $this->actingAs($user)->patch($post->path(), [
                'title' => 'Hello', 'body' => 'body'])
                ->assertStatus(403);
        $this->assertDatabaseMissing('posts', ['title' => 'Hello']);

        //Can't delete post
        $this->actingAs($user)->delete($post->path())->assertStatus(403);
        $this->assertDatabaseHas('posts', ['title' =>  $post->title]);
    }


    /** @test */
    public function a_member_can_create_a_comment()
    {	
        $user = UserFactory::create();
        $post = PostFactory::create();
       
        $this->actingAs($user)->post($post->path().'/comments', ['body' => 'This is a comment'] );
        $this->assertDatabaseHas('comments', ['body' => 'This is a comment']);
    }

    /** @test */
    public function a_member_can_update_his_comment()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::create();
        $comment = CommentFactory::createdBy($user)->create();

        $this->actingAs($user)->patch($comment->path(), ['body' => 'Comment changed'])
                ->assertRedirect($comment->post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment changed']);
    }

    /** @test */
    public function a_member_can_delete_his_comment()
    {	
        $user = UserFactory::create();
        $comment = CommentFactory::createdBy($user)->create();

        $this->actingAs($user)->delete($comment->path())->assertRedirect($comment->post->path());
        $this->assertDatabaseMissing('comments', ['body' => $comment->body]);   
    }

    /** @test */
    public function a_member_cannot_manage_comments_of_others()
    {	
        $user = UserFactory::create();
        $post = PostFactory::create();
        $comment = CommentFactory::withPost($post)->create();

        $this->actingAs($user)->patch($comment->path(),['body' => 'body changed']);
        $this->assertDatabaseMissing('comments', ['body' => 'body changed']);  

        $this->actingAs($user)->delete($comment->path());
        $this->assertDatabaseHas('comments', ['body' => $comment->body]);   
        $this->assertTrue($post->comments->contains($comment));
    }

    /** @test */
    public function a_member_cant_see_manage_posts_page()
    {	
        //$this->withoutExceptionHandling();
        $member = UserFactory::create();
        $post = PostFactory::create();
        $this->actingAs($member)->get(route('manage.posts'))->assertStatus(403);
    }

    /** @test */
    public function a_member_can_delete_his_account()
    {	
        $this->withoutExceptionHandling();
       
        $member = UserFactory::create();
        $this->actingAs($member)->delete(route('profile.destroy'));
        $this->assertDatabaseMissing('users',['name' => $member->name]);
    }

    /** @test */
    public function a_member_can_update_his_profile()
    {	
        $this->withoutExceptionHandling();
        $member = UserFactory::create();
        $attributes = [
            'email' => 'new@mail.com',
            'name' => 'new name',
            'first_name' => 'thomas',
            'location' => "brazil"
        ];
        $this->actingAs($member)->patch(route('profile.update', $attributes));
        $this->assertDatabasehas('users', [
            'name' => $attributes['name'],
            'email'=> $attributes['email']
        ]);
        $this->assertDatabasehas('profiles', [
            'first_name' => $attributes['first_name'],
            'location'=> $attributes['location']
        ]);
    }
    /** @test */
    public function a_member_can_update_his_password()
    {	
        $this->withoutExceptionHandling();
        $member = UserFactory::create(['password' => Hash::make('oldpassword')]);
        $attributes = [
            'old_password' => 'oldpassword',
            'password' => 'newpassworddd',
            'password_confirmation' => 'newpassworddd'
        ];
        $this->actingAs($member)->patch(route('profile.update.password', $attributes));
        $this->assertTrue(Hash::check($attributes['password'],$member->password));
    }

    /** @test */
    public function a_member_cannot_update_his_password_without_the_old_password_confirmation()
    {	
        $this->withoutExceptionHandling();
        $member = UserFactory::create(['password' => Hash::make('oldpasswordfake')]);
        $attributes = [
            'old_password' => 'oldpassword',
            'password' => 'newpassworddd',
            'password_confirmation' => 'newpassworddd'
        ];
        $this->actingAs($member)->patch(route('profile.update.password', $attributes))
                ->assertSessionHasErrors(['old_password']);
    }

    
   


}
