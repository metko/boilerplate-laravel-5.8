<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    protected $roles = ['member', 'writer', 'admin', 'super-admin'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() 
    {
        foreach($this->roles as $role){
            factory(Role::class)->create(['name' => $role]);
        }
    }
}
