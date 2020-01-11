<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //role seeder
        if (($role = Role::where('name', '=', 'Software Developer')->first()) === null) {
            $role = Role::create([
                'name' => 'Software Developer'
            ]);
        }
		if (($role = Role::where('name', '=', 'Senior Software Developer')->first()) === null) {
            $role = Role::create([
                'name' => 'Senior Software Developer'
            ]);
        } 
		if (($role = Role::where('name', '=', 'Quality Analyst')->first()) === null) {
            $role = Role::create([
                'name' => 'Quality Analyst'
            ]);
        } 
		if (($role = Role::where('name', '=', 'Senior Quality Analyst')->first()) === null) {
            $role = Role::create([
                'name' => 'Senior Quality Analyst'
            ]);
        }
		if (($role = Role::where('name', '=', 'Team Lead')->first()) === null) {
            $role = Role::create([
                'name' => 'Team Lead'
            ]);
        } 		
    
    }
}
