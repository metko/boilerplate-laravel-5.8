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

    protected $roles = ['member', 'writer', 'admin', 'super_admin'];

    public function run()
    {   
        foreach($this->roles as $role){
            $user = factory(User::class)->create([
                    'name' => 'User '. $role,
                    'email' => $role .'@'.$role.'.com',
                    'password' => Hash::make('password')
            ]);
            $user->assignRole($role);
            $attributes = factory(Profile::class)->raw(['user_id' => $user->id]);
            $user->profile->update($attributes);
        }

        factory(User::class, 4)->create()->each(function ($user) {
            $user->assignRole('member');
            $attributes = factory(Profile::class)->raw(['user_id' => $user->id]);
            $user->profile->update($attributes);
        });

        
    
       
    }
}
