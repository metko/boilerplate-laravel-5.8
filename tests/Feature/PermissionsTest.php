<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\PostFactory;
use Facades\Tests\Setup\PermissionFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_permission_must_have_a_name()
    {	
        $permission = PermissionFactory::create(['name' => 'Permission Name']);
        $this->assertDatabaseHas('permissions', ['name' => 'Permission Name']);
    }

     /** @test */
     public function a_permission_must_have_a_slug()
     {	
         $permission = PermissionFactory::create(['slug' => 'create.edit']);
         $this->assertDatabaseHas('permissions', ['slug' => 'create.edit']);
     }

     /** @test */
     public function a_permission_must_have_a_description()
     {	
         $permission = PermissionFactory::create(['description' => 'description']);
         $this->assertDatabaseHas('permissions', ['description' => 'description']);
     }

     /** @test */
     public function a_permission_must_have_a_model()
     {	
         $post = PostFactory::create();
         $permission = PermissionFactory::create(['model' => get_class($post)]);
         $this->assertDatabaseHas('permissions', ['model' => 'App\Post']);
     }
}
