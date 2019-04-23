<?php

use App\User;
use App\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $roles = ['guest', 'moderator', 'writer', 'admin', 'super-admin'];

    public function run()
    {   
        foreach($this->roles as $role){
            $user = factory(User::class)->create([
                    'name' => 'User '. $role,
                    'email' => $role .'@'.$role.'.com',
                    'password' => Hash::make('password')
            ]);
            $user->attachRole($role);
            $attributes = factory(Profile::class)->raw(['user_id' => $user->id]);
            $user->profile->update($attributes);
        }

        factory(User::class, 4)->create()->each(function ($user) {
            $user->attachRole('guest');
            $attributes = factory(Profile::class)->raw(['user_id' => $user->id]);
            $user->profile->update($attributes);
        });

        
    
       
    }
}
