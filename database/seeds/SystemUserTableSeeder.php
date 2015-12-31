<?php

use Illuminate\Database\Seeder;
use App\Models\SystemUser;

class SystemUserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('system_users')->delete();

        SystemUser::create(['first_name' => 'Jason',
					  'last_name' => 'Bourne',
					  'mobile' => '03363274033',
					  'email' => 'jasonbourne501@gmail.com',
					  'password' => Hash::make('prova2016'),
					  'pic_path' => '',
					  'status' => 'active',
					  'code' => '',
        			]);
    }

}
