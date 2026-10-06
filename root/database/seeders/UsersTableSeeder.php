<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$role_admin = Role::where('name', 'Admin')->first();
		// $role_editor = Role::where('name', 'Editor')->first();
		// $role_author = Role::where('name', 'Author')->first();
		
		// $role_driver = Role::where('name', 'Driver')->first();
		// $role_center = Role::where('name', 'Center')->first();

		$admin = new User();
		$admin->company_id = '';
		$admin->name = 'Admin';
		$admin->email = 'ceo@itlifee.net';
		$admin->password = bcrypt('ceoitlife2020');
		// $admin->image = 'sammar.jpg';
		$admin->phone = '03xx xxxxxxx';
		$admin->address = 'LAHORE';
		$admin->status = 'Admin';
		$admin->type = 'ACTIVE';
		$admin->save();
		$admin->roles()->attach($role_admin);

	}
}
