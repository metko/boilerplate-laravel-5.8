<?php

namespace Tests\Unit;

use App\Post;
use App\Role;
use App\User;
use App\Media;
use App\Comment;
use App\Profile;
use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\RoleFactory;
use Facades\Tests\Setup\UserFactory;
use Facades\Tests\Setup\CommentFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_role()
    {	
        $user = UserFactory::create();
        $this->assertInstanceOf(Role::class, $user->roles->first());
    }
    /** @test */
    public function a_user_has_admin_path()
    {
        $user = UserFactory::create();
        $this->assertEquals(route('admin.users.show', $user->id), $user->adminPath() );
    
    }

    /** @test */
    public function a_user_can_attach_roles()
    {	
        $user = UserFactory::create();
        $user->attachRole("moderator");
        $this->assertEquals("Moderator" , $user->roles->last()->name);
        $this->assertEquals(2 , $user->roles->last()->level);
        $this->assertCount(2, $user->roles);
    }

    /** @test */
    public function a_user_has_activate()
    {	
        $user = UserFactory::create();
        $user->activate();
        $this->assertEquals(1, $user->activated);

    }

    /** @test */
    public function a_user_has_desactivate()
    {	
        $user = UserFactory::create(['activated' => 1]);
        $user->desactivate();
        $this->assertEquals(0, $user->activated);
    }

    /** @test */
    public function a_user_has_has_role()
    {	
        $user = UserFactory::create();
        $this->assertTrue($user->hasRole('member'));
    }

    /** @test */
    public function a_user_has_has_level()
    {	
        $user = UserFactory::withRole('admin')->create();
        //dd($user->roles);
        $this->assertTrue($user->hasLevel(3));
    }

    /** @test */
    public function a_user_cant_attach_roles_that_doesnt_exists()
    {	
        $user = UserFactory::create();
        $user->attachRole("fake-role");
        $this->assertCount(1 , $user->roles);
    }

    /** @test */
    public function a_user_has_guest_level()
    {	
        $user = UserFactory::withRole('guest')->create();
        $this->assertTrue($user->isGuest());
        $writer = UserFactory::withRole('writer')->create();
        $this->assertTrue($writer->isGuest());
    }

    /** @test */
    public function a_user_has_moderator_level()
    {	
        $user = UserFactory::withRole('moderator')->create();
        $this->assertTrue($user->isModerator());
    }

    /** @test */
    public function a_user_has_writter_level()
    {	
        $user = UserFactory::withRole('writer')->create();
        $this->assertTrue($user->isWriter());        
    }

    /** @test */
    public function a_user_has_admin_level()
    {	
        $user = UserFactory::withRole('admin')->create();
        $this->assertTrue($user->isAdmin());
    }

    /** @test */
    public function a_user_has_superAdmin_level()
    {	
        $user = UserFactory::withRole('super-admin')->create();
        $this->assertTrue($user->isSuperAdmin());
    }

    /** @test */
    public function a_user_has_posts()
    {	
        $user = UserFactory::withRole('writer')->create();
        $post = PostFactory::ownedBy($user)->create();
        $this->assertInstanceOf(Post::class, $user->posts->first());
    }
    
    /** @test */
    public function a_user_has_gravatar()
    {	
        $user = UserFactory::withRole('writer')->create(); 
        $this->assertEquals($user->gravatar(), 'https://www.gravatar.com/avatar/' . md5($user->email) . '?d=mm&s=100');
    }

    /** @test */
    public function a_user_has_profile(){
        $user = UserFactory::create(); 
        $this->assertInstanceOf(Profile::class, $user->profile);
    }

    
    /** @test */
    public function a_user_has_remove_role()
    {
        $user = UserFactory::create();
        $user->attachRole('moderator');
        $this->assertCount(2, $user->roles);
        $this->assertTrue($user->hasRole('member'));
        $this->assertTrue($user->hasRole('moderator'));
        $user->removeRole('moderator');
        $this->assertFalse($user->hasRole('moderator'));
        $user->removeRole('member');
        $this->assertFalse($user->hasRole('member'));
        $this->assertCount(0, $user->roles);
    }

    /** @test */
    public function a_user_has_remove_all_role()
    {
        $user = UserFactory::create();
        $user->attachRole('moderator');
        $this->assertTrue($user->hasRole('member'));
        $this->assertTrue($user->hasRole('moderator'));
        $user->removeAllRole();
        $this->assertCount(0, $user->roles);
    }

    /** @test */
    public function a_user_has_comments()
    {	
        $user = UserFactory::create();
        $post = PostFactory::create();
        $post2 = PostFactory::create();
        $comments = CommentFactory::count(3)->withPost($post)->createdBy($user)->create();
        $comments = CommentFactory::count(2)->withPost($post2)->createdBy($user)->create();
        $this->assertInstanceOf(Comment::class, $user->comments->first());
        $this->assertEquals(5, $user->comments->count());
    }

    /** @test */
    public function a_user_have_medias()
    {
        $this->withoutExceptionHandling();
        $user = UserFactory::create();
        $media = factory(Media::class)->create(
            ['subject_type' => get_class($user), 'subject_id' => $user->id ]
        );
        //dd($user->medias); 
        $this->assertInstanceOf(Media::class, $user->medias->first());
    }


}
