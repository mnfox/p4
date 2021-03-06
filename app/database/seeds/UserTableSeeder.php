// app/database/seeds/UserTableSeeder.php

<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		DB::table('users')->delete();
		User::create(array(
			'name'     => 'Test User',
			'username' => 'testuser',
			'email'    => 'test@user.com',
			'password' => Hash::make('testuser'),
		));
	}

}