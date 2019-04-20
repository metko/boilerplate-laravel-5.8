<?php

use App\User;
use Illuminate\Database\Seeder;

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
            factory(User::class)->create([
                    'name' => 'Member '. $role,
                    'email' => $role .'@gmail.com',
                    'password' => bcrypt($role)
            ]);
        }

        $users = User::all();

        foreach($users as $user){
            $role = explode(' ', $user->name);
            if($role !=  'member'){
                $user->assignRole($role[1]);
            }
        }

        factory(User::class, 4)->create()->each(function ($user) {
            $user->assignRole('member');
        });
       
    }
}
