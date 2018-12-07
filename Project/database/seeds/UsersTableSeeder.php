<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$data = [
            [
                'username' => 'trungtq6985',
                'email'    => 'trinhquangtrung_t59@hus.edu.vn',
                'password' => '123456',
                'last_name' => 'Trịnh Quang',
				'first_name' => 'Trung',
				'permissions' => [
					'admin' => true
				]
            ],
            [
                'username' => 'huynq6953',
                'email'    => 'trinhquangtrung1b@gmail.com',
                'password' => '123456',
				'last_name' => 'Nguyễn Quang',
				'first_name' => 'Huy',
				'permissions' => [

				]
            ],
            [
            	'username' => 'admin',
				'email'    => 'admin@gmail.com',
				'password' => '123456',
				'last_name' => 'Trịnh Công',
				'first_name' => 'Sơn',
				'permissions' => [
					'admin' => true
				]
		    ]
        ];

        foreach ($data as $user) {
            Sentinel::registerAndActivate($user);
        }
    }
}
