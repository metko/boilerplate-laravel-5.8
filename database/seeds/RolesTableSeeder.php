<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    protected $roles = ['guest', 'member', 'moderator', 'writer', 'admin', 'super-admin'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() 
    {
        $i = 0;
        foreach($this->roles as $role){
            factory(Role::class)->create([
                'name' => ucfirst($role),
                'slug' => str_slug($role),
                'level' => $i,
                'description' => 'Description of '.$role.'.'
            ]);
            $i ++;
        }
    }
}
