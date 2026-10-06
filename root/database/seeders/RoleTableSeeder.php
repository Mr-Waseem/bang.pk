<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$role_admin = new Role();
		$role_admin->name = 'Admin';
		$role_admin->description = 'An Admin';
		$role_admin->save();

		$role_teacher = new Role();
		$role_teacher->name = 'Author';
		$role_teacher->description = 'A Teacher';
		$role_teacher->save();

		$role_student = new Role();
		$role_student->name = 'Editor';
		$role_student->description = 'A Normal User';
		$role_student->save();

		$role_student = new Role();
		$role_student->name = 'Center';
		$role_student->description = 'Collection Center';
		$role_student->save();

		$role_student = new Role();
		$role_student->name = 'Driver';
		$role_student->description = 'A Driver user';
		$role_student->save();

		$role_student = new Role();
		$role_student->name = 'Supervisor';
		$role_student->description = 'A Supervisor';
		$role_student->save();
	}
}
