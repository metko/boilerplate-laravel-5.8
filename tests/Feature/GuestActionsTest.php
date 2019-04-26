<?php

namespace Tests\Feature;

use App\Post;
use App\Role;
use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Support\Facades\Hash;
use Facades\Tests\Setup\CommentFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuestActionsTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function a_guest_can_see_a_post()
    {	
        $guest = UserFactory::create();
        $post = PostFactory::create();
        $this->actingAs($guest)->get(route('posts.index'))
                ->assertStatus(200)
                ->assertSee($post->title);
    }

    /** @test */
    public function guest_cannot_manage_posts()
    {	
        $guest = UserFactory::create();
        $post = PostFactory::create();
        $this->actingAs($guest)->get(route('posts.create'))->assertStatus(403);

        // Can't post a post
        $this->actingAs($guest)->post(route('posts.store'), [
                'title' => 'Hello', 'body' => 'body', 'owner_id' => $guest->id
                ]
            )->assertStatus(403);

        // Can't update a post
        $this->actingAs($guest)->patch($post->path(), [
                'title' => 'Hello', 'body' => 'body'])
                ->assertStatus(403);
        $this->assertDatabaseMissing('posts', ['title' => 'Hello']);
           
        //Can't delete post
        $this->actingAs($guest)->delete($post->path())->assertStatus(403);
        $this->assertDatabaseHas('posts', ['title' =>  $post->title]);
    }


    /** @test */
    public function guest_can_create_a_comment()
    {	
        $this->withoutExceptionHandling();
        $user = UserFactory::create();
        $post = PostFactory::create();

        $this->actingAs($user)->post($post->path().'/comments', ['body' => 'This is a comment'] );
        $this->assertDatabaseHas('comments', ['body' => 'This is a comment']);
    }

    /** @test */
    public function guest_can_update_his_comment()
    {	
        $user = UserFactory::create();
        $comment = CommentFactory::createdBy($user)->create();

        $this->actingAs($user)->patch($comment->path(), ['body' => 'Comment changed'])
                ->assertRedirect($comment->post->path());
        $this->assertDatabaseHas('comments', ['body' => 'Comment changed']);
    }

    /** @test */
    public function guest_can_delete_his_comment()
    {	
        $user = UserFactory::create();
        $comment = CommentFactory::createdBy($user)->create();

        $this->actingAs($user)->delete($comment->path())->assertRedirect($comment->post->path());
        $this->assertDatabaseMissing('comments', ['body' => $comment->body]);   
    }

    /** @test */
    public function guest_cannot_manage_comments_of_others()
    {	
        $user = UserFactory::create();
        $post = PostFactory::withComments(2)->create();

        $comment = $post->comments->first();
        $this->actingAs($user)->patch($comment->path(),['body' => 'body changed']);
        $this->assertDatabaseMissing('comments', ['body' => 'body changed']);  

        $this->actingAs($user)->delete($comment->path());
        $this->assertDatabaseHas('comments', ['body' => $comment->body]);   
        $this->assertTrue($post->comments->contains($comment));
    }

    /** @test */
    public function guest_cannot_see_manage_posts_page()
    {	
        $member = UserFactory::create();
        $post = PostFactory::create();
        $this->actingAs($member)->get(route('manage.posts'))->assertStatus(403);
    }

    /** @test */
    public function guest_can_delete_his_account()
    {	       
        $member = UserFactory::create();
        $this->actingAs($member)->delete(route('profile.destroy'));
        $this->assertDatabaseMissing('users',['name' => $member->name]);
    }

    /** @test */
    public function guest_can_update_his_profile()
    {	
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
    public function guest_can_update_his_password()
    {	
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
    public function guest_cannot_update_his_password_without_the_old_password_confirmation()
    {	
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
