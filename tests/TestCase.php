<?php

namespace Tests;

use App\Role;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function signIn($user = null) {
        
        $user = $user ?: factory(User::class)->create();
        $this->actingAs($user);
        return $user;
    }

}
